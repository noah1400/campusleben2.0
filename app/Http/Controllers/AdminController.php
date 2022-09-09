<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Log;
use PDF;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::all();
        $events = Event::all();
        $posts = [];
        foreach ($events as $event) {
            $posts[] = $event->posts()->get()->toArray();
        }
        return view('admin.dashboard', compact('users', 'events', 'posts'));
    }

    // User functions

    // Show all users
    public function showUsers()
    {
        $users = User::orderBy('isAdmin','desc')->orderBy('id')->paginate(50);
        return response()->json($users);
    }

    // Show user by id
    public function showUser($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Event functions

    // Show all events
    public function showEvents()
    {
        $events = Event::orderBy('id')->paginate(50);
        // convert start_date and end_date to "d.m.Y H:i"
        Carbon::setLocale('de');
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

    // Show event by id
    public function getEvent($id) {
        $event = Event::findOrFail($id);
        return response()->json($event);
    }

    // Return Posts of Event
    public function getPosts($id) {
        $posts = Event::findOrFail($id)->posts()->get()->toArray();
        return response()->json($posts);
    }


    public function showUserEvents($id)
    {
        $user = User::findOrFail($id);
        $events = $user->events()->get()->toArray();
        return response()->json($events);
    }

    // Show form to create new event
    public function createEvent()
    {
        return view('admin.events.create');
    }

    // Store new event
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

        return redirect()->route('admin.events');
    }

    // Update event
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
        $event = Event::findOrFail($id);
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

        return response()->json($event);
    }

    // Delete event
public function deleteEvent($id)
{
    $event = Event::findOrFail($id);
    $event->users()->detach();
    $posts = $event->posts;
    foreach ($posts as $post){
        $post->delete();
    }
    $event->delete();
    return response()->json($event);
}

    // Close event
    public function closeEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->closed = true;
        $event->save();
        return redirect()->route('admin.events');
    }

    // Open event
    public function openEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->closed = false;
        $event->save();
        return redirect()->route('admin.events');
    }

    // Show event
    public function showEvent($id)
    {
        $event = Event::findOrFail($id);
        $users = $event->users();
        $users_count = $event->users()->count();
        return view('admin.events.show', compact('event', 'users_count'));
    }


    // Create pdf of users
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




}
