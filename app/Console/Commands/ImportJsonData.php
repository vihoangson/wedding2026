<?php

namespace App\Console\Commands;

use App\Services\LegacyJsonStore;
use Illuminate\Console\Command;

class ImportJsonData extends Command
{
    protected $signature = 'wedding:import-json {--path= : Directory holding the legacy JSON files (default: data/)}';

    protected $description = 'Import the legacy data/*.json store (RSVPs, wishes, invites, memories, media) into the database. Safe to run more than once.';

    public function handle(LegacyJsonStore $store): int
    {
        $dir = $this->option('path') ?: base_path('data');
        $payloads = LegacyJsonStore::readDirectory($dir);

        if (! $payloads) {
            $this->warn("No legacy JSON files found in {$dir}.");

            return self::SUCCESS;
        }

        $this->line('Importing: '.implode(', ', array_keys($payloads)));

        $counts = $store->import($payloads);

        $this->table(['Table', 'Records'], collect($counts)->map(fn ($n, $table) => [$table, $n])->values()->all());
        $this->info('Done.');

        return self::SUCCESS;
    }
}
