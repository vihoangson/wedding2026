<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

/**
 * Daily S3 backup of the wedding data, written in the legacy data/*.json
 * format (see LegacyJsonStore) so backups taken before the move to the
 * database can still be restored.
 */
class BackupService
{
    private $s3Disk;

    private LegacyJsonStore $store;

    public function __construct()
    {
        $this->s3Disk = Storage::disk('s3');
        $this->store = new LegacyJsonStore();
    }

    /**
     * Upload today's backup files that aren't on S3 yet.
     *
     * @return array Status of each file backup attempt
     */
    public function backupMissingFiles(): array
    {
        $today = now()->format('Y-m-d');
        $results = [];
        $missing = [];

        foreach (LegacyJsonStore::FILES as $file) {
            if ($this->s3Disk->exists("backups/{$today}/{$file}")) {
                $results[$file] = 'already_backed_up';
            } else {
                $missing[] = $file;
            }
        }

        if (! $missing) {
            return $results;
        }

        // Only export the database when something actually needs uploading.
        $payloads = $this->store->export();

        foreach ($missing as $file) {
            if (! isset($payloads[$file])) {
                $results[$file] = 'nothing_to_backup';
                continue;
            }

            try {
                $this->s3Disk->put(
                    "backups/{$today}/{$file}",
                    json_encode($payloads[$file], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                );
                $results[$file] = 'backed_up';
            } catch (\Exception $e) {
                $results[$file] = 'backup_failed: '.$e->getMessage();
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
            $files = $this->s3Disk->allFiles('backups');
            $dates = [];

            foreach ($files as $file) {
                if (preg_match('/backups\/(\d{4}-\d{2}-\d{2})\//', $file, $matches)) {
                    $dates[] = $matches[1];
                }
            }

            return array_values(array_unique($dates));
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Replace the database contents with the backup taken on $date.
     *
     * @param  string  $date  Date in Y-m-d format
     * @return array Number of records restored per table
     */
    public function restoreFromBackup(string $date): array
    {
        $payloads = [];

        foreach (LegacyJsonStore::FILES as $file) {
            $s3Path = "backups/{$date}/{$file}";
            if ($this->s3Disk->exists($s3Path)) {
                $payloads[$file] = json_decode($this->s3Disk->get($s3Path), true) ?? [];
            }
        }

        return $payloads ? $this->store->import($payloads, true) : [];
    }
}
