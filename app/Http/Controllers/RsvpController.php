<?php

namespace App\Http\Controllers;

use App\Services\InviterCodec;
use App\Services\RsvpRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class RsvpController extends Controller
{
    /**
     * POST /api/rsvp — port of the original api/save-rsvp.php.
     * Validates the RSVP submission and appends it to data/data.json
     * (plus an inactive wish entry in data/comments.json).
     */
    public function store(Request $request, RsvpRepository $rsvp)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => ['required', 'string'],
            'phone' => ['nullable', 'string'],
            'guests' => ['required', 'integer', 'min:1', 'max:10'],
            'attend' => ['required', 'in:yes,no'],
            'message' => ['nullable', 'string'],
            'token' => ['nullable', 'string', 'max:500'],
        ], [
            'fullname.required' => 'Vui lòng nhập họ và tên',
            'guests.required' => 'Vui lòng nhập số người tham dự',
            'guests.min' => 'Số người tham dự phải từ 1 đến 10',
            'guests.max' => 'Số người tham dự phải từ 1 đến 10',
            'attend.required' => 'Vui lòng chọn tham dự hoặc không tham dự',
            'attend.in' => 'Vui lòng chọn tham dự hoặc không tham dự',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => null,
            ], 400);
        }

        $data = $validator->validated();

        // With a valid invite token the RSVP is tied to that guest: resending
        // updates their earlier answer, and the name comes from the token.
        $token = (string) ($data['token'] ?? '');
        $tokenName = $token !== '' ? InviterCodec::decode($token, config('wedding.inviter_secret_key')) : false;
        if ($tokenName === false || $tokenName === '') {
            $token = '';
        }

        $result = $rsvp->store([
            'token' => $token,
            'fullname' => $token !== '' ? $tokenName : trim($data['fullname']),
            'phone' => trim($data['phone'] ?? ''),
            'guests' => (int) $data['guests'],
            'attend' => $data['attend'],
            'message' => trim($data['message'] ?? ''),
            'ip_address' => $request->ip() ?? '',
            'user_agent' => substr($request->userAgent() ?? '', 0, 255),
        ]);

        $saved = $result['rsvp'];

        return response()->json([
            'success' => true,
            'message' => $result['updated']
                ? 'Đã cập nhật xác nhận tham dự của bạn.'
                : 'Cảm ơn bạn! Xác nhận tham dự đã được ghi nhận.',
            'data' => [
                'id' => $saved['id'],
                'fullname' => $saved['fullname'],
                'attend' => $saved['attend'],
                'guests' => $saved['guests'],
                'updated' => $result['updated'],
                'confirmed_at' => Carbon::parse($saved['updated_at'] ?? $saved['timestamp'])->format('H:i d/m/Y'),
            ],
        ]);
    }
}
