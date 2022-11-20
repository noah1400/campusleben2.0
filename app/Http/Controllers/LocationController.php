<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'page_content' => 'required',
        ]);
        $slug = Str::slug($request->name, '-');

        $loc = Location::where('slug', $slug)->first();
        if ($loc) {
            return redirect()->back()->with('error', 'Location already exists');
        }

        $location = Location::create([
            'name' => $request->name,
            'slug' => $slug,
            'page_content' => $request->page_content,
        ]);

        return response()->json($location);

    }

    /**
     * Display the specified resource.
     *
     * @param  Str  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $location = Location::where('slug', $slug)->firstOrFail();
        return view('location.show', compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Str  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required',
            'page_content' => 'required',
        ]);
        $location = Location::where('slug', $slug)->firstOrFail();
        $location->name = $request->name;
        $location->page_content = $request->page_content;
        $location->slug = Str::slug($request->name, '-');
        $location->save();
        return response()->json($location);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Str  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $location = Location::where('slug', $slug)->firstOrFail();
        $location->delete();
        return response()->json($location);
    }
}
