<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Service\FlashMessageService;
use App\Http\Requests\WantedRequest;
use App\Models\Wanted;

class WantedController extends Controller
{
    public function index(Request $request)
    {
        $event = $request->session()->get('event');
        $datas = Wanted::where('event_id', $event)->orderBy('id', 'DESC')->get();
        return view('wanted.index', compact('datas'));
    }

    public function regist()
    {
        return view('wanted.regist');
    }

    public function registStore(WantedRequest $request)
    {
        try {
            \DB::transaction(function() use($request) {

                $event = $request->session()->get('event');
                $data = new Wanted();
                $data->name = $request->name;
                $data->note = $request->note;
                $data->pass = $request->pass;
                $data->event_id = $event;
                $data->save();

            });

            FlashMessageService::success('登録が完了しました');

        } catch (\Exception $e) {
            report($e);
            FlashMessageService::error('登録が失敗しました');
        }

        return redirect()->route('wanted.index');
    }

    public function edit(Request $request)
    {
        $data = Wanted::find($request->id);
        return view('wanted.edit', compact('data'));
    }

    public function editStore(WantedRequest $request)
    {
        $data = Wanted::find($request->id);
        if ($data->pass != $request->pass) {
            FlashMessageService::error('パスワードが違います');
            return redirect()->route('wanted.edit', ['id' => $request->id]);
        } else {
            try {
                \DB::transaction(function() use($data, $request) {

                    $data->name = $request->name;
                    $data->note = $request->note;
                    $data->save();

                });

                FlashMessageService::success('編集が完了しました');

            } catch (\Exception $e) {
                report($e);
                FlashMessageService::error('編集が失敗しました');
            }
            return redirect()->route('wanted.index');
        }
    }

    public function detail(Request $request)
    {
        $data = Wanted::find($request->id);
        return view('wanted.detail', compact('data'));
    }

    public function deleteStore(Request $request)
    {
        $data = Wanted::find($request->id);
        if ($data->pass != $request->pass) {
            FlashMessageService::error('パスワードが違います');
        } else {
            try {
                \DB::transaction(function() use($data) {

                    $data->delete();

                });

                FlashMessageService::success('削除が完了しました');

            } catch (\Exception $e) {
                report($e);
                FlashMessageService::error('削除が失敗しました');
            }
        }

        return redirect()->route('wanted.index');
    }
}
