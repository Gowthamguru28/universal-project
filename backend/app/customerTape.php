<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class customerTape extends Model
{
    protected $fillable = array('*');

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }
}
