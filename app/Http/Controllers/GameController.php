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
                // 承認された時点でランク更新
                if ($request->mode == 'app' || Auth::user()->role != config('user.role.member')) {
                    $this->updatePreRank($event, $request->block, $request->sheet);
                }

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
                $this->updatePreRank($data->event_id, $data->block, $data->sheet);
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

    private function updatePreRank($event, $selectBlock, $selectSheet) {
        $results = Team::where('event_id', $event)
        ->where('block', $selectBlock)
        ->where('sheet', $selectSheet)
        ->where('approval', 1)
        ->orderBy('number')
        ->get();

        $teams = array();
        foreach ($results as $key => $value) {
            $teams[$value->number]['id'] = $value->id;
            $teams[$value->number]['number'] = $value->number;
            $teams[$value->number]['name'] = $value->name;
            $teams[$value->number]['abstention'] = $value->abstention;
            $teams[$value->number]['win_num'] = 0;
            $teams[$value->number]['win_total'] = 0;
            $teams[$value->number]['lose_total'] = 0;
            $teams[$value->number]['created_at'] = $value->created_at;

            $team_id = $value->id;
            $blockTeam = Team::where('event_id', $event)
            ->where('block', $selectBlock)
            ->where('sheet', $value->sheet)
            ->where('id', '<>', $team_id)
            ->orderBy('number')
            ->get();
            foreach ($blockTeam as $key => $v) {
                $win = Result::where('win_team_id', $team_id)
                ->where('event_id', $event)
                ->where('lose_team_id', $v->id)
                ->where('approval', 1)
                ->first();
                $lose = Result::where('lose_team_id', $team_id)
                ->where('event_id', $event)
                ->where('win_team_id', $v->id)
                ->where('approval', 1)
                ->first();
                if ($win || $lose) {
                    if ($win) {
                        $teams[$value->number]['win_num'] += 3;
                        $teams[$value->number]['win_total'] += $win->win_score;
                        $teams[$value->number]['lose_total'] += $win->lose_score;
                    } else if($lose) {
                        $teams[$value->number]['win_num'] += $lose->lose_score;
                        $teams[$value->number]['win_total'] += $lose->lose_score;
                        $teams[$value->number]['lose_total'] += $lose->win_score;
                    }
                }
            }
            $winScore = $teams[$value->number]['win_total'];
            $loseScore = $teams[$value->number]['lose_total'];
            if ($winScore == 0) {
                $teams[$value->number]['percent'] = 0;
            } else {
                $teams[$value->number]['percent'] = round($winScore / ($winScore + $loseScore) * 100, 1);
            }
        }

        $ranks = $teams;
        $abstentions = array();
        // 並び替え・一位確定未実装
        // 棄権チームはランク外
        foreach ($ranks as $key => $value) {
            if ($value['abstention'] == 1) {
                $abstentions[] = $ranks[$key];
                unset($ranks[$key]);
            }
        }
        // 勝点・取得率で並び替え
        $score_keys = array_column($ranks, 'win_num');
        $percent_keys = array_column($ranks, 'percent');
        array_multisort(
            $score_keys, SORT_DESC, SORT_NUMERIC,
            $percent_keys, SORT_DESC, SORT_NUMERIC,
            $ranks
         );
        $ranks = $this->chkWinTeam($ranks);
        $ranks = $this->chkThreeSided($ranks);
        foreach ($abstentions as $key => $value) {
          array_push($ranks, $value);
        }
        foreach ($ranks as $key => $value) {
            $team = Team::find($value['id']);
            $team->pre_rank = ($key+1);
            $team->update();
        }
        $this->chkAllResultAndRankDecision($event, $selectBlock, $selectSheet);
    }

    private function chkThreeSided($ary)
    {
        $return = $ary;
        foreach ($ary as $key => $value) {
            if (2 < (count($return) - $key)) {
                if ($ary[$key]['percent'] == $ary[($key+1)]['percent'] &&
                    $ary[$key]['win_num'] == $ary[($key+1)]['win_num'] &&
                    $ary[$key]['percent'] == $ary[($key+2)]['percent'] &&
                    $ary[$key]['win_num'] == $ary[($key+2)]['win_num']) {
                    $result = Team::whereIn('id', [$ary[$key]['id'], $ary[($key+1)]['id'], $ary[($key+2)]['id']])
                    ->orderBy('created_at', 'ASC')
                    ->get();
                    // print_r($result);
                    foreach ($result as $k => $val) {
                        if ($val->id == $ary[$key]['id']) {
                            $return[$k] = $ary[$key];
                        } elseif ($val->id == $ary[($key+1)]['id']) {
                            $return[$k] = $ary[($key+1)];
                        } elseif ($val->id == $ary[($key+2)]['id']) {
                            $return[$k] = $ary[($key+2)];
                        }
                    }
                }
            }
        }
        return $return;
    }

    private function chkWinTeam($ary)
    {
        $return = $ary;
        foreach ($ary as $key => $value) {
            if (isset($ary[($key+2)])) {
                if (!($ary[$key]['percent'] == $ary[($key+1)]['percent'] &&
                      $ary[$key]['win_num'] == $ary[($key+1)]['win_num'] &&
                      $ary[$key]['percent'] == $ary[($key+2)]['percent'] &&
                      $ary[$key]['win_num'] == $ary[($key+2)]['win_num'] &&
                      isset($ary[($key+2)]))) {
                    if ($ary[$key]['percent'] == $ary[($key+1)]['percent'] &&
                        $ary[$key]['win_num'] == $ary[($key+1)]['win_num']) {
                        $result =Result::where('win_team_id', $ary[($key+1)]['id'])
                        ->where('lose_team_id', $ary[$key]['id'])
                        ->first();
                        if ($result) {
                            $return[$key] = $ary[($key+1)];
                            $return[($key+1)] = $ary[$key];
                        } elseif ($ary[($key+1)]['created_at'] < $ary[$key]['created_at']) {
                            $return[$key] = $ary[($key+1)];
                            $return[($key+1)] = $ary[$key];
                        }
                    }
                }
            } else if (isset($ary[($key+1)])) {
                if ($ary[$key]['percent'] == $ary[($key+1)]['percent'] &&
                    $ary[$key]['win_num'] == $ary[($key+1)]['win_num']) {
                    $result =Result::where('win_team_id', $ary[($key+1)]['id'])
                    ->where('lose_team_id', $ary[$key]['id'])
                    ->first();
                    if ($result) {
                        $return[$key] = $ary[($key+1)];
                        $return[($key+1)] = $ary[$key];
                    } elseif ($ary[($key+1)]['created_at'] < $ary[$key]['created_at']) {
                        $return[$key] = $ary[($key+1)];
                        $return[($key+1)] = $ary[$key];
                    }
                }
            }
        }
        return $return;
    }

    private function chkAllResultAndRankDecision($event_id, $block, $sheet)
    {
        $event = Event::find($event_id);
        $cnt = Result::where('event_id', $event_id)
        ->where('block', $block)
        ->where('sheet', $sheet)
        ->where('approval', 1)
        ->count();

        if ($cnt == 6) {
            $teams = Team::where('event_id', $event_id)
            ->where('block', $block)
            ->where('sheet', $sheet)
            ->where('abstention', 0)
            ->orderBy('pre_rank')
            ->get();
            foreach ($teams as $key => $value) {
                if ($event->passing_order < $key + 1) {
                   break;
                }
                $team = Team::find($value->id);
                $team->main_game = 1;
                $team->update();
            }
        }
    }

}
