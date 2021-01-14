<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    //
    protected $fillable = ['id', 'name', 'gso_id','province_id'];

    function wards(){
        return $this->hasMany('App\Wards');
    }

    function province()
    {
        return $this->belongsTo('App\Province');
    }
}
