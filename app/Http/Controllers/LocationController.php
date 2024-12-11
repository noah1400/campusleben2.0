<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image',
        ]);
        $slug = Str::slug($request->name, '-');

        $loc = Location::where('slug', $slug)->first();
        if ($loc) {
            return response()->json([
                'message' => 'Location already exists',
                'status' => 'error',
            ], 400);
        }

        if ($request->page_content) {
            $page_content = $request->page_content;
        } else {
            $page_content = '-';
        }

        if (request()->hasFile('image')) {
            $image = $request->file('image')->store('public/locations');
            $imageURL = substr($image, 7);

            $manager = new ImageManager(new Driver);
            $manager->read(storage_path('app/public/'.$imageURL))
                ->scale(height: 1024)
                ->save(storage_path('app/public/'.$imageURL));

        } else {
            $imageURL = null;
        }

        $clickable = $request->clickable ? true : false;

        $location = Location::create([
            'name' => $request->name,
            'slug' => $slug,
            'page_content' => $page_content,
            'clickable' => $clickable,
            'image' => $imageURL,
        ]);

        return response()->json($location);

    }

    /**
     * Display the specified resource.
     */
    public function show(Str $slug): View
    {
        $location = Location::where('slug', $slug)->firstOrFail();
        if ($location->clickable) {
            $title = $location->name;
            $metaDescription = $location->page_content;
            if ($location->image) {
                $metaImage = asset('storage/'.$location->image);
            } else {
                $metaImage = null;
            }

            return view('location.show', compact('location', 'title', 'metaDescription', 'metaImage'));
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Str $slug): JsonResponse
    {

        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image',
        ]);
        $location = Location::where('slug', $slug)->firstOrFail();
        $location->name = $request->name;
        if ($request->page_content) {
            $location->page_content = $request->page_content;
        } else {
            $location->page_content = '-';
        }

        if (request()->hasFile('image')) {
            $image = $request->file('image')->store('public/locations');
            $imageURL = substr($image, 7);
            $manager = new ImageManager(new Driver);
            $manager->read(storage_path('app/public/'.$imageURL))
                ->scale(height: 1024)
                ->save(storage_path('app/public/'.$imageURL));

            if ($location->image) {
                if (file_exists(storage_path('app/public/'.$location->image))) {
                    unlink(storage_path('app/public/'.$location->image));
                }
            }

        } else {
            $imageURL = $location->image;
        }

        $location->image = $imageURL;

        $location->clickable = $request->clickable ? true : false;

        $location->slug = Str::slug($request->name, '-');
        $location->save();

        return response()->json($location);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Str $slug): JsonResponse
    {
        $location = Location::where('slug', $slug)->firstOrFail();
        $location->delete();

        return response()->json($location);
    }
}
