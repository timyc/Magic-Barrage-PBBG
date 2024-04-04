<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\SendMobBattle;
use App\Models\Character;
use App\Http\Controllers\MobController;

class AutoFightMobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $character;
    public $mobId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $character, int $mobId)
    {
        $this->character = $character;
        $this->mobId = $mobId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $char = Character::find($this->character);
        if ($char->actions_current > 0) {
            $char->actions_current--;
            $char->save();
            $battle = MobController::fightPlayer($char, $this->mobId);
            broadcast(new SendMobBattle($this->character, $battle));
            dispatch(new AutoFightMobs($this->character, $this->mobId))->delay(now()->addSeconds(5));
        } else {
            $char->action = 0;
            $char->save();
        }
    }
}
