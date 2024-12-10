<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\Registration;

class RegistrationController extends Controller
{
    // api call to verify a registration token for an event
    // returns true if the token is valid, false otherwise
    public function verify($token): JsonResponse
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
