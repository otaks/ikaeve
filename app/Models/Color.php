<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends BaseModel
{
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();
    }
}
