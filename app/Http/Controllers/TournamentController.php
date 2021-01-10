<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Service\FlashMessageService;
use App\Http\Requests\EventRequest;
use Carbon\Carbon;
use App\Models\Team;

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
        $selectSheet = $request->sheet;
        $selectBlock = $request->block;
        if (!$selectBlock) {
            $selectBlock = 1;
        }
        if (!$selectSheet) {
            $selectSheet = 'A';
        }

        $sheets = Team::where('event_id', $event)
        ->where('block', $selectBlock)
        ->groupBy('sheet')
        ->orderBy('sheet')
        ->get();

        if (count($sheets) < 1) {
            FlashMessageService::error('対戦表はまだ作成されてません');
            return redirect()->route('event.detail', ['id' => session('event')]);
        }

        $teams = Team::where('event_id', $event)
        ->where('block', $selectBlock)
        ->where('sheet', $selectSheet)
        ->orderBy('number')
        ->get();

        return view('tournament.index', compact('selectBlock', 'selectSheet', 'sheets', 'teams'));
    }

    public function make()
    {
        return view('tournament.make');
    }

    public function makeStore(Request $request)
    {
        try {
            $event = $request->session()->get('event');
            $teams = Team::getAllTeam($event, $request->order_rule);
            $block = count($teams) / 64;
            $sheet = array();
            for ( $i = 0; $i < 16; $i++ ) {
                $sheet[] = chr(65 + $i);
            }
            $i = 0;
            $tonament = array();
            $sheetNum = 4;
            $arrayCut = 16;
            $teamArray = array_chunk($teams, 4);

            foreach ($teamArray as $key => $value) {
                if ($key < 16) {
                    $sheetStr = $sheet[$key];
                } else {
                    $sheetStr = $sheet[($key % 16)];
                }
                foreach ($value as $k => $val) {
                    $team = Team::find($val['id']);
                    $team->block = floor($key / 16) + 1;
                    $team->sheet = $sheetStr;
                    $team->number = $k + 1;
                    $team->update();
                }
            }
            FlashMessageService::success('作成が完了しました');

        } catch (\Exception $e) {
            report($e);
            FlashMessageService::error('作成が失敗しました');
        }

        return redirect()->route('tournament.make');
    }

    public function edit(Request $request)
    {
        $event = $request->session()->get('event');
        $selectBlock = $request->block;
        if (!$selectBlock) {
            $selectBlock = 1;
        }
        $teams = Team::where('event_id', $event)
        ->where('block', $selectBlock)
        ->orderBy('block')
        ->orderBy('sheet')
        ->orderBy('number')
        ->get();

        $blocks = Team::where('event_id', $event)
        ->groupBy('block')
        ->orderBy('block')
        ->get();

        return view('tournament.edit', compact('blocks', 'selectBlock', 'teams'));
    }
}
