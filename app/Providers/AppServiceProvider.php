<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
}
