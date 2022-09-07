<?php

namespace App\Http\Controllers;

use App\Models\Event;
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
        $count = $event->users()->count();
        $user = auth()->user();
        $attending = $user->events()->where('event_id', $id)->exists();
        if($attending){
            $user->events()->detach($id);
        } else {
            $user->events()->attach($id);
        }
        return response()->json(['attending' => !$attending,
                                    'count' => $count + ($attending ? -1 : 1)]);
    }
}
