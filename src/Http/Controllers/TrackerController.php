<?php

namespace KaanTanis\UrlTracker\Http\Controllers;

use Illuminate\Http\Request;
use KaanTanis\UrlTracker\Facades\UrlTrackerFacade;
use KaanTanis\UrlTracker\Models\UrlTrackerLogTable;
use KaanTanis\UrlTracker\Models\UrlTrackerTable;

class TrackerController extends Controller
{
    public function generateUrl(Request $request)
    {
        // if same url exists, return it
        $urlFound = UrlTrackerTable::query()->where('url', $request->tracked_url)
            ->first();

        if ($urlFound) {
            if ($urlFound->created_by == auth()->id() || $urlFound->created_by == null) {
                // this url before created by this user or anonymous. don't create new one
                return route('url-tracker.generated-url', [
                    'placeholder' => $urlFound->placeholder
                ]);
            }
        }

        // create unique code
        $uniqueCode = UrlTrackerFacade::createUniqueCode();

        // save to database
        $created = UrlTrackerTable::query()->create([
            'created_by' => auth()->id() ?? null,
            'url' => $request->tracked_url,
            'placeholder' => $uniqueCode
        ]);

        // return generated url
        return route('url-tracker.generated-url', [
            'placeholder' => $created->placeholder
        ]);
    }

    public function show($placeholder)
    {
        // find url by placeholder
        $urlFound = UrlTrackerTable::query()->where('placeholder', $placeholder)
            ->first();

        // check last 30 min same user visited this url
        $checkLastVisit = $urlFound->trackerLog()
            ->where('created_at', '>=', now()
                ->subMinutes(config('url-tracker.check-last-visit-minute')))
            ->where('ip_address', request()->ip())
            ->where('user_agent', request()->userAgent())
            ->first();

        if (! $checkLastVisit) {
            // increase view count
            $urlFound->timestamps = false;
            $urlFound->increment('count');

            // save log
            $urlFound->trackerLog()->create([
                // todo: if user logged in, save user id
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'referer' => request()->headers->get('referer'),
                'method' => request()->method(),
            ]);
        }

        // redirect to url
        return redirect()->to($urlFound->url);
    }
}
