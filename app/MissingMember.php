<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissingMember extends Model
{
    protected $fillable = [
        'id', 'meeting_id'
    ];

    public function meeting() {
        $this->belongsTo('App\Meeting');
    }
}
