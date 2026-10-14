<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\BackupService;

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
        $this->initializeDataFiles();
        $this->backupToS3();
    }

    /**
     * Initialize missing data files from .example templates.
     * If a .json file doesn't exist but .json.example does, copy it.
     *
     * @return void
     */
    private function initializeDataFiles()
    {
        $dataDir = storage_path('../data');

        if (!is_dir($dataDir)) {
            return;
        }

        $requiredFiles = [
            'data.json',
            'comments.json',
            'memories.json',
            'memory_comments.json',
        ];

        foreach ($requiredFiles as $file) {
            $filePath = $dataDir . DIRECTORY_SEPARATOR . $file;
            $examplePath = $dataDir . DIRECTORY_SEPARATOR . $file . '.example';

            if (!file_exists($filePath) && file_exists($examplePath)) {
                copy($examplePath, $filePath);
            }
        }
    }

    /**
     * Backup JSON files to S3 if today's backups don't exist.
     *
     * @return void
     */
    private function backupToS3()
    {
        try {
            $backupService = new BackupService();
            $backupService->backupMissingFiles();
        } catch (\Exception $e) {
            // Silently fail - don't break app startup if S3 is unreachable
        }
    }
}
