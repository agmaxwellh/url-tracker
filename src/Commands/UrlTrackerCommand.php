<?php

namespace KaanTanis\UrlTracker\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class UrlTrackerCommand extends Command
{
    public $signature = 'install:url-tracker';

    public $description = 'Install the url-tracker package';

    public function handle(): int
    {
        // Publish the migrations
        Artisan::call('vendor:publish', [
            '--tag' => "url-tracker-migrations",
        ]);

        // Migration
        Artisan::call('migrate');

        $this->info('Migrations published and migrated successfully.');


        // Publish the config file
        Artisan::call('vendor:publish', [
            '--tag' => "url-tracker-config",
        ]);

        $this->info('Config file published successfully.');

        // Info
        $this->info('Url Tracker installed successfully.');
        $this->comment('All done. Enjoy!');

        return self::SUCCESS;
    }
}
