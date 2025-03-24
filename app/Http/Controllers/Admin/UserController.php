<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use PDF;

class UserController extends Controller
{
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
     * Api call to get all Events that a single user is attending
     * returns all events in json format
     */
    public function showUserEvents(int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $events = $user->events()->get()->toArray();

        return response()->json($events);
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
}
