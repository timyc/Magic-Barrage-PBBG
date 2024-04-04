<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Character;
use App\Models\Item;
use App\Models\Mob;
use App\Events\SendCharacterInfo;
use App\Jobs\AutoFightMobs;

class CharacterController extends Controller
{
    public function create(Request $request) {
        // validate unique character name
        $request->validate([
            'name' => 'required|unique:characters,name|alpha_num',
            'mode' => 'required|integer|between:1,3',
            'raceId' => 'required|integer|between:1,10',
            'classId' => 'required|integer|between:1,8',
            'areaId' => 'required|integer|between:1,5',
        ]);
        $character = new Character;
        $character->name = $request->name;
        $character->mode = $request->mode;
        $character->race = $request->raceId;
        $character->class = $request->classId;
        $character->area = $request->areaId;
        $character->user_id = auth()->id();
        $character->save();
        return response()->json([
            'code' => 'success',
            'msg' => 'You successfully created a character.',
        ]);
    }
    public function retrieveCharacters(Request $request)
    {
        $characters = Character::where('user_id', auth()->id())->get(['id', 'name', 'race', 'class', 'level', 'mode']);
        // add list of character ids to session
        $request->session()->put('characters',$characters->pluck('id')->toArray());
        return response()->json($characters);
    }
    
    public function selectCharacter(Request $request)
    {
        $request->validate([
            'characterId' => 'required|integer|exists:characters,id',
        ]);
        $character = Character::find($request->characterId);
        if ($character->user_id != auth()->id()) {
            return response()->json([
                'code' => 'error',
                'msg' => 'You do not own this character.',
            ]);
        }
        $request->session()->put('characterId',$character->id);
        $request->session()->put('character', $character);
        return response()->json([
            'code' => 'success',
            'msg' => 'You successfully selected a character.',
        ]);
    }

    public function loadCharacterInfo(Request $request)
    {
        $character = Character::find($request->session()->get('characterId'));
        if ($character->user_id != auth()->id()) {
            return response()->json([
                'code' => 'error',
                'msg' => 'You do not own this character.',
            ]);
        }
        // select clan information where characters_clans.clan_id = clans.id
        $clan = DB::table('characters_clans')
            ->join('clans', 'characters_clans.clan_id', '=', 'clans.id')
            ->where('characters_clans.character_id', $character->id)
            ->select('clans.id', 'clans.name')
            ->first();
        if ($clan) {
            $request->session()->put('clan', $clan);
        } else {
            $request->session()->forget('clan');
        }
        $request->session()->put('equipment', $character->initEquipment());
        $equipments = DB::select('select * from characters_items where character_id = ?', [$character->id]);
        $items = [];
        foreach ($equipments as $equipment) {
            $item = Item::find($equipment->item_id);
            $item->equipped = $equipment->equipped;
            $item->quantity = $equipment->quantity;
            $item->quality = $equipment->quality;
            $items[] = $item;
            if ($equipment->equipped == 1) {
                $temp = $request->session()->get('equipment');
                $temp[$item->slot] = $item;
                $request->session()->put('equipment', $temp);
            }
        }
        // send character info to client
        broadcast(new SendCharacterInfo($character->id, $character, $clan, [
            'equipped' => $request->session()->get('equipment'),
            'all' => $items,
        ]));
        return response()->json([
            'code' => 'success',
            'msg' => 'You successfully loaded the character.',
        ]);
    }

    public function autoFight(Request $request)
    {
        $request->validate([
            'mobId' => 'required|integer|gte:0',
        ]);
        $character = Character::find($request->session()->get('characterId'));
        if ($character->action == 1) {
            return response()->json([
                'code' => 'error',
                'msg' => 'You are already fighting.',
            ]);
        }
        // OLD CODE
        // if ($character->area < 6) {
        //     if ($request->mobId > 20) {
        //         return response()->json([
        //             'code' => 'error',
        //             'msg' => 'You cannot fight this mob.',
        //         ]);
        //     }
        // } else {
        //     if ($request->mobId < ($character->area - 5) * 20 || $request->mobId > ($character->area - 4) * 20) {
        //         return response()->json([
        //             'code' => 'error',
        //             'msg' => 'You cannot fight this mob.',
        //         ]);
        //     }
        // }
        // NEW CODE
        $mob = Mob::findOrFail($request->mobId);
        if ($mob->area != $character->area) {
            return response()->json([
                'code' => 'error',
                'msg' => 'You cannot fight this mob.',
            ]);
        }
        $character->action = 1;
        $character->actions_current = $character->actions_max;
        $character->save();
        dispatch(new AutoFightMobs($character->id, $request->mobId));
        //Redis::del('magic_barrage_cache_:laravel_unique_job:App\Jobs\AutoFightMobs'.$request->session()->get('characterId'));
        return response()->json([
            'code' => 'success',
            'msg' => $character->actions_current,
        ]);
    }

    public function stopAutoFight(Request $request) {
        $character = Character::find($request->session()->get('characterId'));
        $character->actions_current = 0;
        $character->save();
        return response()->json([
            'code' => 'success',
            'msg' => 'You successfully stopped auto fighting.',
        ]);
    }

    public function restartAutoFight(Request $request) {
        $character = Character::find($request->session()->get('characterId'));
        if ($character->action == 0) {
            $this->autoFight($request);
        } else {
            $character->actions_current = $character->actions_max;
            $character->save();
            return response()->json([
                'code' => 'success',
                'msg' => 'You successfully restarted auto fighting.',
            ]);
        }
        
    }
}
