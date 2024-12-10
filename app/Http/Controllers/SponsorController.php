<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\Event;
use App\Models\Sponsor;
use Illuminate\Support\Facades\Auth;

class SponsorController extends Controller
{
    /**
     * Gets Sponsors of given event
     *
     * @return \Illuminate\Http\Response list of sponsors
     */
    public function getSponsors(Event $event)
    {

        if ($event->public == false) {
            // return 404
            if (Auth::check() == false) {
                abort(404);
            } else {
                if (Auth::user()->isAdmin == false) {
                    abort(404);
                }
            }
        }

        $sponsors = $event->sponsors()->get();

        return response()->json($sponsors);
    }

    /**
     * Gets active Sponsors
     *
     * @return \Illuminate\Http\Response list of sponsors
     */
    public function getActiveSponsors(): JsonResponse
    {
        $sponsors = Sponsor::where('active', true);

        return response()->json($sponsors);
    }

    /**
     * Gets Sponsor
     *
     * @return \Illuminate\Http\Response sponsor
     */
    public function getSponsor(Sponsor $sponsor): JsonResponse
    {
        return response()->json($sponsor);
    }
}
