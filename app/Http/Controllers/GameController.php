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

class GameController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function result(Request $request)
    {
        $search['event'] = $request->session()->get('event');
        $event = Event::find($search['event']);
        $query = Member::query();
        $query->select('members.*')
        ->join('teams', 'teams.id', '=', 'members.team_id')
        ->where('event_id', $search['event']);
        $datas = $query->orderBy('id', 'DESC')->get();

        return view('game.result', compact('datas', 'event'));
    }

}
