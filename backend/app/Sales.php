<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $fillable = [
        'order_number', 'order_date', 'created_by'
    ];

    public function items()
    {
        return $this->hasMany('App\SalesItems');
    }
}
