<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 'date', 'start', 'end', 'hours', 'officer_id'
    ];
    //
    public function members() {
        return $this->belongsToMany('App\Member');
    }
}
