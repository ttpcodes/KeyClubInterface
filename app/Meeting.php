<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = ['date_time', 'information'];

    public function members()
    {
        return $this->belongsToMany('App\Member');
    }

    public function missing_members() {
        return $this->hasMany('App\MissingMember');
    }
}
