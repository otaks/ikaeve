<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;

class TournamentController extends Controller
{
    public function changeTeam($team)
    {
        $result = array('status' => '', 'message' => '');
        try {

            $team = Team::find($team);
            $target = Team::where('event_id', $team->event_id)
            ->where('change_flg', 1)
            ->first();
            if (!$target) {
                $team->change_flg = 1;
                $team->update();
                $result = ['status' => 200, 'message' => '入れ替えるチームを選択して下さい'];
            } elseif($target->id == $team->id) {
                $team->change_flg = 0;
                $team->update();
                $result = ['status' => 200, 'message' => 'リセットしました'];
            } else {
                $block = $team->block;
                $sheet = $team->sheet;
                $number = $team->number;

                $team->block = $target->block;
                $team->sheet = $target->sheet;
                $team->number = $target->number;
                $team->update();

                $target->block = $block;
                $target->sheet = $sheet;
                $target->number = $number;
                $target->change_flg = 0;
                $target->update();
                $result = ['status' => 300, 'message' => $team->name.'と'.$target->name.'を入れ替えました'];
            }
        } catch (\Exception $e) {
            report($e);
            $result = ['status' => 400, 'message' => 'twitter名が無効です'];
        }
        return response()->json($result);
    }

}
