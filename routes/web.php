<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

# Player Routes

Route::get('/player/session', function () {
    return auth()->id() ? auth()->id() : -1;
});

Route::post('/player/create-guest', [App\Http\Controllers\GuestController::class, 'generateAndLoginGuest']);

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::post('/player/characters', [App\Http\Controllers\CharacterController::class, 'retrieveCharacters']);

    Route::post('/player/create-character', [App\Http\Controllers\CharacterController::class, 'create']);

    Route::post('/player/select-character', [App\Http\Controllers\CharacterController::class, 'selectCharacter']);

    Route::post('/player/character-info', [App\Http\Controllers\CharacterController::class, 'loadCharacterInfo']);

    Route::post('/player/get-all-messages', [App\Http\Controllers\ChatController::class, 'retrieveAllMessages']);

    Route::post('/player/send-chat-message', [App\Http\Controllers\ChatController::class, 'sendWorldChatMessage']);

    Route::post('/player/send-whisper-message', [App\Http\Controllers\ChatController::class, 'sendWhisperMessage']);

    Route::post('/player/send-clan-message', [App\Http\Controllers\ChatController::class, 'sendClanMessage']);

    Route::post('/player/auto-fight', [App\Http\Controllers\CharacterController::class, 'autoFight']);

    Route::post('/player/stop-auto-fight', [App\Http\Controllers\CharacterController::class, 'stopAutoFight']);

    Route::post('/player/restart-auto-fight', [App\Http\Controllers\CharacterController::class, 'restartAutoFight']);

    Route::post('/player/mobs', [App\Http\Controllers\MobController::class, 'getAreaMobs']);
});

Route::post('/logout', function () {
    Auth::logout();
    return response()->json(['msg' => 'Logged out']);
});

# Server Routes

Route::post('/server/motd', [App\Http\Controllers\ServerSettingsController::class, 'getMessageOfTheDay']);

# Vue Routes

Route::get('/{any?}', [App\Http\Controllers\SPAController::class, 'index'])->where('any', '(.*)');
