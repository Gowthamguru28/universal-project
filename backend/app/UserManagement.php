<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserManagement extends Model
{
    protected $fillable = [
        'mobile_no', 'address', 'company_name','company_logo','user_id','rto_id'
    ];

    public function rto()
    {
        return $this->belongsTo('App\User');
    }
}
