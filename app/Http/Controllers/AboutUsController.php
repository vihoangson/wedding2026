<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;

class AboutUsController extends Controller
{
    private const WEEKDAY_NAMES = [
        'Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy',
    ];

    /**
     * GET /about-us — elegant greenery-framed invitation profile card.
     */
    public function index()
    {
        $weddingDate = Carbon::createFromFormat('Y-m-d', config('wedding.wedding_date'));

        return view('about-us', [
            'weddingDayName' => self::WEEKDAY_NAMES[$weddingDate->dayOfWeek],
            'formattedDate' => $weddingDate->format('d . m . Y'),
        ]);
    }
}
