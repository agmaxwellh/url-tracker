<?php

namespace KaanTanis\UrlTracker\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \KaanTanis\UrlTracker\UrlTracker
 * @method createUniqueCode
 */
class UrlTrackerFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \KaanTanis\UrlTracker\UrlTracker::class;
    }
}
