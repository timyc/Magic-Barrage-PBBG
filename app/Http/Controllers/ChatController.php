<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorldChatMessage;
use App\Models\WhisperMessage;
use App\Models\ClanMessage;
use App\Models\AnnouncementMessage;
use App\Events\SendGlobalChatMessage;
use App\Events\SendWhisperMessage;
use App\Events\SendClanMessage;
use App\Models\Character;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('characterIsSelected');
    }

    public function sendWorldChatMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:255',
            'channel' => 'required|numeric|between:1,3',
        ]);
        $message = new WorldChatMessage;
        $message->message = $request->message;
        $message->char_id = $request->session()->get('characterId');
        $message->name = $request->session()->get('character')->name;
        $message->channel = $request->channel;
        $message->rank = $request->session()->get('character')->title;
        $message->access = $request->session()->get('character')->access;
        $message->gender = $request->session()->get('character')->gender;
        $message->save();
        broadcast(new SendGlobalChatMessage($message));
        return response()->json([
            'code' => 'success',
            'msg' => 'You successfully sent a message.',
        ]);
    }

    public function sendWhisperMessage(Request $request) {
        $request->validate([
            'message' => 'required|string|max:255',
            'receiver' => 'required|string|max:20',
        ]);
        // make sure receiver is not the same as sender
        if (strcasecmp($request->receiver, $request->session()->get('character')->name) == 0) {
            return response()->json([
                'code' => 'same_receiver',
                'msg' => 'Making friends is nice sometimes',
            ]);
        }
        $receiver = Character::where('name', $request->receiver)->first();
        if (!$receiver) {
            return response()->json([
                'code' => 'char_not_found',
                'msg' => 'The player you are trying to send a message to does not exist.',
            ]);
        }
        $message = new WhisperMessage;
        $message->message = $request->message;
        $message->sender_id = $request->session()->get('characterId');
        $message->sender_name = $request->session()->get('character')->name;
        $message->receiver_id = $receiver->id;
        $message->receiver_name = $receiver->name;
        $message->save();
        broadcast(new SendWhisperMessage($message));
        return response()->json([
            'code' => 'success',
            'msg' => 'You successfully sent a message.',
        ]);
    }

    public function sendClanMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:255',
        ]);
        // clan id might be null if the player is not in a clan
        if (!$request->session()->get('clan')) {
            return response()->json([
                'code' => 'not_in_clan',
                'msg' => 'You are not in a clan.',
            ]);
        }
        $message = new ClanMessage;
        $message->message = $request->message;
        $message->char_id = $request->session()->get('characterId');
        $message->char_name = $request->session()->get('character')->name;
        $message->clan_id = $request->session()->get('clan')->id;
        $message->save();
        broadcast(new SendClanMessage($message->clan_id, $message));
        return response()->json([
            'code' => 'success',
            'msg' => 'You successfully sent a message.',
        ]);
    }
        

    public function retrieveWorldChatMessages()
    {
        $messages = WorldChatMessage::orderBy('created_at', 'desc')->take(30)->get();
        return $messages;
    }

    public function retrieveWhisperMessages(Request $request)
    {
        // retrieve both sent and received whisper messages
        $messages = WhisperMessage::where('sender_id', $request->session()->get('characterId'))
            ->orWhere('receiver_id', $request->session()->get('characterId'))
            ->orderBy('created_at', 'desc')
            ->take(30)
            ->get();
        return $messages;
    }

    public function retrieveClanMessages(Request $request)
    {
        // clan id might be null if the player is not in a clan
        if (!$request->session()->get('clan')) {
            return [];
        }
        $messages = ClanMessage::where('clan_id', $request->session()->get('clan')->id)
            ->orderBy('created_at', 'desc')
            ->take(30)
            ->get();
        return $messages;
    }

    public function retrieveAnnouncementMessages()
    {
        $messages = AnnouncementMessage::orderBy('created_at', 'desc')->take(30)->get();
        return $messages;
    }

    public function retrieveAllMessages(Request $request) {
        $messages = [
            'world' => $this->retrieveWorldChatMessages(),
            'whisper' => $this->retrieveWhisperMessages($request),
            'clan' => $this->retrieveClanMessages($request),
            'announcement' => $this->retrieveAnnouncementMessages(),
        ];
        return response()->json($messages);
    }
}
