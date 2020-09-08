<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRto extends Model
{
    public function rto()
    {
        return $this->belongsTo('App\User');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
