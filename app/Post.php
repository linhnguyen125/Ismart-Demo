<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    use Sluggable;
    //
    protected $fillable = ['id', 'title', 'slug', 'content', 'user_id', 'post_cat_id', 'thumbnail', 'post_status_id'];

    function user()
    {
        return $this->belongsTo('App\User');
    }

    function post_cat()
    {
        return $this->belongsTo('App\Post_cat');
    }

    function post_status()
    {
        return $this->belongsTo('App\Post_status');
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
