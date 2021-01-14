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
use App\Models\Color;

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
        $member = null;

        // 参加している対戦表のチェック
        if (Auth::user()->role == config('user.role.member')) {
            $member = Member::join('teams', 'teams.id', 'members.team_id')
            ->where('event_id', $event)
            ->where('user_id', Auth::id())->first();
        }
        if ($member) {
            $selectSheet = $member->team->sheet;
            $selectBlock = $member->team->block;
        } else {
            $selectSheet = $request->sheet;
            $selectBlock = $request->block;
        }
        if (!$selectBlock) {
            $selectBlock = 'A';
        }
        $request->session()->put('block', $selectBlock);
        if (!$selectSheet) {
            $selectSheet = 1;
        }

        $blocks = Team::getBlocks($event);
        $sheets = Team::getSheets($event, $selectBlock);

        if (count($blocks) < 1) {
            $request->session()->forget('block');
            FlashMessageService::error('対戦表はまだ作成されてません');
            return redirect()->route('event.detail', ['id' => session('event')]);
        }

        $results = Team::where('event_id', $event)
        ->where('block', $selectBlock)
        ->orderBy('sheet')
        ->orderBy('number')
        ->get();
        $teams = array();
        foreach ($results as $key => $value) {
            $teams[$value->sheet][$value->number]['id'] = $value->id;
            $teams[$value->sheet][$value->number]['name'] = $value->name;
            $teams[$value->sheet][$value->number]['abstention'] = $value->abstention;
        }

        return view('tournament.index',
        compact('selectBlock', 'selectSheet', 'sheets', 'teams', 'blocks'));
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
            // print_r($teamByBlock);
            // exit;
            $block = array();
            for ( $i = 0; $i < $blockNum; $i++ ) {
                $block[] = chr(65 + $i);
            }

            $i = 0;
            $j = 0;
            $tonament = array();
            foreach ($block as $key => $value) {
                while ($i < $sheetNum) {
                  if ($key < $sheetNum) {
                      $blockStr = $block[$key];
                  } else {
                      $blockStr = $block[($key % $sheetNum)];
                  }
                  $h = 0;
                  while ($h < $teamBySheet) {
                      if ($h == ($teamBySheet - 1) && $key < 8 &&
                      $key < $hajime[floor($key / $sheetNum)]) {
                          $h++;
                          continue;
                      } elseif ($h == ($teamBySheet - 1) && 7 < $key &&
                      $key > (15 - $ato[floor($key / $sheetNum)])) {
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
                // $sheets = Team::getSheets($event->id, ($i + 1));
                // $allTeam = count($sheets) * $event->passing_order;
                // foreach ($sheets as $key => $val) {
                //     if ($event->passing_order == 1) {
                //         $game         = new MainGame();
                //         $game->block  = ($i + 1);
                //         $game->sheet  = $val->sheet;
                //         $game->turn   = ($key % 2) + 1;
                //         $game->order  = 1;
                //         $game->save();
                //     } else {
                //         $game         = new MainGame();
                //         $game->block  = ($i + 1);
                //         $game->sheet  = $val->sheet;
                //         $game->turn   = ($key + 1);
                //         $game->order  = 1;
                //         $game->save();
                //
                //         $game         = new MainGame();
                //         $game->block  = ($i + 1);
                //         $game->sheet  = $val->sheet;
                //         $game->turn   = ($key + 1);
                //         $game->order  = 2;
                //         $game->save();
                //     }
                // }
                // // echo $allTeam;
                // // exit;
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
        $selectBlock = $request->block;
        if (!$selectBlock) {
            $selectBlock = 1;
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
        // 参加している対戦表のチェック
        $member = null;
        if (Auth::user()->role == config('user.role.member')) {
            $member = Member::join('teams', 'teams.id', 'members.team_id')
            ->where('event_id', $event)
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
        $selectSheet = 'progress';

        $blocks = Team::getBlocks($event);
        $sheets = Team::getSheets($event, $selectBlock);

        return view('tournament.progress',
        compact('selectBlock', 'selectSheet', 'blocks', 'sheets'));
    }

    public function maingame(Request $request)
    {
        $event_id = $request->session()->get('event');
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
        $selectSheet = 'maingame';

        $blocks = Team::getBlocks($event->id);
        $sheets = Team::getSheets($event->id, $selectBlock);

        // 本戦トーナメント構成
        $teams = array();
        $result = MainGame::orderBy('turn')->get();
        foreach ($result as $key => $value) {
            $teams[$value->turn]['sheet'] = $value->sheet;
            $teams[$value->turn]['order'] = $value->order;
        }
        $gameCnt = 5;

        return view('tournament.maingame',
        compact('selectBlock', 'selectSheet', 'blocks', 'sheets', 'teams', 'gameCnt'));
    }

    public function teamlist(Request $request)
    {
        $event_id = $request->session()->get('event');
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
