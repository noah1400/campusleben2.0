<?php

namespace App\Http\Controllers;

use AkkiIo\LaravelGoogleAnalytics\Facades\LaravelGoogleAnalytics;
use AkkiIo\LaravelGoogleAnalytics\Period;
use App\Models\Event;
use App\Models\Location;
use App\Models\LOG;
use App\Models\Sponsor;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Intervention\Image\ImageManagerStatic as Image;
use PDF;

class AdminController extends Controller
{
    /**
     * Admin Dasboard Cotroller
     * Controlls every api call related to admin dashboard
     */

    /**
     * Loads the admin dashboard
     */
    public function dashboard(): View
    {
        return view('admin.dashboard');
    }

    /**
     * Api call to get all users
     * returns all users in paginated json format
     */
    public function showUsers(): JsonResponse
    {
        $users = User::orderBy('isAdmin', 'desc')->orderBy('id')->paginate(50);

        return response()->json($users);
    }

    /**
     * Api call to get one single user
     * returns the user in json format
     */
    public function showUser(int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        return response()->json($user);
    }

    /**
     * Api call to get all events
     * returns all events in paginated json format
     */
    public function showEvents(): JsonResponse
    {
        $events = Event::orderBy('id')->paginate(50);
        // convert start_date and end_date to "d.m.Y H:i"
        foreach ($events as $event) {
            $event->start_date = Carbon::parse($event->start_date)
                ->locale('de')
            // example: (8.September 2022 15:00)
                ->isoFormat('dd. DD.MM.YYYY H:mm');
            $event->end_date = Carbon::parse($event->end_date)
                ->locale('de')
                ->isoFormat('dd. DD.MM.YYYY H:mm');
        }

        return response()->json($events);
    }

    /**
     * Api call to get one single event
     * returns the event in json format
     */
    public function getEvent(int $id): JsonResponse
    {
        $event = Event::findOrFail($id);
        $sponsors = $event->sponsors;

        return response()->json($event);
    }

    /**
     * Api call to get all posts of one single event
     * returns all posts of one single event in json format
     */
    public function getPosts($id): JsonResponse
    {
        $posts = Event::findOrFail($id)->posts()->get()->toArray();

        return response()->json($posts);
    }

    /**
     * Api call to get all Events that a single user is attending
     * returns all events in json format
     */
    public function showUserEvents(int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $events = $user->events()->get()->toArray();

        return response()->json($events);
    }

