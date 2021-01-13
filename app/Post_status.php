<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post_status extends Model
{
    protected $table = 'post_status';
    //
    function posts(){
        return $this->hasMany('App\Post');
    }
}
