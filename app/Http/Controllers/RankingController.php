<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Service\FlashMessageService;
use App\Http\Requests\EventRequest;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\Team;
use App\Models\Point;

class RankingController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $datas = Point::selectRaw('user_id, sum(point) as point')
            ->groupBy('user_id')
            ->orderBy('point', 'DESC')
            ->get();
        return view('ranking.index', compact('datas'));
    }

}
