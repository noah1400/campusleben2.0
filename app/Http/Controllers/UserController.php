<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RequestStack;

class UserController extends Controller
{
    /**
     * Show saved data of authenticated user.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showdata(){
        $user = auth()->user();
        return view('userdata.showdata', compact('user'));
    }

    /**
     * Show the page for deleting saved data of authenticated user.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deletedataShow(){
        return view('userdata.deletedata');
    }

    /**
     * Delete saved data of authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletedata(Request $request){
        $user = auth()->user();
        $user->events()->detach();
        if($request->has('delete_account')){
            auth()->logout();
            $user->delete();
        }
        return redirect()->route('events.index');
    }

    public function isAuthenticated(){
        return response()->json(['auth' => auth()->check()]);
    }

    public function isAttending($event) {
        $ev = Event::findOrFail($event);
        if($ev->public == false){
            if(Auth::check() == false){
                abort(404);
            }else{
                if(Auth::user()->isAdmin == false){
                    abort(404);
                }
            }
        }
        $user = auth()->user();
        $attending = $user->events()->where('event_id', $event)->exists();
        return response()->json(['attending' => $attending]);
    }

    public function attendEvent($id) {
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
        $count = $event->users->count();
        $user = auth()->user();
        $attending = $user->events()->where('event_id', $id)->exists();

        // If the event is full, return error message.
        // If the limit is 0, there is no limit.
        if($count >= $event->limit && $event->limit != 0 && $attending == false){
            return response()->json(['error' => 'Event is full'], 422);
        }
        // If pre registration is disabled, return error message.
        if($event->pre_registration_enabled != true) {
            return response()->json(['error' => 'Pre-registration is not enabled'], 422);
        }
        // If event is closed, return error message.
        if($event->closed == true) {
            return response()->json(['error' => 'Event is closed'], 422);
        }
        $token = null;

        if($attending){
            $user->events()->detach($id);

            $registration = Registration::where('user_id', $user->id)->where('event_id', $id)->first();
            if ($registration != null){
                $registration->delete();
            }
        } else {
            $user->events()->attach($id);

            $registration = new Registration();
            $registration->user_id = $user->id;
            $registration->event_id = $id;
            $token = bin2hex(random_bytes(16));
            $registration->token = $token;
            $registration->save();
        }
        return response()->json(['attending' => !$attending,
                                    'count' => $count + ($attending ? -1 : 1),
                                    'token' => $token]);
    }
}
