<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;

class Team extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['created_at','updated_at','deleted_at'];
    protected static function boot()
    {
        parent::boot();
    }

    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }

    public function member()
    {
        return $this->hasOne('App\Models\Member');
    }

    public static function members($id)
    {
        return Member::where('team_id', $id)->get();
    }

    public static function chkTeamMember($id)
    {
        return Member::where('team_id', $id)->where('user_id', Auth::id())->count();
    }

    public function answer()
    {
        return $this->hasMany('App\Models\Answer');
    }

    public static function getAllTeam($id, $rule)
    {
        $query = Team::query();
        $query->select('teams.*')
        ->where('event_id', $id)
        ->where('approval', 1)
        ->where('abstention', 0);
        if ($rule == 1) {
            $query->orderBy('xp_total', 'desc');
        } elseif ($rule == 0) {
            $query->inRandomOrder();
        } elseif ($rule == 2) {
            $query->orderBy('created_at', 'asc');
        }
        return $query->get()->toArray();
    }
}
