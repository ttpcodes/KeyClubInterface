<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'id', 'first', 'last', 'nickname', 'suffix', 'email', 'address1', 'address2', 'city', 'country',
        'state', 'postal', 'graduation', 'phone', 'birth', 'gender', 'secondary_id'
    ];

    public $incrementing = false;

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function events()
    {
        return $this->belongsToMany('App\Event');
    }

    public function meetings()
    {
        return $this->belongsToMany('App\Meeting');
    }

    public function officer()
    {
        return $this->hasOne('App\Officer');
    }
}
