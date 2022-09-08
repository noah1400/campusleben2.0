<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        //get all events that are not expired
        $events = Event::whereDate('end_date', '>=', Carbon::now())
        ->where('public', true)
        ->get();
        return view('events.index', compact('events'));
    }

    public function archive(){
        //get all events that are expired
        $events = Event::whereDate('end_date', '<', Carbon::now())->get();
        return view('events.archive', compact('events'));
    }

    /**
     * Shows all the events that the user is attending.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myevents(){
        $events = auth()->user()->events;
        return view('events.myevents', compact('events'));
    }





    public function attend(Request $request, $id)
    {
        $user = auth()->user();
        if ($user->events->contains($id)){
            return redirect()->route('events.myevents');
        }
        $event = Event::findOrFail($id);
        $user->events()->attach($event);
        return redirect()->route('events.myevents');
    }

    /**
     * Shows the event with the given id.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id){
        $event = Event::findOrFail($id);
        if ($event->public == false){
            // return 404
            if ( Auth::check() == false){
                abort(404);
            }else{
                if (Auth::user()->isAdmin == false){
                    abort(404);
                }
            }
        }
        //Convert date to format d.m.Y H:i
        $event->start_date = Carbon::parse($event->start_date)->format('d.m.Y H:i');
        $event->end_date = Carbon::parse($event->end_date)->format('d.m.Y H:i');

        return view('events.show', compact('event'));
    }

    public function close($id)
    {
        $event = Event::findOrFail($id);
        $event->closed = true;
        $event->save();
        return redirect()->route('events.show', ['id' => $id]);
    }

    public function open($id)
    {
        $event = Event::findOrFail($id);
        $event->closed = false;
        $event->save();
        return redirect()->route('events.show', ['id' => $id]);
    }

    public function delete($id){
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('events.index');
    }

    public function countUsers($id){

        $event = Event::findOrFail($id);
        if($event->public == false){
            if(Auth::check() == false){
                abort(404);
            }else{
                if(Auth::user()->isAdmin == false){
                    abort(404);
                }
            }
        }
        $users = $event->users;
        return response()->json(['count' => $users->count()]);
    }
}
