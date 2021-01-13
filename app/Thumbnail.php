<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thumbnail extends Model
{
    //

    protected $fillable = ['id','path','color_name','color_code','product_id','user_id'];

    function product(){
        return $this->belongsTo('App\Product');
    }

    function user(){
        return $this->belongsTo('App\User');
    }
}
