<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    // api call to verify a registration token for an event
    // returns true if the token is valid, false otherwise
    public function verify($token)
    {
        $registration = Registration::where('token', $token)->first();
        if ($registration) {
            $user = $registration->user;
            return response()->json(['verified' => true, 'user' => $user]);
        } else {
            return response()->json(['verified' => false]);
        }
    }
}
