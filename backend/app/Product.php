<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function company()
    {
        return $this->belongsTo('App\Company');
    }
    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
}
