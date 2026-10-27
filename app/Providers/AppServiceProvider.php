<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\BackupService;
use App\Services\MediaSettingsRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->backupToS3();
        $this->applyMediaSettings();
    }

    /**
     * Backup the database to S3 if today's backups don't exist.
     *
     * @return void
     */
    private function backupToS3()
    {
        try {
            $backupService = new BackupService();
            $backupService->backupMissingFiles();
        } catch (\Throwable $e) {
            // Silently fail - don't break app startup if S3 is unreachable
        }
    }

    /**
     * Apply the image/video links saved from /dashboard/config.
     *
     * @return void
     */
    private function applyMediaSettings()
    {
        try {
            (new MediaSettingsRepository())->applyToConfig();
        } catch (\Throwable $e) {
            // DB not reachable / not migrated yet (e.g. while running
            // `artisan migrate`): fall back to config/wedding.php defaults.
        }
    }
}
