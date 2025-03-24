<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    /**
     * Returns all locations
     */
    public function getLocations(): JsonResponse
    {
        $locations = Location::all();

        return response()->json($locations);
    }

    /**
     * Get location with given slug
     */
    public function getLocation(string $slug): JsonResponse
    {
        $location = Location::where('slug', $slug)->first();

        return response()->json($location);
    }
}
