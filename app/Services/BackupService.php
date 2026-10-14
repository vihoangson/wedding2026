<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class BackupService
{
    private $dataDir;
    private $s3Disk;
    private $requiredFiles = [
        'data.json',
        'comments.json',
        'memories.json',
        'memory_comments.json',
    ];

    public function __construct()
    {
        $this->dataDir = storage_path('../data');
        $this->s3Disk = Storage::disk('s3');
    }

    /**
     * Backup missing JSON files to S3.
     * Checks if today's backups exist, uploads any missing files.
     *
     * @return array Status of each file backup attempt
     */
    public function backupMissingFiles(): array
    {
        $today = now()->format('Y-m-d');
        $results = [];

        foreach ($this->requiredFiles as $file) {
            $filePath = $this->dataDir . DIRECTORY_SEPARATOR . $file;
            $s3Path = "backups/{$today}/{$file}";

            // Skip if file doesn't exist locally
            if (!file_exists($filePath)) {
                $results[$file] = 'local_file_missing';
                continue;
            }

            // Check if backup already exists in S3 for today
            if ($this->s3Disk->exists($s3Path)) {
                $results[$file] = 'already_backed_up';
                continue;
            }

            // Upload file to S3
            try {
                $contents = file_get_contents($filePath);
                $this->s3Disk->put($s3Path, $contents);
                $results[$file] = 'backed_up';
            } catch (\Exception $e) {
                $results[$file] = 'backup_failed: ' . $e->getMessage();
            }
        }

        return $results;
    }

    /**
     * Get list of all backups by date.
     *
     * @return array Dates with available backups
     */
    public function listBackups(): array
    {
        try {
            $files = $this->s3Disk->files('backups');
            $dates = [];

            foreach ($files as $file) {
                if (preg_match('/backups\/(\d{4}-\d{2}-\d{2})\//', $file, $matches)) {
                    $dates[] = $matches[1];
                }
            }

            return array_unique($dates);
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Restore backup from S3 to local data directory.
     *
     * @param string $date Date in Y-m-d format
     * @return array Status of each file restore attempt
     */
    public function restoreFromBackup(string $date): array
    {
        $results = [];

        foreach ($this->requiredFiles as $file) {
            $s3Path = "backups/{$date}/{$file}";
            $localPath = $this->dataDir . DIRECTORY_SEPARATOR . $file;

            try {
                if (!$this->s3Disk->exists($s3Path)) {
                    $results[$file] = 'backup_not_found';
                    continue;
                }

                $contents = $this->s3Disk->get($s3Path);
                file_put_contents($localPath, $contents, LOCK_EX);
                $results[$file] = 'restored';
            } catch (\Exception $e) {
                $results[$file] = 'restore_failed: ' . $e->getMessage();
            }
        }

        return $results;
    }
}
