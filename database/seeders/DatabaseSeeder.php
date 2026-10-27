<?php

namespace Database\Seeders;

use App\Services\LegacyJsonStore;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * 1. Import the real data from the legacy data/*.json store (idempotent).
     * 2. On local only, add clearly-marked demo data to try the dashboard
     *    (remove it with `php artisan wedding:clear-demo`).
     *
     * @return void
     */
    public function run()
    {
        $payloads = LegacyJsonStore::readDirectory(base_path('data'));

        if ($payloads) {
            $counts = (new LegacyJsonStore())->import($payloads);
            $this->command?->info('Imported legacy JSON: '.json_encode($counts));
        }

        if (app()->environment('local')) {
            $this->call(DemoDataSeeder::class);
        }
    }
}
