<?php

use Illuminate\Support\Facades\Route;
use KaanTanis\UrlTracker\Http\Controllers\TrackerController;

Route::get(config('url-tracker.prefix') . '/{placeholder}', [TrackerController::class, 'show'])
    ->name('url-tracker.generated-url');

Route::post('url-tracker/generate-url/', [TrackerController::class, 'generateUrl'])
    ->name('url-tracker.generate-url');
