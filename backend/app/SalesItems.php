<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesItems extends Model
{
    protected $fillable = [
        'user_id', 'sales_id', 'product_id', 'qty', 'assigned_by'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
