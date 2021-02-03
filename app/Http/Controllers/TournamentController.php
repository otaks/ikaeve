<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Service\FlashMessageService;
use App\Http\Requests\EventRequest;
use Carbon\Carbon;
use App\Models\Team;
use App\Models\Event;
use App\Models\Member;
use App\Models\MainGame;
use App\Models\Result;
// use App\Models\User;

class TournamentController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $event = $request->session()->get('event');
        if (!$event) {
            return redirect()->route('event.index');
        }

        //メールアドレス・パスワードアップデート
        // $teams = Team::where('event_id', $event)->get();
        // foreach ($teams as $val) {
        //   // print_r($val->member);
        //   // exit;
        //     foreach ($val->members($val->id) as $key => $value) {
        //       // print_r($value);
        //       // exit;
        //       //   $membr = Member::find($value->member_id);
        //         $email = $val->block.$val->sheet.'_'.($key+1).'@gmail.com';
        //         $chk = User::where('email', $email)->count();
        //         if (0 < $chk) continue;
        //         $user = User::find($value->user_id);
        //         $user->email = $email;
        //         $user->password = '$2y$10$iEM0JsD/kXclEgTNpfVYweijj.W3.RxzcoPsUxl85cjp9aZ0ntQ5K';
        //         $user->created_at = '2021-01-14 11:49:24';
        //         $user->save();
        //         // print_r($user);
        //         // exit;
        //     }
        // }



        $member = null;

        // 参加している対戦表のチェック
        if (Auth::user()->role == config('user.role.member')) {
            $member = Member::join('teams', 'teams.id', 'members.team_id')
            ->where('event_id', $event)
            ->where('user_id', Auth::id())->first();
            if ($member) {
              $appCnt = Result::where('event_id', $event)
              ->where('lose_team_id', $member->team_id)
              ->where('approval', 0)
              ->count();
              if (0 < $appCnt) {
                  FlashMessageService::error('未承認の試合があります。確認の上承認をお願いします。');
              }
            }
        }
        if ($member && $request->block == '') {
            $selectSheet = $member->team->sheet;
            $selectBlock = $member->team->block;
        } else {
            $selectSheet = $request->sheet;
            $selectBlock = $request->block;
        }
        if (!$selectBlock) {
            $selectBlock = 'A';
        }

        $blocks = Team::getBlocks($event);
        $sheets = Team::getSheets($event, $selectBlock);

        if (count($blocks) < 1) {
            $request->session()->forget('block');
            FlashMessageService::error('対戦表はまだ作成されてません');
            return redirect()->route('event.detail', ['id' => session('event')]);
        }

        $request->session()->put('block', $selectBlock);
        if ($selectSheet == 'all' || $selectSheet == '') {
            $results = Team::where('event_id', $event)
            ->where('block', $selectBlock)
            ->orderBy('sheet')
            ->orderBy('pre_rank')
            ->orderBy('number')
            ->where('approval', 1)
            ->get();

            $games = Result::where('event_id', $event)
            ->where('block', $selectBlock)
            ->where('approval', 1)
            ->get();
        } else {
            $results = Team::where('event_id', $event)
            ->where('block', $selectBlock)
            ->where('sheet', $selectSheet)
            ->where('approval', 1)
            ->orderBy('pre_rank')
            ->orderBy('number')
            ->get();

            $games = Result::where('event_id', $event)
            ->where('block', $selectBlock)
            ->where('sheet', $selectSheet)
            ->where('approval', 1)
            ->get();
        }
        $teams = array();
        $vs = array();
        foreach ($results as $key => $value) {
            $teams[$value->sheet][$value->number]['id'] = $value->id;
            $teams[$value->sheet][$value->number]['number'] = $value->number;
            $teams[$value->sheet][$value->number]['name'] = $value->name;
            $teams[$value->sheet][$value->number]['abstention'] = $value->abstention;
            $teams[$value->sheet][$value->number]['win_num'] = 0;
            $teams[$value->sheet][$value->number]['win_total'] = 0;
            $teams[$value->sheet][$value->number]['lose_total'] = 0;
            $teams[$value->sheet][$value->number]['created_at'] = $value->created_at;
            $teams[$value->sheet][$value->number]['rank'] = $value->pre_rank;
            $teams[$value->sheet][$value->number]['main_game'] = $value->main_game;

            $vs[$value->id] = array();
            $team_id = $value->id;
            $blockTeam = Team::where('event_id', $event)
            ->where('block', $selectBlock)
            ->where('sheet', $value->sheet)
            ->where('id', '<>', $team_id)
            ->orderBy('number')
            ->get();
            foreach ($blockTeam as $key => $v) {
                $vs[$team_id][$key]['name'] = $v->name;
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
                        if ($win->abstention == 1) {
                            $vs[$team_id][$key]['win'] = false;
                            $vs[$team_id][$key]['score'] = '△';
                        } else {
                            $vs[$team_id][$key]['win'] = true;
                            $vs[$team_id][$key]['score'] = '◯';
                        }
                        //$vs[$team_id][$key]['score'] = $win->win_score.'-'.$win->lose_score;
                        $teams[$value->sheet][$value->number]['win_num'] += 3;
                        $teams[$value->sheet][$value->number]['win_total'] += $win->win_score;
                        $teams[$value->sheet][$value->number]['lose_total'] += $win->lose_score;
                    } else if($lose) {
                        if ($lose->abstention == 1) {
                            $vs[$team_id][$key]['score'] = '△';
                        } else {
                            $vs[$team_id][$key]['score'] = '×';
                        }
                        $vs[$team_id][$key]['win'] = false;
                        //$vs[$team_id][$key]['score'] = $lose->lose_score.'-'.$lose->win_score;
                        $teams[$value->sheet][$value->number]['win_num'] += $lose->lose_score;
                        $teams[$value->sheet][$value->number]['win_total'] += $lose->lose_score;
                        $teams[$value->sheet][$value->number]['lose_total'] += $lose->win_score;
                    }
                } else {
                    $vs[$team_id][$key]['win'] = false;
                    $vs[$team_id][$key]['score'] = '?';
                }
            }
            $winScore = $teams[$value->sheet][$value->number]['win_total'];
            $loseScore = $teams[$value->sheet][$value->number]['lose_total'];
            if ($winScore == 0) {
                $teams[$value->sheet][$value->number]['percent'] = 0;
            } else {
                $teams[$value->sheet][$value->number]['percent'] = round($winScore / ($winScore + $loseScore) * 100, 1);
            }
        }

        $scores = array();
        foreach (config('game.pre') as $key => $val) {
            foreach ($val as $k => $conf) {
                foreach ($games as $key => $value) {
                    if ($value->winteam->number == $conf[0] && $value->loseteam->number == $conf[1] ||
                    $value->winteam->number == $conf[1] && $value->loseteam->number == $conf[0]) {
                        if ($conf[0] == 1) {
                            $num = 0;
                        } else {
                            $num = 1;
                        }
                        $scores[$value->block][$value->sheet][$value->turn][$num]['win'] = $value->winteam->number;
                        $scores[$value->block][$value->sheet][$value->turn][$num][$value->win_team_id]['score'] = $value->win_score;
                        $scores[$value->block][$value->sheet][$value->turn][$num][$value->lose_team_id]['score'] = $value->lose_score;
                    }
                }

            }
        }
        return view('tournament.index',
        compact('selectBlock', 'selectSheet', 'sheets', 'teams', 'blocks', 'member', 'vs', 'scores'));
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
                    }
                }
            }
        }
        return $return;
    }

    public function make(Request $request)
    {
        $event_id = $request->session()->get('event');
        if (!$event_id) {
            $request->session()->forget('block');
            return redirect()->route('event.index');
        }
        $event = Event::find($event_id);
        $sheetNum = 16;
        $teamBySheet = 4;

        $teams = Team::getAllTeam($event_id);
        $targetTeamCnt = count($teams);
        $makeBlockCnt = ceil(count($teams) / ($sheetNum * $teamBySheet));
        return view('tournament.make', compact('targetTeamCnt', 'makeBlockCnt'));
    }

    public function makeStore(Request $request)
    {
        try {
            $event_id = $request->session()->get('event');
            if (!$event_id) {
                return redirect()->route('event.index');
            }
            $event = Event::find($event_id);
            Team::resetAllTeam($event_id);
            $teams = Team::getAllTeam($event_id, $request->order_rule);
            $sheetNum = 16;
            $teamBySheet = 4;
            // ブロック数
            $blockNum = ceil(count($teams) / ($sheetNum * $teamBySheet));
            // ブロック単位のチーム数
            $teamByBlock =  floor(count($teams) / $blockNum);

            // 奇数チームになるシート数
            $theam3 = (count($teams) % $teamBySheet);
            // ブロックごとの3チーム数
            $blockTheam3 = ceil($theam3 / $blockNum);
            // echo 'theam3/'.$theam3;
            // echo '<br>blockTheam3/'.$blockTheam3;
            // echo '<br>blockNum/'.$blockNum;
            // echo '<br>teamByBlock/'.$teamByBlock;
            $j = 0;
            $hajime = array();
            $ato = array();
            $teamByBlock = array();

            while ($j < $blockNum) {
                $teamByBlock[$j] = floor(count($teams) / $blockNum);
                if ($j + 1 == $blockNum) {
                    $teamByBlock[$j] += count($teams) % $blockNum;
                }
                $hajime[$j] = floor($blockTheam3 / 2);
                $ato[$j] = floor($blockTheam3 / 2) + $blockTheam3 % 2;
                $j++;
            }
            $block = array();
            for ( $i = 0; $i < $blockNum; $i++ ) {
                $block[] = chr(65 + $i);
            }
            // print_r($teamByBlock);
            // print_r($hajime);
            // print_r($ato);
            // exit;

            $k = 0;
            $j = 0;
            $tonament = array();
            // foreach ($block as $key => $value) {
            while ($k < $blockNum) {
                $i = 0;
                while ($i < $sheetNum) {
                  if ($k < $sheetNum) {
                      $blockStr = $block[$k];
                  } else {
                      $blockStr = $block[($k % $sheetNum)];
                  }
                  $h = 0;
                  while ($h < $teamBySheet) {
                      if ($h == ($teamBySheet - 1) && $k < 8 &&
                      $k < $hajime[floor($k / $sheetNum)]) {
                          $h++;
                          continue;
                      } elseif ($h == ($teamBySheet - 1) && 7 < $k &&
                      $k > (15 - $ato[floor($k / $sheetNum)])) {
                          $h++;
                          continue;
                      }
                      if (empty($teams[$j])) {
                          break;
                      }

                      $team = Team::find($teams[$j]['id']);
                      $team->sheet = $i + 1;
                      $team->block = $blockStr;
                      $team->number = $h + 1;
                      $team->update();
                      $j++;
                      $h++;
                  }
                  $i++;
              }
              $k++;
          // }
            }

            FlashMessageService::success('作成が完了しました');

        } catch (\Exception $e) {
            report($e);
            FlashMessageService::error('作成が失敗しました');
        }

        return redirect()->route('tournament.index');
    }

    public function edit(Request $request)
    {
        $event = $request->session()->get('event');
        if (!$event) {
            return redirect()->route('event.index');
        }
        $selectBlock = $request->block;
        if (!$selectBlock) {
            $selectBlock = 'A';
        }
        $blocks = Team::getBlocks($event);
        $sheets = Team::getSheets($event, $selectBlock);

        $teams = array();
        foreach ($sheets as $key => $value) {
            $i = 1;
            while ($i <= 4) {
                $team = Team::where('event_id', $event)
                ->where('block', $selectBlock)
                ->where('sheet', $value->sheet)
                ->where('number', $i)
                ->first();
                if ($team) {
                    $teams[] = $team;
                } else {
                    $teams[] = (object)[
                      'id' => $selectBlock.'_'.$value->sheet.'_'.$i.'_'.$event,
                      'number' => $i,
                      'name' => '',
                      'sheet' => $value->sheet,
                      'abstention' => 0,
                  ];
                }
                $i++;
            }
        }

        return view('tournament.edit',
        compact('blocks', 'selectBlock', 'teams', 'sheets'));
    }

    public function progress(Request $request)
    {
        $event = $request->session()->get('event');
        if (!$event) {
            return redirect()->route('event.index');
        }
        // 参加している対戦表のチェック
        $member = null;
        if (Auth::user()->role == config('user.role.member')) {
            $member = Member::join('teams', 'teams.id', 'members.team_id')
            ->where('event_id', $event)
            ->where('user_id', Auth::id())->first();
        }
        if (isset($member) && $member->team->block) {
            $selectBlock = $member->team->block;
        } else {
            $selectBlock = $request->block;
        }
        if (!$selectBlock) {
            $selectBlock = 1;
        }
        $selectSheet = 'progress';

        $blocks = Team::getBlocks($event);
        $sheets = Team::getSheets($event, $selectBlock);

        $progress = array();
        $results = Result::where('event_id', $event)
        ->where('block', $selectBlock)
        ->where('approval', 1)
        ->orderBy('sheet')
        ->orderBy('turn')
        ->get();
        foreach ($results as $key => $v) {
            if ($v->winteam->number == 1 || $v->loseteam->number == 1) {
                $num = 0;
            } else {
                $num = 1;
            }
            $progress[$v->sheet][$v->turn][$num] = true;
        }

        return view('tournament.progress',
        compact('selectBlock', 'selectSheet', 'blocks', 'sheets', 'progress'));
    }

    public function maingame(Request $request)
    {
        $event_id = $request->session()->get('event');
        if (!$event_id) {
            return redirect()->route('event.index');
        }
        $event = Event::find($event_id);
        // 参加している対戦表のチェック
        $member = null;
        if (Auth::user()->role == config('user.role.member')) {
            $member = Member::join('teams', 'teams.id', 'members.team_id')
            ->where('event_id', $event->id)
            ->where('user_id', Auth::id())->first();
        }
        if ($member) {
            $selectBlock = $member->team->block;
        } else {
            $selectBlock = $request->block;
        }
        if (!$selectBlock) {
            $selectBlock = 'A';
        }
        $selectSheet = 'maingame';

        $blocks = Team::getBlocks($event->id);
        $sheets = Team::getSheets($event->id, $selectBlock);

        $teams = array();
        foreach (config('game.main') as $key => $value) {
            foreach ($value as $v) {
                foreach ($v as $k => $val) {
                    $team = Team::where('event_id', $event->id)
                    ->where('block', $selectBlock)
                    ->where('sheet', $k)
                    ->where('pre_rank', $val)
                    ->where('main_game', 1)
                    ->first();
                    if ($team) {
                        // $result[$k]['name'] = $team->name;
                        $teams[] = $team->name;
                    } else {
                        // $result[$k]['name'] = $k.'-'.$val.'位通過';
                        $teams[] = $k.'-'.$val.'位通過';
                    }
                }
            }
        }

        return view('tournament.maingame',
        compact('selectBlock', 'selectSheet', 'blocks', 'sheets', 'teams', 'event'));
    }

    public function teamlist(Request $request)
    {
        $event_id = $request->session()->get('event');
        if (!$event_id) {
            return redirect()->route('event.index');
        }
        $event = Event::find($event_id);
        // 参加している対戦表のチェック
        $member = null;
        if (Auth::user()->role == config('user.role.member')) {
            $member = Member::join('teams', 'teams.id', 'members.team_id')
            ->where('event_id', $event->id)
            ->where('user_id', Auth::id())->first();
        }
        if ($member) {
            $selectBlock = $member->team->block;
        } else {
            $selectBlock = $request->block;
        }
        if (!$selectBlock) {
            $selectBlock = 1;
        }
        $selectSheet = 'teamlist';

        $blocks = Team::getBlocks($event->id);
        $sheets = Team::getSheets($event->id, $selectBlock);

        $teams = Team::where('block', $selectBlock)
        ->where('event_id', $event_id)
        ->orderBy('sheet')
        ->orderBy('number')
        ->get();

        return view('tournament.teamlist',
        compact('selectBlock', 'selectSheet', 'blocks', 'sheets', 'teams', 'event'));
    }
}
