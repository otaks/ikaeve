<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Service\FlashMessageService;
use App\Http\Requests\EventRequest;
use App\Models\User;
use App\Models\Event;

class EventController extends Controller
{
    // public function __construct()
    // {
    //    $this->middleware('auth');
    // }

    public function index(Request $request)
    {
        $this->middleware('auth');
        $request->session()->forget('event');
        $datas = Event::orderBy('id', 'DESC')->get();
        return view('event.index', compact('datas'));
    }

    public function regist()
    {
        $this->middleware('auth');
        return view('event.regist');
    }

    public function registStore(EventRequest $request)
    {
        $this->middleware('auth');
        try {
            \DB::transaction(function() use($request) {

                $data = new Event();
                $data->name = $request->name;
                $data->from_recruit_date = $request->from_recruit_date;
                $data->to_recruit_date = $request->to_recruit_date;
                $data->from_date = $request->from_date;
                $data->to_date = $request->to_date;
                $data->team_member = $request->team_member;
                $data->header_color = $request->header_color;
                $data->save();

            });

            FlashMessageService::success('登録が完了しました');

        } catch (\Exception $e) {
            report($e);
            FlashMessageService::error('登録が失敗しました');
        }

        return redirect()->route('event.index');
    }

    public function edit(Request $request)
    {
        $this->middleware('auth');
        $data = Event::find($request->id);
        return view('event.edit', compact('data'));
    }

    public function editStore(EventRequest $request)
    {
        $this->middleware('auth');
        try {
            \DB::transaction(function() use($request) {

                $data = Event::find($request->id);
                $data->name = $request->name;
                $data->from_recruit_date = $request->from_recruit_date;
                $data->to_recruit_date = $request->to_recruit_date;
                $data->from_date = $request->from_date;
                $data->to_date = $request->to_date;
                $data->team_member = $request->team_member;
                $data->header_color = $request->header_color;
                $data->save();

            });

            FlashMessageService::success('編集が完了しました');

        } catch (\Exception $e) {
            report($e);
            FlashMessageService::error('編集が失敗しました');
        }

        return redirect()->route('event.index');
    }

    public function detail(Request $request)
    {
        $request->session()->put('event', $request->id);
        $data = Event::find($request->id);
        $request->session()->put('eventName', $data->name);
        if ($data->header_color) {
            $request->session()->put('headerColor', $data->header_color);
        }
        return view('event.detail', compact('data'));
    }
}
