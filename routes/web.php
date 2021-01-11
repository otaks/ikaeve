<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('login/twitter', 'Auth\LoginController@redirectToTwitterProvider')->name('login/twitter');
Route::get('login/twitter/callback', 'Auth\LoginController@handleTwitterProviderCallback')->name('login/twitter/callback');

Route::group(['middleware' => ['auth']], function () {

    // 大会
    Route::prefix('event')->name('event.')
    ->group(function() {
        Route::get('index', 'EventController@index')->name('index');
        Route::get('regist', 'EventController@regist')->name('regist');
        Route::post('regist', 'EventController@registStore');
        Route::get('detail/{id}', 'EventController@detail')->name('detail')->where('id', '[0-9]+');
        Route::get('edit/{id}', 'EventController@edit')->name('edit')->where('id', '[0-9]+');
        Route::post('edit/{id}', 'EventController@editStore')->where('id', '[0-9]+');
    });

    // 入力項目
    Route::prefix('question')->name('question.')
    ->group(function() {
        Route::get('edit/{id}', 'QuestionController@edit')->name('edit')->where('id', '[0-9]+');
        Route::post('edit/{id}', 'QuestionController@editStore')->where('id', '[0-9]+');
    });

    // メンバー
    Route::prefix('member')->name('member.')
    ->group(function() {
        Route::get('index', 'MemberController@index')->name('index');
        Route::post('index', 'MemberController@indexStore');
        Route::get('detail/{id}', 'MemberController@detail')->name('detail')->where('id', '[0-9]+');
        Route::get('edit/{id}', 'MemberController@edit')->name('edit')->where('id', '[0-9]+');
        Route::post('edit/{id}', 'MemberController@editStore')->where('id', '[0-9]+');
        Route::get('edit/{id}', 'MemberController@edit')->name('edit')->where('id', '[0-9]+');
        Route::post('edit/{id}', 'MemberController@editStore')->where('id', '[0-9]+');
    });

    // チーム
    Route::prefix('team')->name('team.')
    ->group(function() {
        Route::get('index', 'TeamController@index')->name('index');
        Route::post('index', 'TeamController@indexStore');
        Route::get('detail/{id}', 'TeamController@detail')->name('detail')->where('id', '[0-9]+');
        Route::get('regist', 'TeamController@regist')->name('regist');
        Route::post('regist', 'TeamController@registStore');
        Route::get('edit/{id}', 'TeamController@edit')->name('edit')->where('id', '[0-9]+');
        Route::post('edit/{id}', 'TeamController@editStore')->where('id', '[0-9]+');
        Route::get('update/{id}/{column}/{value}', 'TeamController@update')->name('update')->where('id', '[0-9]+');
    });

    // 募集
    Route::prefix('wanted')->name('wanted.')
    ->group(function() {
        Route::get('index', 'WantedController@index')->name('index');
        Route::post('index', 'WantedController@indexStore');
        Route::get('regist', 'WantedController@regist')->name('regist');
        Route::post('regist', 'WantedController@registStore');
        Route::get('edit/{id}', 'WantedController@edit')->name('edit')->where('id', '[0-9]+');
        Route::post('edit/{id}', 'WantedController@editStore')->where('id', '[0-9]+');
        Route::get('detail/{id}', 'WantedController@detail')->name('detail')->where('id', '[0-9]+');
        Route::post('delete/{id}', 'WantedController@deleteStore')->name('delete')->where('id', '[0-9]+');
    });

    // トーナメント表
    Route::prefix('tournament')->name('tournament.')
    ->group(function() {
        Route::get('index/{block?}/{sheet?}', 'TournamentController@index')->name('index');
        Route::get('make', 'TournamentController@make')->name('make');
        Route::post('make', 'TournamentController@makeStore');
        Route::get('edit/{block?}', 'TournamentController@edit')->name('edit');
        Route::get('progress/{block?}', 'TournamentController@progress')->name('progress');
        Route::get('maingame/{block?}', 'TournamentController@maingame')->name('maingame');
    });
});
