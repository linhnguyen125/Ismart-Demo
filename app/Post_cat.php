<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post_cat extends Model
{
    // protected $table = 'post_cats';
    protected $fillable = ['id','name','slug','parent_id','user_id'];
    //
    function posts(){
        return $this->hasMany('App\Post');
    }

}
