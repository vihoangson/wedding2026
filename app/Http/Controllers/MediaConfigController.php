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
            'momentsImages' => config('wedding.moments_images', []),
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
            'gallery' => ['nullable', 'array', 'max:5'],
            'gallery.*.url' => ['required', 'url', 'max:2048'],
            'gallery.*.alt' => ['nullable', 'string', 'max:255'],
            'gallery.*.featured' => ['nullable', 'boolean'],
            'moments' => ['nullable', 'array'],
            'moments.*.url' => ['required', 'url', 'max:2048'],
            'moments.*.alt' => ['nullable', 'string', 'max:255'],
            'moments.*.featured' => ['nullable', 'boolean'],
            'video.title' => ['nullable', 'string', 'max:255'],
            'video.subtitle' => ['nullable', 'string', 'max:255'],
            'video.youtube_url' => ['nullable', 'url', 'max:2048'],
            'video.thumbnail' => ['nullable', 'url', 'max:2048'],
            'memorize.cover_photo' => ['nullable', 'url', 'max:2048'],
            'memorize.avatar' => ['nullable', 'url', 'max:2048'],
        ], [
            'gallery.max' => 'Khung collage chỉ hiển thị tối đa 5 ảnh.',
            'gallery.*.url.required' => 'Vui lòng nhập link ảnh collage (hoặc xoá dòng trống).',
            'gallery.*.url.url' => 'Link ảnh collage không hợp lệ.',
            'moments.*.url.required' => 'Vui lòng nhập link ảnh "Khoảnh khắc" (hoặc xoá dòng trống).',
            'moments.*.url.url' => 'Link ảnh "Khoảnh khắc" không hợp lệ.',
            'video.youtube_url.url' => 'Link YouTube không hợp lệ.',
            'video.thumbnail.url' => 'Link ảnh thumbnail không hợp lệ.',
            'memorize.cover_photo.url' => 'Link ảnh bìa không hợp lệ.',
            'memorize.avatar.url' => 'Link ảnh đại diện không hợp lệ.',
        ]);

        $media->save([
            'gallery_images' => $this->normalizeImages($data['gallery'] ?? [], 'Ảnh khoảnh khắc cưới'),
            'moments_images' => $this->normalizeImages($data['moments'] ?? [], 'Khoảnh khắc của chúng tôi'),
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

    /**
     * Re-index submitted image rows and fill in a default alt text.
     */
    private function normalizeImages(array $images, string $altPrefix): array
    {
        $result = [];

        foreach (array_values($images) as $index => $image) {
            $result[] = [
                'url' => trim($image['url']),
                'alt' => trim($image['alt'] ?? '') ?: $altPrefix.' '.($index + 1),
                'featured' => (bool) ($image['featured'] ?? false),
            ];
        }

        return $result;
    }
}
