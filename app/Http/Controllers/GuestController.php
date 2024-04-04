<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Rules\ReCaptcha;

class GuestController extends Controller
{
    public function generateAndLoginGuest(Request $request)
    {
        // validate recaptcha
        $request->validate([
            'recaptcha' => ['required', new ReCaptcha],
        ]);
        // cancel if user is already logged in
        if (auth()->check()) {
            return response()->json([
                'code' => 'error',
                'msg' => 'User is already logged in.',
            ]);
        }
        $guest = new Authenticatable;
        $guest->name = 'Guest' . uniqid();
        $guest->email = 'guest' . uniqid() . '@example.com';
        $guest->password = bcrypt(uniqid());
        $guest->save();

        auth()->login($guest);

        return response()->json([
            'code' => 'success',
            'msg' => $guest,
        ]);
    }
}
