<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Service\FlashMessageService;
use App\Models\Color;

class AdminController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->session()->forget('block');
        $selectSheet = null;
        return view('admin.index', compact('selectSheet'));
    }

    public function color(Request $request)
    {
        $selectSheet = 'color';
        $sheetNum = 16;
        $sheets = array();
        $colors = array();
        for ( $i = 0; $i < $sheetNum; $i++ ) {
            $sheets[] = chr(65 + $i);
            $color = Color::where('sheet', chr(65 + $i))->first();
            if ($color) {
                $colors[chr(65 + $i)] = $color->color;
            }
        }
        return view('admin.color', compact('selectSheet', 'sheets', 'colors'));
    }

    public function colorStore(Request $request)
    {
        try {
            \DB::transaction(function() use($request) {
                  $colors = $request->color;
                  $sheets = $request->sheet;
                  foreach ($colors as $key => $value) {
                      $color = Color::where('sheet', $sheets[$key])->first();
                      if (!$color) {
                          $color = new Color();
                      }
                      $color->sheet = $sheets[$key];
                      $color->color = $value;
                      $color->save();
                  }
              });
              FlashMessageService::success('編集が完了しました');

        } catch (\Exception $e) {
            report($e);
            FlashMessageService::error('編集が失敗しました');
        }

        return redirect()->route('admin.color');
    }

}
