<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\LOG;
use App\Models\Sponsor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class EventController extends Controller
{
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
                $manager = new ImageManager(new Driver);
                $manager->read(storage_path('app/public/'.$parameters['image_url']))
                    ->scale(height: 1024)
                    ->save(storage_path('app/public/'.$parameters['image_url']));

                $event->preview_image = $parameters['image_url'];
            } else {
                $imageURL = request()->file('preview_image')->store('public/events');

                $parameters['image_url'] = substr($imageURL, 7);
                $manager = new ImageManager(new Driver);
                $manager->read(storage_path('app/public/'.$parameters['image_url']))
                    ->scale(height: 1536)
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
}
