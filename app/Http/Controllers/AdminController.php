<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\LOG;
use Illuminate\Http\Request;
use \Carbon\Carbon;
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
    public function dashboard()
    {
        return view('admin.dashboard');
    }






    /**
     * Api call to get all users
     * returns all users in paginated json format
     */
    public function showUsers()
    {
        $users = User::orderBy('isAdmin','desc')->orderBy('id')->paginate(50);
        return response()->json($users);
    }

    /**
     * Api call to get one single user
     * returns the user in json format
     * @param int $id
     */
    public function showUser($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }



    /**
     * Api call to get all events
     * returns all events in paginated json format
     */
    public function showEvents()
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
     * @param int $id
     */
    public function getEvent($id) {
        $event = Event::findOrFail($id);
        return response()->json($event);
    }

    /**
     * Api call to get all posts of one single event
     * returns all posts of one single event in json format
     */
    public function getPosts($id) {
        $posts = Event::findOrFail($id)->posts()->get()->toArray();
        return response()->json($posts);
    }

    /**
     * Api call to get all Events that a single user is attending
     * returns all events in json format
     * @param int $id
     */
    public function showUserEvents($id)
    {
        $user = User::findOrFail($id);
        $events = $user->events()->get()->toArray();
        return response()->json($events);
    }

    /**
     * Api call to create a new event
     * returns the new event in json format
     * @param Request $request
     */
    public function storeEvent(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'location' => 'required',
            'start_date' => ['required','date','date_format:d.m.Y H:i'],
            'end_date' => ['required','date','date_format:d.m.Y H:i','after_or_equal:start_date'],
            'limit' => 'integer',
            'preview_image' => 'image|nullable',
            'public' => 'string',
        ]);

        $event = new Event();
        $event->name = $request->name;
        $event->description = $request->description;
        $event->location = $request->location;
        $event->start_date = Carbon::createFromFormat('d.m.Y H:i', $request->start_date);
        $event->end_date = Carbon::createFromFormat('d.m.Y H:i', $request->end_date);
        if($request->has('pre_registration_enabled')){
            $event->pre_registration_enabled = true;
            if($request->has('team_registration_enabled')){
                $event->team_registration_enabled = true;
            }else{
                $event->team_registration_enabled = false;
            }
        }else{
            $event->pre_registration_enabled = false;
            $event->team_registration_enabled = false;
        }

        if($request->has('limit')){
            if($request->limit > 0){
                $event->limit = $request->limit;
            }else{
                $event->limit = 0;
            }
        } else {
            $event->limit = 0;
        }

        if (request()->hasFile('preview_image')) {
            $imageURL = request()->file('preview_image')->store('public/events');

            $parameters['image_url'] = substr($imageURL, 7);

            Image::configure(array('driver' => 'gd'));

            Image::make(storage_path('app/public/' . $parameters['image_url']))
                ->heighten(512)
                ->save(storage_path('app/public/' . $parameters['image_url']));

            $event->preview_image = $parameters['image_url'];

        }

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
        $log = new LOG();
        $log->user_email = auth()->user()->email;
        $log->action = 'Event created: '. $event->name;
        $log->type = "create";
        $log->save();

        return response()->json($event);
    }

    /**
     * Api call to update an event
     * returns the updated event in json format
     * @param Request $request
     * @param int $id
     */
    public function updateEvent(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'location' => 'required',
            'start_date' => ['required','date','date_format:d.m.Y H:i'],
            'end_date' => ['required','date','date_format:d.m.Y H:i','after_or_equal:start_date'],
            'preview_image' => 'image|nullable',
            'limit' => 'integer',
            'public' => 'string',
        ]);
        $nameChanged = false;
        $oldName = '';
        $event = Event::findOrFail($id);
        if($event->name != $request->name){
            $nameChanged = true;
            $oldName = $event->name;
        }
        $event->name = $request->name;
        $event->description = $request->description;
        $event->location = $request->location;
        $event->start_date = Carbon::createFromFormat('d.m.Y H:i', $request->start_date);
        $event->end_date = Carbon::createFromFormat('d.m.Y H:i', $request->end_date);
        if($request->has('pre_registration_enabled')){
            $event->pre_registration_enabled = true;
            if($request->has('team_registration_enabled')){
                $event->team_registration_enabled = true;
            }else{
                $event->team_registration_enabled = false;
            }
        }else{
            $event->pre_registration_enabled = false;
            $event->team_registration_enabled = false;
        }
        if($request->has('limit')){
            if($request->limit > 0){
                $event->limit = $request->limit;
            }else if($event->pre_registration_enabled){
                $event->limit = 0;
            }else{
                $event->limit = null;
            }
        }

        if (request()->hasFile('preview_image')) {
            $imageURL = request()->file('preview_image')->store('public/events');

            $parameters['image_url'] = substr($imageURL, 7);

            Image::configure(array('driver' => 'gd'));

            Image::make(storage_path('app/public/' . $parameters['image_url']))
                ->heighten(512)
                ->save(storage_path('app/public/' . $parameters['image_url']));

            $previousImage = $event->preview_image;
            //delete previous image
            if($previousImage != null){
                if(file_exists(storage_path('app/public/' . $previousImage))){
                    unlink(storage_path('app/public/' . $previousImage));
                }
            }

            $event->preview_image = $parameters['image_url'];

        }

        if ($request->has('public')) {
            if ($request->public == 1 || $request->public == 'on') {
                $event->public = true;
            } else {
                $event->public = false;
            }
        }else{
            $event->public = false;
        }

        // for now
        $event->closed = false;


        $event->save();
        if($nameChanged) {
            $log = new LOG();
            $log->user_email = auth()->user()->email;
            $log->action = 'Event name changed: ' . $oldName . ' to ' . $event->name;
            $log->type = "update";
            $log->save();
        }
        $log = new LOG();
        $log->user_email = auth()->user()->email;
        $log->action = 'Event updated: '. $event->name;
        $log->type = "update";
        $log->save();

        return response()->json($event);
    }

/**
 * Api call to delete an event
 * returns the deleted event in json format
 */
public function deleteEvent($id)
{
    $event = Event::findOrFail($id);
    $event->users()->detach();
    $posts = $event->posts;
    foreach ($posts as $post){
        $post->delete();
    }
    $n = $event->name;
    $event->delete();
    $log = new LOG();
    $log->user_email = auth()->user()->email;
    $log->action = 'Event deleted: '. $n;
    $log->type = 'delete';
    $log->save();
    return response()->json($event);
}

    /**
     * @deprecated
     *
     * Api call to close an Event
     * returns the closed event in json format
     * @param int $id
     */
    public function closeEvent($id)
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
     * @param int $id
     */
    public function openEvent($id)
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
    public function createPdf() {
        if(request('event', null) != null) {
            $event = Event::find(request('event'));
            $users = $event->users();
        } else {
            $users = User::all();
        }
        $data = [];
        $i = 0;
        foreach($users as $user) {
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
    public function getTimeline() {
        return LOG::orderBy('id', 'desc')->cursorPaginate(2);
    }


}
