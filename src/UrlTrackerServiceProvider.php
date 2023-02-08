<?php

namespace KaanTanis\UrlTracker;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use KaanTanis\UrlTracker\Commands\UrlTrackerCommand;
use Spatie\Referer\CaptureReferer;

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
            ->hasRoute('web')
            ->hasTranslations()
            ->hasMigrations([
                'create_url_tracker_table',
                'create_url_tracker_logs_table',
            ])
            ->hasCommand(UrlTrackerCommand::class);
    }

    /**
     * @throws BindingResolutionException
     */
    public function bootingPackage()
    {
        $router = $this->app->make(Router::class);

        $router->pushMiddlewareToGroup('web', CaptureReferer::class);
    }
}
