<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Service\FlashMessageService;
use App\Http\Requests\EventRequest;
use App\Models\User;
use App\Models\Event;
use App\Models\Team;

class TeamController extends Controller
{
    // public function __construct()
    // {
    //    $this->middleware('auth');
    // }

    public function index(Request $request)
    {
        $search['event'] = $request->session()->get('event');
        $datas = Team::where('event_id', $search['event'])->orderBy('id', 'DESC')->get();
        $events = Event::orderBy('id', 'DESC')->get();
        return view('team.index', compact('datas', 'events'));
    }

    public function indexStore(Request $request)
    {
        $search['event'] = $request->session()->get('event');
        $search['name'] = $request->name;
        $search['approval'] = $request->approval;

        $query = Team::query();
        if ($search['event']) {
            $query->where('event_id', $search['event']);
        }
        if ($search['name']) {
            $query->where('name', 'LIKE', '%'.$search['name'].'%');
        }
        if (isset($search['approval'])) {
            $query->where('approval', $search['approval']);
        }
        $datas = $query->orderBy('id', 'DESC')->get();
        $events = Event::orderBy('id', 'DESC')->get();
        return view('team.index', compact('datas', 'events', 'search'));
    }

    public function regist()
    {
        FlashMessageService::error('まだできてないよ');
        return view('team.regist');
    }

    public function edit(Request $request)
    {
        $data = Team::find($request->id);
        return view('team.edit', compact('data'));
    }

    public function editStore(EventRequest $request)
    {
        $data = Team::find($request->id);
        if ($data->pass != $request->pass) {
            FlashMessageService::error('パスワードが違います');
            return redirect()->route('team.edit', ['id' => $request->id]);
        } else {
            try {
                \DB::transaction(function() use($request, $data) {

                    $data->name = $request->name;
                    $data->save();

                });

                FlashMessageService::success('編集が完了しました');

            } catch (\Exception $e) {
                report($e);
                FlashMessageService::error('編集が失敗しました');
            }

            return redirect()->route('team.index');
        }
    }

    public function update($id, $column, $value)
    {
        $this->middleware('auth');
        try {
            \DB::transaction(function() use($id, $column, $value) {

                $data = Team::find($id);
                if ($column == 'approval') {
                    $data->approval = $value;
                } else {
                    $data->abstention = $value;
                }
                $data->save();

            });

            FlashMessageService::success('更新が完了しました');

        } catch (\Exception $e) {
            report($e);
            FlashMessageService::error('更新が失敗しました');
        }

        return redirect()->route('team.index');
    }

    public function detail(Request $request)
    {
        $data = Team::find($request->id);
        return view('team.detail', compact('data'));
    }
}
