<?php

namespace App\Services;

/**
 * File-based store (data/media.json) for the image/video links editable
 * from /dashboard/config. Values saved here override the defaults in
 * config/wedding.php (gallery_images, moments_images, wedding_video,
 * memorize cover/avatar).
 */
class MediaSettingsRepository
{
    protected string $file;

    public function __construct()
    {
        $dataDir = base_path('data');
        $this->file = $dataDir.DIRECTORY_SEPARATOR.'media.json';

        if (! is_dir($dataDir)) {
            mkdir($dataDir, 0755, true);
        }
    }

    /**
     * Get the saved overrides (empty array when nothing has been saved yet).
     */
    public function get(): array
    {
        if (! file_exists($this->file)) {
            return [];
        }

        $data = json_decode(file_get_contents($this->file), true);

        return is_array($data) ? $data : [];
    }

    /**
     * Persist the overrides and return what was written.
     */
    public function save(array $settings): array
    {
        $settings['last_updated'] = now()->format('Y-m-d H:i:s');

        file_put_contents(
            $this->file,
            json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            LOCK_EX
        );

        return $settings;
    }

    /**
     * Merge the saved overrides into the runtime config('wedding.*').
     */
    public function applyToConfig(): void
    {
        $settings = $this->get();

        foreach (['gallery_images', 'moments_images'] as $key) {
            if (array_key_exists($key, $settings)) {
                config(['wedding.'.$key => $settings[$key]]);
            }
        }

        if (isset($settings['wedding_video'])) {
            config(['wedding.wedding_video' => array_merge(
                config('wedding.wedding_video', []),
                $settings['wedding_video']
            )]);
        }

        if (isset($settings['memorize'])) {
            config(['wedding.memorize' => array_merge(
                config('wedding.memorize', []),
                $settings['memorize']
            )]);
        }
    }
}
