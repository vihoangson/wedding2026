<?php

namespace App\Http\Controllers;

use App\Services\MediaSettingsRepository;
use Illuminate\Http\Request;

/**
 * /dashboard/config — lets the admin edit the image/video links of the
 * site (gallery, wedding video, /memorize cover + avatar) without
 * touching config/wedding.php. Saved to data/media.json.
 */
class MediaConfigController extends Controller
{
    /**
     * GET /dashboard/config
     */
    public function index(Request $request)
    {
        if (! $request->session()->get('dashboard_logged_in')) {
            return redirect()->route('dashboard.index');
        }

        return view('dashboard.config', [
            'galleryImages' => config('wedding.gallery_images', []),
            'video' => config('wedding.wedding_video', []),
            'memorize' => config('wedding.memorize', []),
        ]);
    }

    /**
     * POST /dashboard/config — protected by the dashboard.auth middleware.
     */
    public function update(Request $request, MediaSettingsRepository $media)
    {
        $data = $request->validate([
            'gallery' => ['nullable', 'array'],
            'gallery.*.url' => ['required', 'url', 'max:2048'],
            'gallery.*.alt' => ['nullable', 'string', 'max:255'],
            'gallery.*.featured' => ['nullable', 'boolean'],
            'video.title' => ['nullable', 'string', 'max:255'],
            'video.subtitle' => ['nullable', 'string', 'max:255'],
            'video.youtube_url' => ['nullable', 'url', 'max:2048'],
            'video.thumbnail' => ['nullable', 'url', 'max:2048'],
            'memorize.cover_photo' => ['nullable', 'url', 'max:2048'],
            'memorize.avatar' => ['nullable', 'url', 'max:2048'],
        ], [
            'gallery.*.url.required' => 'Vui lòng nhập link ảnh (hoặc xoá dòng trống).',
            'gallery.*.url.url' => 'Link ảnh không hợp lệ.',
            'video.youtube_url.url' => 'Link YouTube không hợp lệ.',
            'video.thumbnail.url' => 'Link ảnh thumbnail không hợp lệ.',
            'memorize.cover_photo.url' => 'Link ảnh bìa không hợp lệ.',
            'memorize.avatar.url' => 'Link ảnh đại diện không hợp lệ.',
        ]);

        $gallery = array_map(function (array $image, int $index) {
            return [
                'url' => trim($image['url']),
                'alt' => trim($image['alt'] ?? '') ?: 'Ảnh khoảnh khắc cưới '.($index + 1),
                'featured' => (bool) ($image['featured'] ?? false),
            ];
        }, array_values($data['gallery'] ?? []), array_keys(array_values($data['gallery'] ?? [])));

        $media->save([
            'gallery_images' => $gallery,
            'wedding_video' => [
                'title' => trim($data['video']['title'] ?? ''),
                'subtitle' => trim($data['video']['subtitle'] ?? ''),
                'youtube_url' => trim($data['video']['youtube_url'] ?? ''),
                'thumbnail' => trim($data['video']['thumbnail'] ?? ''),
            ],
            'memorize' => [
                'cover_photo' => trim($data['memorize']['cover_photo'] ?? ''),
                'avatar' => trim($data['memorize']['avatar'] ?? ''),
            ],
        ]);

        return redirect()->route('dashboard.config')->with('config_saved', 'Đã lưu cấu hình hình ảnh & video.');
    }
}
