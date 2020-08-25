<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'order_number', 'order_date'
    ];

    public function items()
    {
        return $this->hasMany('App\PurchaseItem');
    }
}
