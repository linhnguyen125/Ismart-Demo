<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    //

    protected $fillable = ['id','path','status','user_id'];

    function user(){
        return $this->belongsTo('App\User');
    }
}
