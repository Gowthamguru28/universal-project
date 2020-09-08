<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class customerForm extends Model
{
    protected $fillable = array('*');

    public function images()
    {
        return $this->hasOne('App\customerImage', 'customer_id', 'id');
    }

    public function tapes()
    {
        return $this->hasMany('App\customerTape', 'customer_id', 'id');
    }
    
    public function rto()
    {
        return $this->belongsTo('App\User', 'rto_id', 'id');
    }
    // public function tapes()
    // {
    //     return $this->hasOne('App\customerTape');
    // }
}
