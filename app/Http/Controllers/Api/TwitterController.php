<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Abraham\TwitterOAuth\TwitterOAuth;
use App\Models\Team;

class TwitterController extends Controller
{
    // screennameからID取得
    public function getId($name, $event, $team = null)
    {
        $result = array('status' => '', 'message' => '');
        try {
            $connection = new TwitterOAuth(
                config('twitter.consumer_key'),
                config('twitter.consumer_secret')
            );
            $userData=$connection->get("users/show", ["screen_name" => $name]);
            $cnt = 0;

            $query = Team::query()
            ->join('members', 'members.team_id', '=', 'teams.id')
            ->join('users', 'users.id', '=', 'members.user_id')
            ->where('event_id', $event)
            ->where('twitter_id', $userData->id);
            if ($team) {
                $query->where('teams.id', '<>', $team);
            }
            $cnt = $query->count();

            if ($cnt == 0) {
                $result = ['status' => 200, 'result' => $userData->id];
            } else {
                $result = ['status' => 400, 'message' => 'この大会に登録済みのtwitter名です'];
            }
        } catch (\Exception $e) {
            report($e);
            $result = ['status' => 400, 'message' => 'twitter名が無効です'];
        }
        return response()->json($result);
    }

}
