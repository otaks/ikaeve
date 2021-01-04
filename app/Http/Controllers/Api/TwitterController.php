<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterController extends Controller
{
    // screennameからID取得
    public function getId($name)
    {
        $result = array('status' => '', 'message' => '');
        try {
            $connection = new TwitterOAuth(
                config('twitter.consumer_key'),
                config('twitter.consumer_secret')
            );
            $user_data=$connection->get("users/show", ["screen_name" => $name]);
            $result = ['status' => 200, 'result' => $user_data->id];
        } catch (\Exception $e) {
            report($e);
            $result = ['status' => 400, 'message' => 'twitter名が無効です'];
        }
        return response()->json($result);
    }

}
