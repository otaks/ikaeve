<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['created_at','updated_at','deleted_at'];
    protected static function boot()
    {
        parent::boot();
    }

    public function winteam()
    {
        return $this->belongsTo('App\Models\Team', 'win_team_id', 'id');
    }

    public function loseteam()
    {
        return $this->belongsTo('App\Models\Team', 'lose_team_id', 'id');
    }

}
