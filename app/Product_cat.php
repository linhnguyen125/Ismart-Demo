<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_cat extends Model
{
    //

    protected $fillable = ['id','name','slug','parent_id','user_id'];

    function products(){
        return $this->hasMany('App\Product');
    }

}
