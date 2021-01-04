<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Service\FlashMessageService;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToTwitterProvider()
    {
       return Socialite::driver('twitter')->redirect();
    }

    public function handleTwitterProviderCallback(){

       try {
           $user = Socialite::with("twitter")->user();
       }
       catch (\Exception $e) {
            FlashMessageService::error('ログインに失敗しました');
            return redirect('/login');
           // エラーならログイン画面へ転送
       }
      $myinfo = User::where('twitter_id', $user->id)->where('role', 3)->first();
      if (!$myinfo) {
             $myinfo = User::firstOrCreate(['twitter_id' => $user->id ],
                       ['name' => $user->nickname,'twitter_nickname' => $user->nickname]);
      }
      Auth::login($myinfo);
      return redirect()->to('/event/index'); // homeへ転送

    }
}
