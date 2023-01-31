<?php

namespace KaanTanis\UrlTracker;


use KaanTanis\Coderator\Coderator;
use KaanTanis\UrlTracker\Models\UrlTrackerTable;

class UrlTracker
{
    public function createUniqueCode(): string
    {
        $coderator = new Coderator();

        return $coderator->model(UrlTrackerTable::class)
            ->field('placeholder')
            ->generate();
    }
}
