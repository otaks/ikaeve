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
        if (!$event) {
          return redirect()->route('event.index');
        }
        $mode = $request->mode;

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
        $left = null;
        $right = null;
        if ($win) {
            $data = $win;
        } elseif ($lose) {
            $data = $lose;
        }
        if ($data) {
            if ($data->winteam->number < $data->loseteam->number) {
                $left['name'] = $data->winteam->name;
                $left['id'] = $data->winteam->id;
                $left['number'] = $data->winteam->number;
                $left['score'] = $data->win_score;
                $left['unearned_win'] = $data->unearned_win;
                $right['name'] = $data->loseteam->name;
                $right['id'] = $data->loseteam->id;
                $right['number'] = $data->loseteam->number;
                $right['score'] = $data->lose_score;
                $right['unearned_win'] = $data->unearned_win;
            } else {
                $right['name'] = $data->winteam->name;
                $right['id'] = $data->winteam->id;
                $right['number'] = $data->winteam->number;
                $right['score'] = $data->win_score;
                $right['unearned_win'] = $data->unearned_win;
                $left['name'] = $data->loseteam->name;
                $left['id'] = $data->loseteam->id;
                $left['number'] = $data->loseteam->number;
                $left['score'] = $data->lose_score;
                $left['unearned_win'] = $data->unearned_win;
            }
        }

        return view('game.result',
            compact('selectSheet',
                    'selectBlock',
                    'selectTurn',
                    'team1',
                    'team2',
                    'defaultTeam',
                    'data',
                    'left',
                    'right',
                    'mode',
                    'event',
                  ));
    }

    public function resultStore(Request $request)
    {
        if ($request->mode == 'app') {
            $str = '承認';
        } else {
            $str = '報告';
        }
        try {
            \DB::transaction(function() use($request, $str) {

                if ($request->mode == 'app') {
                  $id = $request->id;
                  $data = Result::find($id);
                  $data->approval = '1';
                } else {
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
                    if (Auth::user()->role != config('user.role.member')) {
                        $data->approval = '1';
                    }
                    $data->unearned_win = $request->unearned_win;
                }
                $data->save();

            });

            FlashMessageService::success($str . 'が完了しました');

        } catch (\Exception $e) {
            report($e);
            FlashMessageService::error($str . 'が失敗しました');
        }

        return redirect()->route('tournament.index', ['block' => $request->block, 'sheet' => $request->sheet]);
    }

    public function delete(Request $request)
    {
        try {
            \DB::transaction(function() use($request) {

                $data = Result::find($request->id);
                $data->delete();
            });

            FlashMessageService::success('削除が完了しました');

        } catch (\Exception $e) {
            report($e);
            FlashMessageService::error('削除が失敗しました');
        }

        return redirect()->route('tournament.index', ['block' => $request->block, 'sheet' => $request->sheet]);
    }

    public function resultlist(Request $request)
    {
        $req = $request->session()->get('event');
        $event = Event::find($req);
        if (!$event) {
          return redirect()->route('event.index');
        }
        $search = array();
        $search['approval'] = $request->approval;
        $search['searchBlock'] = $request->searchBlock;
        $search['searchSheet'] = $request->searchSheet;
        $selectBlock = $request->block;
        if (!$selectBlock) {
            $selectBlock = 'A';
        }
        $selectSheet = 'progress';

        $query = Result::query();
        $query->where('event_id', $event->id);
        if (isset($search['searchBlock'])) {
            $query->where('block', $search['searchBlock']);
        }
        if (isset($search['searchSheet'])) {
            $query->where('sheet', $search['searchSheet']);
        }
        if (isset($search['approval'])) {
            $query->where('approval', $search['approval']);
        }
        $datas = $query->orderBy('id', 'DESC')->paginate(config('common.page_num'));
        $blocks = Team::getBlocks($event->id);
        $sheets = Team::getSheets($event->id, $selectBlock);
        return view('game.resultlist', compact('selectBlock', 'selectSheet', 'datas', 'search', 'blocks', 'sheets'));
    }

}
