<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Service\FlashMessageService;
use Carbon\Carbon;
use App\Models\Team;
use App\Models\Event;
use App\Models\Member;
use App\Models\MainGame;
use App\Models\Result;

class GameController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function result(Request $request)
    {
        $req = $request->session()->get('event');
        $event = Event::find($req);

        $defaultTeam = array();
        $member = null;
        // 参加している対戦表のチェック
        if (Auth::user()->role == config('user.role.member')) {
            $member = Member::join('teams', 'teams.id', 'members.team_id')
            ->where('event_id', $event->id)
            ->where('user_id', Auth::id())->first();
        }

        if ($member) {
            $selectSheet = $member->team->sheet;
            $selectBlock = $member->team->block;
            $selectTurn = $request->turn;
            $selectNum = $request->num;
            $conf = config('game.pre');
            if ($conf[$selectTurn]) {
                $defaultTeam[] = $conf[$selectTurn][$selectNum][0];
                $defaultTeam[] = $conf[$selectTurn][$selectNum][1];
            }
        } else {
            $selectSheet = $request->sheet;
            $selectBlock = $request->block;
            $selectTurn = $request->turn;
            $selectNum = $request->num;
            $conf = config('game.pre');
            if ($conf[$selectTurn]) {
                $defaultTeam[] = $conf[$selectTurn][$selectNum][0];
                $defaultTeam[] = $conf[$selectTurn][$selectNum][1];
            }
        }
        if (!$selectBlock) {
            $selectBlock = 'A';
        }
        if (!$selectSheet) {
            $selectSheet = 1;
        }
        if (!$selectTurn) {
            $selectTurn = 1;
        }

        $teams = Team::where('event_id', $event->id)
        ->where('block', $selectBlock)
        ->where('sheet', $selectSheet)
        ->get();

        $team1 = Team::where('event_id', $event->id)
        ->where('block', $selectBlock)
        ->where('sheet', $selectSheet)
        ->where('number', $defaultTeam[0])
        ->first();

        $team2 = Team::where('event_id', $event->id)
        ->where('block', $selectBlock)
        ->where('sheet', $selectSheet)
        ->where('number', $defaultTeam[1])
        ->first();

        $win = Result::where('win_team_id', $team1->id)
        ->where('lose_team_id', $team2->id)
        ->where('block', $selectBlock)
        ->where('sheet', $selectSheet)
        ->where('turn', $selectTurn)
        ->where('event_id', $event->id)
        ->first();
        $lose = Result::where('lose_team_id', $team1->id)
        ->where('win_team_id', $team2->id)
        ->where('block', $selectBlock)
        ->where('sheet', $selectSheet)
        ->where('turn', $selectTurn)
        ->where('event_id', $event->id)
        ->first();
        $data = null;
        if ($win) {
            $data = $win;
        } elseif ($lose) {
            $data = $lose;
        }
        return view('game.result', compact('selectSheet', 'selectBlock', 'selectTurn', 'teams', 'defaultTeam', 'data'));
    }

    public function resultStore(Request $request)
    {
        try {
            \DB::transaction(function() use($request) {

                $teams = $request->team;
                $scores = $request->score;
                $win_team = $teams[1];
                $lose_team = $teams[0];
                $win_score = $scores[1];
                $lose_score = $scores[0];
                if ($scores[1] < $scores[0]) {
                    $win_team = $teams[0];
                    $lose_team = $teams[1];
                    $win_score = $scores[0];
                    $lose_score = $scores[1];
                }

                $event = $request->session()->get('event');
                $id = $request->id;
                $data = Result::find($id);
                if (!$data) {
                    $data = new Result();
                }
                $data->event_id = $event;
                $data->user_id = Auth::id();
                $data->win_team_id = $win_team;
                $data->lose_team_id = $lose_team;
                $data->win_score = $win_score;
                $data->lose_score = $lose_score;
                $data->block = $request->block;
                $data->sheet = $request->sheet;
                $data->turn = $request->turn;
                $data->memo = $request->memo;
                $data->unearned_win = $request->unearned_win;
                $data->save();

            });

            FlashMessageService::success('報告が完了しました');

        } catch (\Exception $e) {
            report($e);
            FlashMessageService::error('報告が失敗しました');
        }

        return redirect()->route('tournament.index', ['block' => $request->block, 'sheet' => $request->sheet]);
    }

}
