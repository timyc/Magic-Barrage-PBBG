<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServerSettings;

class ServerSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getMessageOfTheDay()
    {
        $motd = ServerSettings::where('name', 'MOTD')->first();
        return response()->json([
            'MOTD' => $motd->value,
        ]);
    }
}
