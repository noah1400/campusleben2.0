<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        //get all events that are not expired
        $events = Event::where('end_date', '>=', Carbon::now())
        ->where('public', true)
        ->orderBy('start_date', 'asc')
        ->get();

        foreach($events as $event){
            // format date of each event
            $event->start_date = Carbon::parse($event->start_date)
            ->locale('de')
            ->isoFormat('dd. DD.MM.YYYY H:mm');
            $event->end_date = Carbon::parse($event->end_date)
            ->locale('de')
            ->isoFormat('dd. DD.MM.YYYY H:mm');
            // shorten description
            $event->description = Str::limit($event->description, 80, '...');
            // remove line breaks
            $event->description = str_replace(array("\r", "\n"), ' ', $event->description);
        }
        return view('events.index', compact('events'));
    }

    public function archive(){
        //get all events that are expired
        //get all events that are not expired
        $events = Event::where('end_date', '<', Carbon::now())
        ->where('public', true)
        ->orderBy('start_date', 'desc')
        ->get();

        foreach($events as $event){
            // format date of each event
            $event->start_date = Carbon::parse($event->start_date)
            ->locale('de')
            ->isoFormat('dd. DD.MM.YYYY H:mm');
            $event->end_date = Carbon::parse($event->end_date)
            ->locale('de')
            ->isoFormat('dd. DD.MM.YYYY H:mm');
            // shorten description
            $event->description = Str::limit($event->description, 80, '...');
            // remove line breaks
            $event->description = str_replace(array("\r", "\n"), ' ', $event->description);
        }
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
        $event->start_date = Carbon::parse($event->start_date)
        ->locale('de')
        ->isoFormat('dd. DD.MM.YYYY H:mm');
        $event->end_date = Carbon::parse($event->end_date)
        ->locale('de')
        ->isoFormat('dd. DD.MM.YYYY H:mm');

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
