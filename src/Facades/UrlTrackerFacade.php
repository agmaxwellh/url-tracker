<?php

namespace KaanTanis\UrlTracker\Facades;

use Illuminate\Support\Facades\Facade;
use KaanTanis\UrlTracker\UrlTracker;

/**
 * @see \KaanTanis\UrlTracker\UrlTracker
 * @method createUniqueCode
 */
class UrlTrackerFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return UrlTracker::class;
    }
}