    private function createEditEvent(Request $request, ?int $ev = null)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'location' => 'required',
            'start_date' => ['required', 'date', 'date_format:d.m.Y H:i'],
            'end_date' => ['required', 'date', 'date_format:d.m.Y H:i', 'after_or_equal:start_date'],
            'limit' => 'integer',
            'preview_image' => 'image|nullable',
            'public' => 'string',
        ]);

        if ($ev == null) {
            $event = new Event;
        } else {
            $event = Event::findOrFail($ev);
        }
        $nameChanged = $ev ? $event->name != $request->name : false;
        $oldName = $nameChanged ? $event->name : null;
        $event->name = $request->name;
        $event->description = $request->description;
        $event->location = $request->location;
        $event->start_date = Carbon::createFromFormat('d.m.Y H:i', $request->start_date);
        $event->end_date = Carbon::createFromFormat('d.m.Y H:i', $request->end_date);

        if ($request->has('pre_registration_enabled')) {
            $event->pre_registration_enabled = true;
            if ($request->has('team_registration_enabled')) {
                $event->team_registration_enabled = true;
            } else {
                $event->team_registration_enabled = false;
            }
        } else {
            $event->pre_registration_enabled = false;
            $event->team_registration_enabled = false;
        }
        if ($request->has('limit')) {
            if ($request->limit > 0) {
                $event->limit = $request->limit;
            } elseif ($event->pre_registration_enabled) {
                $event->limit = 0;
            } else {
                $event->limit = null;
            }
        }

        if (request()->hasFile('preview_image')) {
            if ($ev == null) {
                $imageURL = request()->file('preview_image')->store('public/events');

                $parameters['image_url'] = substr($imageURL, 7);

                Image::configure(['driver' => 'gd']);

                Image::make(storage_path('app/public/'.$parameters['image_url']))
                    ->heighten(1024)
                    ->save(storage_path('app/public/'.$parameters['image_url']));

                $event->preview_image = $parameters['image_url'];
            } else {
                $imageURL = request()->file('preview_image')->store('public/events');

                $parameters['image_url'] = substr($imageURL, 7);

                Image::configure(['driver' => 'gd']);

                Image::make(storage_path('app/public/'.$parameters['image_url']))
                    ->heighten(1536)
                    ->save(storage_path('app/public/'.$parameters['image_url']));

                $previousImage = $event->preview_image;
                //delete previous image
                if ($previousImage != null) {
                    if (file_exists(storage_path('app/public/'.$previousImage))) {
                        unlink(storage_path('app/public/'.$previousImage));
                    }
                }

                $event->preview_image = $parameters['image_url'];
            }
        }

        // for now
        $event->closed = false;

        if ($request->has('public')) {
            if ($request->public == 1 || $request->public == 'on') {
                $event->public = true;
            } else {
                $event->public = false;
            }
        } else {
            $event->public = false;
        }

        $event->save();

        // $request->sponsors is json array of sponsor ids
        // try to decode it
        try {
            $sponsors = json_decode($request->sponsors);
        } catch (\Throwable $th) {
            // if it fails, return error
            return abort(400, 'Data not valid');
        }

        if ($ev) {
            // if event already exists, delete all sponsors
            $event->sponsors()->detach();
        }

        for ($i = 0; $i < count($sponsors); $i++) {
            $sponsor = Sponsor::findOr($sponsors[$i], function () {
                return null;
            });
            if ($sponsor != null) {
                $event->sponsors()->attach($sponsor);
            }
        }

        // LOG for event name update
        // LOG for update and creation will be executed in Model Event
        if ($nameChanged) {
            $log = new LOG;
            $log->user_email = auth()->user()->email;
            $log->action = 'Event name changed: '.$oldName.' to '.$event->name;
            $log->type = 'update';
            $log->save();
        }

        return response()->json($event);
    }

    /**
     * Api call to create a new event
     * returns the new event in json format
     */
    public function storeEvent(Request $request)
    {
        return $this->createEditEvent($request);
    }

    /**
     * Api call to update an event
     * returns the updated event in json format
     *
     * @param  int  $id
     */
    public function updateEvent(Request $request, int $event)
    {
        return $this->createEditEvent($request, $event);
    }

    /**
     * Api call to delete an event
     * returns the deleted event in json format
     */
    public function deleteEvent($id): JsonResponse
    {
        $event = Event::findOrFail($id);
        $n = $event->name;
        $event->delete(); // See deleting() method in Event

        return response()->json($event);
    }

    /**
     * @deprecated
     *
     * Api call to close an Event
     * returns the closed event in json format
     */
    public function closeEvent(int $id): RedirectResponse
    {
        $event = Event::findOrFail($id);
        $event->closed = true;
        $event->save();

        return redirect()->route('admin.events');
    }

    /**
     * @deprecated
     *
     * Api call to open an Event
     * returns the opened event in json format
     */
    public function openEvent(int $id): RedirectResponse
    {
        $event = Event::findOrFail($id);
        $event->closed = false;
        $event->save();

        return redirect()->route('admin.events');
    }

    /**
     * @deprecated
     * Api call to create pdf
     */
    public function createPdf()
    {
        if (request('event', null) != null) {
            $event = Event::find(request('event'));
            $users = $event->users();
        } else {
            $users = User::all();
        }
        $data = [];
        $i = 0;
        foreach ($users as $user) {
            $data[] = [
                'index' => $i,
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
                'city' => $user->city,
                'zip' => $user->zip,
                'country' => $user->country,
                'birthday' => $user->birthday,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ];
            $i++;
        }
        $pdf = PDF::loadView('admin.users.pdf', compact('data'));

        return $pdf->download('users.pdf');
    }

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

    /**
     * Gets all sponsors
     *
     * @return \Illuminate\Http\Response list of sponsors
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
            Image::configure(['driver' => 'gd']);
            Image::make(storage_path('app/public/').$URL)
                ->widen(900)
                ->save(storage_path('app/public/'.$URL));

            $sponsor->image = $URL;
        } else {
            if (request()->has('image') && $sponsor->image != $request->image) {
                $imageUrl = request()->file('image')->store('public/sponsors');
                $URL = substr($imageUrl, 7);
                Image::configure(['driver' => 'gd']);
                Image::make(storage_path('app/public/').$URL)
                    ->widen(600)
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
     * @return \Illuminate\Http\Response the deleted sponsor
     */
    public function deleteSponsor(int $sponsor): JsonResponse
    {
        $sponsor = Sponsor::findOrFail($sponsor);
        $sponsor->delete();

        return response()->json($sponsor);
    }

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
