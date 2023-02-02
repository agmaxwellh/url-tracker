<?php

namespace KaanTanis\UrlTracker;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use KaanTanis\UrlTracker\Commands\UrlTrackerCommand;

class UrlTrackerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('url-tracker')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations()
            ->hasMigrations([
                'create_url_tracker_table',
                'create_url_tracker_logs_table',
            ])
            ->hasCommand(UrlTrackerCommand::class);
    }
}
