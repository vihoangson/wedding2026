<?php

namespace App\Console\Commands;

use Database\Seeders\DemoDataSeeder;
use Illuminate\Console\Command;

class ClearDemoData extends Command
{
    protected $signature = 'wedding:clear-demo';

    protected $description = 'Remove the demo guests, RSVPs, wishes and memories added by DemoDataSeeder.';

    public function handle(): int
    {
        $deleted = DemoDataSeeder::clear();

        $this->table(['Table', 'Deleted'], collect($deleted)->map(fn ($n, $table) => [$table, $n])->values()->all());

        return self::SUCCESS;
    }
}
