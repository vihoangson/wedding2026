<?php

namespace App\Services;

use App\Models\Setting;

/**
 * Image/video links editable from /dashboard/config, stored in the
 * settings table (key "media"). Values saved here override the defaults in
 * config/wedding.php (gallery_images, moments_images, wedding_video,
 * memorize cover/avatar).
 */
class MediaSettingsRepository
{
    public const SETTING_KEY = 'media';

    /**
     * Get the saved overrides (empty array when nothing has been saved yet).
     */
    public function get(): array
    {
        $data = Setting::getValue(self::SETTING_KEY, []);

        return is_array($data) ? $data : [];
    }

    /**
     * Persist the overrides and return what was written.
     */
    public function save(array $settings): array
    {
        $settings['last_updated'] = now()->format('Y-m-d H:i:s');

        Setting::setValue(self::SETTING_KEY, $settings);

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
