<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Character;
use App\Models\Mob;

class MobController extends Controller
{
    public static function generateMobStats(Character $charInfo, int $mobId): array
    {
        $mob = Mob::find($mobId);

        $baseHP = $mob->hp * $charInfo->mode;
        $baseATK = $mob->atk * $charInfo->mode;
        $baseDEF = $mob->def * $charInfo->mode;
        $baseAGI = $mob->agi * $charInfo->mode; // evasion
        $baseACC = $mob->acc * $charInfo->mode;
        $coins = $mob->coins * $charInfo->mode;
        $exp = $mob->exp;

        $type = 1; // 1 = normal, 2 = merchant, 3 = veteran, 4 = royal, 5 = fool, 6 = psychic, 7 = assassin

        // 1% chance to get a rare mob
        if (rand(1, 100) == 1) {
            $type = rand(2, 7);
            switch ($type) {
                case 2:
                    $coins *= 4;
                    break;
                case 3:
                    $baseHP *= 2;
                    $baseATK *= 2;
                    $baseDEF *= 2;
                    $baseACC *= 2;
                    $exp *= 4;
                    $coins *= 2;
                    break;
                case 4:
                    $exp *= 2;
                    $coins *= 3;
                    break;
                case 5:
                    $baseATK /= 2;
                    $baseDEF /= 2;
                    $exp *= 2;
                    $coins *= 0;
                    break;
                case 6:
                    $baseAGI *= 3;
                    $exp *= 2;
                    $coins *= 2;
                    break;
                case 7:
                    $baseATK *= 3;
                    $exp *= 2;
                    $coins *= 3;
                    break;
            }
        }

        return [
            'id' => $mobId,
            'hp' => $baseHP,
            'atk' => $baseATK,
            'def' => $baseDEF,
            'agi' => $baseAGI,
            'acc' => $baseACC,
            'coins' => $coins,
            'exp' => $exp,
            'type' => $type,
            'area' => $mob->area < 6 ? 1 : $mob->area - 4,
            'race' => $mob->race,
            'element' => $mob->element,
        ];
    }

