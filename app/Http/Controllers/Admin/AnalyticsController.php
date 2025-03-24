<?php

namespace App\Http\Controllers\Admin;

use AkkiIo\LaravelGoogleAnalytics\Facades\LaravelGoogleAnalytics;
use AkkiIo\LaravelGoogleAnalytics\Period;
use App\Http\Controllers\Controller;
use App\Models\LOG;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Api call to get timeline
     * returns the timeline in cursor paginated json format
     */
    public function getTimeline()
    {
        return LOG::orderBy('id', 'desc')->cursorPaginate(2);
    }

    /**
     * Api call to get most views per page
     * Over ga4 api
     */
    public function ga4_mostViewsByPage(): JsonResponse
    {
        $from = (request('days', null) != null
        && is_int(request('days', null))
        && request('days', -1) >= 0) ? Period::days(request('days')) : Period::days(7);
        $count = (request('count', null) != null
        && is_int(request('count', null))
        && request('count', -1) >= 0) ? request('count', 10) : 10;

        $res = LaravelGoogleAnalytics::getMostViewsByPage($from, $count);

        return response()->json($res);
    }

    /**
     * Api call to get views growth of views
     * between the date ranges 14 days ago and 7 days ago
     * and 7 days ago and today
     */
    public function ga4_lastWeekThisWeek(): JsonResponse
    {
        $lastWeekPeriod = Period::create(Carbon::today()->subDays(14), Carbon::today()->subDays(7));
        $thisWeekPeriod = Period::create(Carbon::today()->subDays(7), Carbon::today());

        $lastWeekResult = LaravelGoogleAnalytics::dateRange($lastWeekPeriod)
            ->metrics('activeUsers')
            ->get();
        $thisWeekResult = LaravelGoogleAnalytics::dateRange($thisWeekPeriod)
            ->metrics('activeUsers')
            ->get();

        return response()->json([
            'lastWeek' => $lastWeekResult,
            'thisWeek' => $thisWeekResult,
        ]);
    }
}
