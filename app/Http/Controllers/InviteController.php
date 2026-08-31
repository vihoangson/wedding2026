<?php

namespace App\Http\Controllers;

use App\Services\InviterCodec;
use App\Services\RsvpRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class InviteController extends Controller
{
    private const WEEKDAY_NAMES = [
        'Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy',
    ];

    /**
     * Root "/" route: the original site only ever serves the invitation
     * through a personalized ?inviter=/ /invite/<token> link. Visiting the
     * bare homepage means the link is missing, so send the guest to the
     * waiting page — mirrors index.php's behaviour when $_GET['inviter']
     * is absent.
     */
    public function index()
    {
        return redirect()->route('waiting', ['reason' => 'missing']);
    }

    /**
     * GET /invite/{token} — decode the personalized token and render the
     * invitation, or bounce to the waiting page if the token is invalid.
     */
    public function show(string $token, RsvpRepository $rsvp)
    {
        $secretKey = config('wedding.inviter_secret_key');
        $decoded = InviterCodec::decode($token, $secretKey);

        if ($decoded === false || $decoded === '') {
            return redirect()->route('waiting', ['reason' => 'invalid']);
        }

        $guestName = $decoded;

        $weddingDate = Carbon::createFromFormat('Y-m-d', config('wedding.wedding_date'));

        return view('invite.show', [
            'guestName' => $guestName,
            'weddingDayName' => self::WEEKDAY_NAMES[$weddingDate->dayOfWeek],
            'formattedDate' => $weddingDate->format('d . m . Y'),
            'rsvpDeadline' => Carbon::createFromFormat('Y-m-d', config('wedding.rsvp_deadline'))->format('d.m.Y'),
            'activeComments' => $rsvp->getActiveComments(),
        ]);
    }

    /**
     * GET /waiting — shown when there is no (or an invalid) invite token.
     */
    public function waiting(Request $request)
    {
        $reason = $request->query('reason', 'missing');

        if ($reason === 'invalid') {
            $title = 'Link mời không hợp lệ';
            $message = 'Đường link bạn truy cập đã bị chỉnh sửa hoặc không còn đúng định dạng nên hệ thống không thể xác thực.<br>'
                .'Vui lòng sử dụng đúng nguyên vẹn đường link đã được gửi riêng để xem thiệp mời,'
                .' hoặc liên hệ trực tiếp với cô dâu / chú rể để được hỗ trợ.';
        } else {
            $title = 'Thiệp mời chưa sẵn sàng';
            $message = 'Rất tiếc, chúng tôi không tìm thấy thông tin lời mời hợp lệ dành cho bạn.<br>'
                .'Vui lòng sử dụng đúng đường link đã được gửi riêng để xem thiệp mời,'
                .' hoặc liên hệ trực tiếp với cô dâu / chú rể để được hỗ trợ.';
        }

        return view('invite.waiting', [
            'waitingTitle' => $title,
            'waitingMessage' => $message,
        ]);
    }
}
