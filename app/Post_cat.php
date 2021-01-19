<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Post_cat extends Model
{
    use Sluggable;
    // protected $table = 'post_cats';
    protected $fillable = ['id', 'name', 'slug', 'parent_id', 'user_id'];
    //
    function posts()
    {
        return $this->hasMany('App\Post');
    }
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
