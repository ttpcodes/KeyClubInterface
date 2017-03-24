<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function events()
    {
        return $this->belongsToMany('App\Event');
    }

    public function officer()
    {
        return $this->hasOne('App\Officer');
    }
}
