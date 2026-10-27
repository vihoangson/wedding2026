<?php

namespace App\Http\Controllers;

use App\Services\InviteRepository;
use App\Services\XlsxWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * Dashboard guest list: bulk-generate personalized /invite/<token> links,
 * copy a ready-to-send Zalo message, and export everything to Excel.
 * All routes are protected by the dashboard.auth middleware.
 */
class DashboardInviteController extends Controller
{
    private const WEEKDAY_NAMES = [
        'Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy',
    ];

    /**
     * GET /dashboard/invites
     */
    public function index(InviteRepository $invites)
    {
        return response()->json([
            'invites' => array_map([$this, 'present'], array_reverse($invites->all())),
        ]);
    }

    /**
     * POST /dashboard/invites — body: { names: "one guest per line" }
     */
    public function store(Request $request, InviteRepository $invites)
    {
        $request->validate(
            ['names' => ['required', 'string', 'max:20000']],
            ['names.required' => 'Vui lòng nhập ít nhất một tên khách mời.']
        );

        $names = collect(preg_split('/\R/u', $request->input('names')))
            ->map(fn ($name) => mb_substr(trim(preg_replace('/\s+/u', ' ', $name)), 0, 100))
            ->filter()
            ->unique()
            ->values()
            ->all();

        if (! $names) {
            return response()->json(['error' => 'Vui lòng nhập ít nhất một tên khách mời.'], 422);
        }

        $result = $invites->addNames($names, config('wedding.inviter_secret_key'));

        return response()->json([
            'created' => count($result['created']),
            'existing' => count($result['existing']),
            'invites' => array_map([$this, 'present'], array_merge($result['created'], $result['existing'])),
        ]);
    }

    /**
     * DELETE /dashboard/invites/{token}
     */
    public function destroy(string $token, InviteRepository $invites)
    {
        if (! $invites->delete($token)) {
            return response()->json(['error' => 'Không tìm thấy khách mời'], 404);
        }

        return response()->json(['deleted' => true]);
    }

    /**
     * GET /dashboard/invites/export — download the guest list as .xlsx.
     */
    public function export(InviteRepository $invites)
    {
        $rows = [['STT', 'Tên khách mời', 'Link thiệp mời', 'Tin nhắn Zalo', 'Ngày tạo', 'Đã mở thiệp', 'Mở lần đầu', 'Số lần mở']];

        foreach ($invites->all() as $i => $invite) {
            $item = $this->present($invite);
            $rows[] = [
                $i + 1,
                $item['name'],
                $item['link'],
                $item['message'],
                $item['created_at'],
                ! empty($item['open_count']) ? 'Đã mở' : 'Chưa mở',
                $item['first_opened_at'] ?? '',
                $item['open_count'] ?? 0,
            ];
        }

        $path = XlsxWriter::write($rows, [6, 28, 60, 70, 20, 14, 20, 12], 'Khách mời');

        return response()
            ->download($path, 'danh-sach-khach-moi-'.now()->format('Ymd-His').'.xlsx', [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])
            ->deleteFileAfterSend();
    }

    /**
     * Shape an invite for the dashboard: adds the full link and the Zalo message.
     */
    private function present(array $invite): array
    {
        $link = route('invite.show', ['token' => $invite['token']]);

        return $invite + [
            'link' => $link,
            'message' => $this->zaloMessage($invite['name'], $link),
        ];
    }

    private function zaloMessage(string $name, string $link): string
    {
        $date = Carbon::createFromFormat('Y-m-d', config('wedding.wedding_date'));

        return implode("\n", [
            'Trân trọng kính mời '.$name.' đến dự lễ thành hôn của '
                .config('wedding.groom_name').' & '.config('wedding.bride_name').'.',
            '🕚 '.config('wedding.wedding_time').', '.self::WEEKDAY_NAMES[$date->dayOfWeek].' '.$date->format('d/m/Y'),
            '📍 '.config('wedding.venue_full_name').', '.config('wedding.venue_location'),
            '💌 Thiệp mời: '.$link,
            'Sự hiện diện của bạn là niềm vinh hạnh của gia đình chúng tôi!',
        ]);
    }
}