    public static function fightPlayer(Character $char, int $id): array
    {
        $mob = self::generateMobStats($char, $id);
        $player = [
            'id' => $char->id,
            'hp' => 50 * $char->level + 50 * $char->health * (($char->helmet / 10 + $char->torso / 10 + $char->leggings / 10) + 1),
            'atk' => 10 * $char->attack * (($char->main_hand / 10 + $char->off_hand / 10) + 1),
            'def' => 3 * $char->defense * (($char->gauntlets / 10 + $char->boots / 10 + $char->shoulders / 10) + 1),
            'agi' => $char->evasion,
            'acc' => $char->accuracy,
            'critp' => $char->crit_chance,
            'critd' => $char->crit_damage,
            'critr' => $char->crit_resistance,
            'multi' => $char->multiattack,
            'luck' => $char->luck,
        ];
        $playerMaxHP = $player['hp'];
        $playerDodges = 0;
        $playerCrits = 0;
        $playerHits = 0;
        $playerMisses = 0;
        $mobMaxHP = $mob['hp'];
        $mobDodges = 0;
        $mobCrits = 0;
        $mobHits = 0;
        $mobMisses = 0;
        // 50 round fight
        $i = 1;
        $flag = 0; // 0 = tie, 1 = player wins, 2 = mob wins
        for (; $i <= 50; $i++) {
            if (rand(1, 10000) <= $mob['agi']) {
                $mobDodges++;
            } else if (rand(1, 10000) <= $player['acc'] + 5000) {
                $playerMisses++;
            } else {
                // player attacks mob
                $mob['hp'] -= ($player['atk'] - $mob['def']) < 0 ? 0 : ($player['atk'] - $mob['def']);
                $playerHits++;
                // check if mob dead
                if ($mob['hp'] <= 0) {
                    $flag = 1;
                    break;
                }
            }

            if (rand(1, 10000) <= $player['agi']) {
                $playerDodges++;
            } else if (rand(1, 10000) <= $mob['acc'] + 5000) {
                $mobMisses++;
            } else {
                // mob attacks player
                $player['hp'] -= ($mob['atk'] - $player['def']) < 0 ? 0 : ($mob['atk'] - $player['def']);
                $mobHits++;
                // check if player dead
                if ($player['hp'] <= 0) {
                    $flag = 2;
                    break;
                }
            }
        }

        $statsArr = [
            'atk' => 0,
            'def' => 0,
            'agi' => 0,
            'acc' => 0,
            'hp' => 0,
            'lck' => 0,
        ];

        // player wins
        if ($flag == 1) {
            // calculate stat drops

            $mobStatBoost = $mob['id'];

            // First 5 starting areas are technically the same, so we need to modulate it
            if ($mob['id'] > 50 && $mob['id'] < 251) {
                // every 50 is a duplicate
                $mobStatBoost = $mob['id'] % 50;
                // if id = 100, 150, 200, 250, then we need to add 50
                if ($mobStatBoost == 0) {
                    $mobStatBoost += 50;
                }
            } else if ($mob['id'] >= 251) {
                $mobStatBoost -= 200;
            }
            
            $statsArr['atk'] += rand(1, max(1, $char->attack - ($char->luck / 10) - $mobStatBoost)) == 1 ? 1 : 0;
            $statsArr['def'] += rand(1, max(1, $char->defense - ($char->luck / 10) - $mobStatBoost)) == 1 ? 1 : 0;
            $statsArr['agi'] += + rand(1, max(1, $char->evasion - ($char->luck / 10) - $mobStatBoost)) == 1 ? 1 : 0;
            $statsArr['acc'] += rand(1, max(1, $char->accuracy - ($char->luck / 10) - $mobStatBoost)) == 1 ? 1 : 0;
            $statsArr['hp'] += rand(1, max(1, $char->health - ($char->luck / 10) - $mobStatBoost)) == 1 ? 1 : 0;
            $statsArr['lck'] += rand(1, max(1, $char->luck)) == 1 ? 1 : 0;

            // $char->refresh();
            // $char->coins += $mob['coins'];
            // $char->exp += $mob['exp'];
            // if ($char->exp >= $char->level * 30) {
            //     $char->level++;
            //     $char->exp = 0;
            // }

            // $char->attack += $statsArr['atk'];
            // $char->defense += $statsArr['def'];
            // $char->evasion += $statsArr['agi'];
            // $char->accuracy += $statsArr['acc'];
            // $char->health += $statsArr['hp'];
            // $char->luck += $statsArr['lck'];
            // $char->save();

            $char->exp += $mob['exp'];
            if ($char->exp >= $char->level * 30) {
                $char->level++;
                $char->exp = 0;
            }
            DB::update('UPDATE characters SET coins = coins + ?, level = ?, exp = ?, attack = attack + ?, defense = defense + ?, evasion = evasion + ?, accuracy = accuracy + ?, health = health + ?, luck = luck + ? WHERE id = ?', [$mob['coins'], $char->level, $char->exp, $statsArr['atk'], $statsArr['def'], $statsArr['agi'], $statsArr['acc'], $statsArr['hp'], $statsArr['lck'], $char->id]);
        }

        return [
            'actions' => $char->actions_current,
            'flag' => $flag,
            'rounds' => $i,
            'playerMaxHP' => $playerMaxHP,
            'playerHP' => $player['hp'],
            'playerDodges' => $playerDodges,
            'playerCrits' => $playerCrits,
            'playerHits' => $playerHits,
            'playerMisses' => $playerMisses,
            'mobMaxHP' => $mobMaxHP,
            'mobHP' => $mob['hp'],
            'mobDodges' => $mobDodges,
            'mobCrits' => $mobCrits,
            'mobHits' => $mobHits,
            'mobMisses' => $mobMisses,
            'coins' => $mob['coins'],
            'exp' => $mob['exp'],
            'type' => $mob['type'],
            'stats' => $statsArr,
        ];
    }

    public function getAreaMobs(Request $request) {
        $character = Character::find($request->session()->get('characterId'));
        $mobs = Mob::where('area', $character->area)->select('id', 'name')->get()->pluck('name', 'id');

        return response()->json($mobs);
    }
}
