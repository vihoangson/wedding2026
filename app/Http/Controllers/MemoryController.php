<?php

namespace App\Http\Controllers;

use App\Services\MemoryRepository;
use Illuminate\Support\Carbon;

class MemoryController extends Controller
{
    private const WEEKDAY_NAMES = [
        'Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy',
    ];

    /**
     * GET /memorize — Facebook-style timeline of "our" memories.
     */
    public function index(MemoryRepository $memories)
    {
        $posts = array_map(function (array $post) use ($memories) {
            $date = Carbon::parse($post['date']);

            $post['formatted_date'] = self::WEEKDAY_NAMES[$date->dayOfWeek].', '.$date->format('d \t\h\á\n\g m, Y \l\ú\c H:i');
            $post['images'] = $post['images'] ?? [];
            $post['comments'] = $memories->getComments($post['id']);
            $post['comments_count'] = count($post['comments']);

            return $post;
        }, $memories->getTimeline());

        return view('memorize.index', [
            'profile' => config('wedding.memorize'),
            'posts' => $posts,
        ]);
    }
}
