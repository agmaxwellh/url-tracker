<?php

namespace KaanTanis\UrlTracker\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use KaanTanis\UrlTracker\Facades\UrlTrackerFacade;
use KaanTanis\UrlTracker\Models\UrlTrackerLogTable;
use KaanTanis\UrlTracker\Models\UrlTrackerTable;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Spatie\Referer\Referer;

class TrackerController extends Controller
{
    /** post requests */
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

        $created = $this->makeShortUrlCode($request);

        // return generated url
        return route('url-tracker.generated-url', [
            'placeholder' => $created->placeholder
        ]);
    }

    /** also for inside application calls */
    public function makeShortUrlCode($request, $created_by = null)
    {
        $request = (object)$request;
        $created_by = $created_by ?? auth()->id();

        if (! $request->tracked_url) {
            return response()->json([
                'status' => false,
                'message' => __('url-tracker::url-tracker.url-not-found')
            ]);
        }

        // create unique code
        $uniqueCode = UrlTrackerFacade::createUniqueCode();

        // save to database
        return UrlTrackerTable::query()->create([
            'created_by' => $created_by,
            'url' => $request->tracked_url,
            'placeholder' => $uniqueCode
        ]);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
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
                'referer' => app(Referer::class)->get(),
                'method' => request()->method(),
            ]);
        }

        // redirect to url
        return redirect()->to($urlFound->url);
    }
}
