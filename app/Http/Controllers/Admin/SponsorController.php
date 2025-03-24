<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LOG;
use App\Models\Sponsor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class SponsorController extends Controller
{
    /**
     * Gets all sponsors
     *
     * @return \Illuminate\Http\JsonResponse list of sponsors
     */
    public function getAllSponsors(): JsonResponse
    {
        $sponsors = Sponsor::all();

        return response()->json($sponsors);
    }

    /**
     * Creates or updates a sponsor
     */
    private function createEditSponsor(Request $request, ?int $spons = null)
    {

        // extend validator url rule to allow äöüß
        // because äöüß are valid in german urls
        // https://stackoverflow.com/questions/28487089/laravel-url-validation-umlauts
        Validator::extend('url', function ($attribute, $value, $parameters, $validator) {
            $url = str_replace(['ä', 'ö', 'ü'], ['ae', 'oe', 'ue'], $value);

            return filter_var($url, FILTER_VALIDATE_URL);
        });

        if ($spons == null) {
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'image' => 'required|image',
                'link' => 'required|url',
                'active' => 'string',
            ]);
        } else {
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'image' => 'image',
                'link' => 'required|url',
                'active' => 'string',
            ]);
        }

        if ($spons == null) {
            $sponsor = new Sponsor;
        } else {
            $sponsor = Sponsor::findOrFail($spons);
        }
        $nameChanged = ($spons) ? $sponsor->name != $request->name : false;
        $sponsor->name = $request->name;
        $sponsor->link = $request->link;

        if ($spons == null) {
            $imageUrl = request()->file('image')->store('public/sponsors');
            $URL = substr($imageUrl, 7);

            $manager = new ImageManager(new Driver);
            $manager->read(storage_path('app/public/'.$URL))
                ->scale(width: 900)
                ->save(storage_path('app/public/'.$URL));

            $sponsor->image = $URL;
        } else {
            if (request()->has('image') && $sponsor->image != $request->image) {
                $imageUrl = request()->file('image')->store('public/sponsors');
                $URL = substr($imageUrl, 7);

                $manager = new ImageManager(new Driver);
                $manager->read(storage_path('app/public/'.$URL))
                    ->scale(width: 600)
                    ->save(storage_path('app/public/'.$URL));

                if (file_exists(storage_path('app/public/').$sponsor->image)) {
                    unlink(storage_path('app/public/').$sponsor->image);
                }
                $sponsor->image = $URL;
            }
        }

        if ($request->has('active')) {
            if ($request->active == 1 || $request->active == 'on') {
                $sponsor->active = true;
            } else {
                $sponsor->active = false;
            }
        } else {
            $sponsor->active = false;
        }

        if ($nameChanged) {
            $log = new LOG;
            $log->user_email = auth()->user()->email;
            $log->action = 'Sponsor name changed: '.$sponsor->name;
            $log->type = 'update';
            $log->save();
        }

        $sponsor->save();

        return response()->json($sponsor);
    }

    /**
     * Creates a new sponsor
     *
     * @return \Illuminate\Http\Response the created sponsor
     */
    public function createSponsor(Request $request)
    {
        return $this->createEditSponsor($request);
    }

    /**
     * Updates a sponsor
     *
     * @return \Illuminate\Http\Response the updated sponsor
     */
    public function editSponsor(Request $request, int $sponsor)
    {
        return $this->createEditSponsor($request, $sponsor);
    }

    /**
     * Deletes a sponsor
     *
     * @return \Illuminate\Http\JsonResponse the deleted sponsor
     */
    public function deleteSponsor(int $sponsor): JsonResponse
    {
        $sponsor = Sponsor::findOrFail($sponsor);
        $sponsor->delete();

        return response()->json($sponsor);
    }
}
