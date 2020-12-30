<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Service\FlashMessageService;
use App\Http\Requests\TeamRequest;
use App\Models\User;
use App\Models\Event;
use App\Models\Team;
use App\Models\Member;

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
        $search['member_name'] = $request->member_name;
        $search['approval'] = $request->approval;

        $query = Team::query();
        $query->select('teams.*');
        $query->join('members', 'members.team_id', '=', 'teams.id');
        if ($search['event']) {
            $query->where('event_id', $search['event']);
        }
        if ($search['name']) {
            $query->where('teams.name', 'LIKE', '%'.$search['name'].'%');
        }
        if ($search['member_name']) {
            $query->where('members.name', 'LIKE', '%'.$search['member_name'].'%');
        }
        if (isset($search['approval'])) {
            $query->where('approval', $search['approval']);
        }
        $datas = $query->groupBy('teams.id')->orderBy('teams.id', 'DESC')->get();
        return view('team.index', compact('datas', 'search'));
    }

    public function regist(Request $request)
    {
        $event_id = $request->session()->get('event');
        $event = Event::find($event_id);
        $member_num = $event->team_member;
        return view('team.regist', compact('member_num'));
    }

    public function registStore(TeamRequest $request)
    {
        try {
            \DB::transaction(function() use($request) {

                $data = new Team();
                $data->name = $request->name;
                $data->friend_code = $request->friend_code;
                $data->note = $request->note;
                $data->event_id = $request->session()->get('event');
                $data->save();

                $names = $request->member_name;
                $twitters = $request->twitter;
                $xps = $request->xp;
                $ids = $request->member_id;
                foreach ($ids as $k => $val) {
                    $member = new Member();
                    $member->team_id = $data->id;
                    $member->name = $names[$k];
                    $member->twitter = $twitters[$k];
                    $member->xp = $xps[$k];
                    $member->save();
                }

            });

            FlashMessageService::success('編集が完了しました');

        } catch (\Exception $e) {
            report($e);
            FlashMessageService::error('編集が失敗しました');
        }

        return redirect()->route('team.index');
    }

    public function edit(Request $request)
    {
        $event_id = $request->session()->get('event');
        $event = Event::find($event_id);
        $member_num = $event->team_member;
        $data = Team::find($request->id);
        $members = $data::members($request->id);
        return view('team.edit', compact('data', 'members', 'member_num'));
    }

    public function editStore(TeamRequest $request)
    {
        $data = Team::find($request->id);
        if ($data->pass != $request->pass && !Auth::check()) {
            FlashMessageService::error('パスワードが違います');
            return redirect()->route('team.edit', ['id' => $request->id]);
        } else {
            try {
                \DB::transaction(function() use($request, $data) {

                    $data->name = $request->name;
                    $data->friend_code = $request->friend_code;
                    $data->note = $request->note;
                    $data->save();

                    $names = $request->member_name;
                    $twitters = $request->twitter;
                    $xps = $request->xp;
                    $ids = $request->member_id;
                    foreach ($ids as $k => $val) {
                        $data = Member::find($val);
                        $data->name = $names[$k];
                        $data->twitter = $twitters[$k];
                        $data->xp = $xps[$k];
                        $data->update();
                    }

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
