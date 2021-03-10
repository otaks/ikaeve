<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Abraham\TwitterOAuth\TwitterOAuth;
use App\Http\Controllers\Controller;
use App\Service\FlashMessageService;
use App\Http\Requests\TeamRequest;
use App\Models\User;
use App\Models\Event;
use App\Models\Team;
use App\Models\Member;
use App\Models\Result;
use App\Models\Answer;

class TeamController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->session()->forget('block');
        $search['event'] = $request->session()->get('event');
        $datas = Team::where('event_id', $search['event'])->orderBy('id', 'DESC')->paginate(config('common.page_num'));
        return view('team.index', compact('datas'));
    }

    public function indexStore(Request $request)
    {
        $search['event'] = $request->session()->get('event');
        $search['name'] = $request->name;
        $search['member_name'] = $request->member_name;

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
        $datas = $query->groupBy('teams.id')->orderBy('teams.id', 'DESC')->paginate(config('common.page_num'));
        return view('team.index', compact('datas', 'search'));
    }

    public function regist(Request $request)
    {
        if(!\old('name')) {
            $user = Auth::user();
            $request->session()->flash('_old_input', [
              'member_name.0' => $user->name,
              'twitter.0' => $user->twitter_nickname,
              'twitter_id.0' => $user->twitter_id
            ]);
        }
        $event_id = $request->session()->get('event');
        $event = Event::find($event_id);
        return view('team.regist', compact('event'));
    }

    public function registStore(TeamRequest $request)
    {
        try {
            \DB::transaction(function() use($request) {

                $event_id = $request->session()->get('event');
                $maxNo = Team::where('event_id', $event_id)->max('no');
                $data = new Team();
                $data->no = $maxNo+1;
                $data->name = $request->name;
                $data->friend_code = join('', $request->friend_code);
                $data->note = $request->note;
                $data->event_id = $event_id;
                $data->approval = 1;
                $data->save();

                $total_xp = 0;
                $names = $request->member_name;
                $twitters = $request->twitter;
                $twitterIds = $request->twitter_id;
                $xps = $request->xp;
                $ids = $request->member_id;
                foreach ($ids as $k => $val) {
                    $member = new Member();
                    $twId = $this->getTwitterId($twitters[$k]);
                    $user = User::where('twitter_id', $twId)->first();
                    if (!$user) {
                        $user = new User();
                        $user->twitter_id = $twId;
                        $user->twitter_nickname = $twitters[$k];
                        $user->save();
                    }
                    $member->user_id = $user->id;
                    $member->team_id = $data->id;
                    $member->name = $names[$k];
                    $member->xp = $xps[$k];
                    $member->save();
                    if ($k == 0) {
                        $data->member_id = $member->id;
                        $data->update();
                    }
                    $total_xp += $xps[$k];
                }
                $data->xp_total = $total_xp;
                $data->update();

                $questions = $request->question;
                $answers = $request->answer;
                if ($request->question) {
                    foreach ($questions as $k => $val) {
                        $answer = new Answer();
                        $answer->team_id = $data->id;
                        $answer->question_id = $val;
                        $answer->note = $answers[$k];
                        $answer->save();
                    }
                }
            });

            FlashMessageService::success('登録が完了しました');

        } catch (\Exception $e) {
            report($e);
            FlashMessageService::error('登録が失敗しました');
        }

        return redirect()->route('team.index');
    }

    public function edit(Request $request)
    {
        $event_id = $request->session()->get('event');
        $event = Event::find($event_id);
        $data = Team::find($request->id);
        $answer = Answer::getArray($data->answer);
        $members = $data::members($request->id);
        return view('team.edit', compact('data', 'members', 'event', 'answer'));
    }

    public function editStore(TeamRequest $request)
    {
        try {
            \DB::transaction(function() use($request) {

                $data = Team::find($request->id);
                $ids = $request->member_id;
                $data->name = $request->name;
                $data->friend_code = join('', $request->friend_code);
                $data->note = $request->note;
                $data->save();

                $total_xp = 0;
                $names = $request->member_name;
                $twitters = $request->twitter;
                $twitterIds = $request->twitter_id;
                $xps = $request->xp;
                foreach ($ids as $k => $val) {
                    $member = Member::find($val);
                    $twId = $this->getTwitterId($twitters[$k]);
                    $user = User::where('twitter_id', $twId)->first();
                    if (!$user) {
                        $user = new User();
                        $user->twitter_id = $twId;
                        $user->twitter_nickname = $twitters[$k];
                        $user->save();
                    }
                    $member->user_id = $user->id;
                    $member->name = $names[$k];
                    $member->xp = $xps[$k];
                    $member->update();
                    if ($k == 0) {
                        $data->member_id = $member->id;
                        $data->update();
                    }
                    $total_xp += $xps[$k];
                }
                $data->xp_total = $total_xp;
                $data->update();

                $questions = $request->question;
                $answers = $request->answer;
                $aIds = $request->answer_id;
                if ($request->question) {
                    foreach ($questions as $k => $val) {
                        $answer = Answer::find($aIds[$k]);
                        if (!$answer) {
                            $answer = new Answer();
                        }
                        $answer->team_id = $request->id;
                        $answer->question_id = $val;
                        $answer->note = $answers[$k];
                        $answer->save();
                    }
                }
            });

            FlashMessageService::success('編集が完了しました');

        } catch (\Exception $e) {
            report($e);
            FlashMessageService::error('編集が失敗しました');
        }

        return redirect()->route('team.index');
    }

    public function update($id, $column, $value)
    {
        try {
            \DB::transaction(function() use($id, $column, $value) {

                $data = Team::find($id);
                if ($column == 'approval') {
                    $data->approval = $value;
                } else {
                    $data->abstention = $value;
                    // 試合中の途中棄権の場合残りを0-2で登録
                    // ランク外(5)で更新
                    if ($data->block != '') {
                        $this->insertResult($data);
                        $data->pre_rank = 4;
                    }
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

    public function delete(Request $request)
    {
        try {
            \DB::transaction(function() use($request) {

                $data = Team::find($request->id);
                $data->delete();

            });

            FlashMessageService::success('削除が完了しました');

        } catch (\Exception $e) {
            report($e);
            FlashMessageService::error('削除が失敗しました');
        }

        return redirect()->route('team.index');
    }

    private function getTwitterId($name)
    {
        $connection = new TwitterOAuth(
            config('twitter.consumer_key'),
            config('twitter.consumer_secret')
        );
        $userData=$connection->get("users/show", ["screen_name" => $name]);
        return $userData->id;
    }

    private function insertResult($team)
    {
        $event = Event::find($team->event_id);
        $teams = Team::where('event_id', $team->event_id)
        ->where('block', $team->block)
        ->where('sheet', $team->sheet)
        ->where('id', '<>', $team->id)
        ->get();
        foreach ($teams as $key => $value) {
          $query = Result::query();
          $query->where(function($query) use($team){
              $query->where('lose_team_id', '=', $team->id)
                    ->orWhere('win_team_id', '=', $team->id);
          });
          $query->where(function($query) use($value){
              $query->where('win_team_id', '=', $value->id)
                    ->orWhere('lose_team_id', '=', $value->id);
          });
          $result = $query->first();
          if (!$result) {
              foreach (config('game.pre') as $key => $val) {
                  foreach ($val as $conf) {
                      if (in_array($team->number, $conf) &&
                      in_array($value->number, $conf)) {
                          $result = new Result();
                          if ($value->abstention == 0) {
                              $result->win_score = $event->pre_score;
                          } else {
                              $result->win_score = 0;
                              $result->abstention = 1;
                          }
                          $result->win_team_id = $value->id;
                          $result->lose_team_id = $team->id;
                          $result->lose_score = 0;
                          $result->unearned_win = 1;
                          $result->block = $value->block;
                          $result->sheet = $value->sheet;
                          $result->turn = $key;
                          $result->event_id = $event->id;
                          $result->user_id = Auth::id();
                          $result->approval = 1;
                          $result->save();
                        }
                    }
                }
            } elseif ($value->abstention == 1) {
                $result->win_score = 0;
                $result->abstention = 1;
                $result->user_id = Auth::id();
                $result->approval = 1;
                $result->unearned_win = 0;
                $result->save();
            }
        }
    }
}
