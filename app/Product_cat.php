<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Product_cat extends Model
{
    //
    use Sluggable;

    protected $fillable = ['id', 'name', 'slug', 'parent_id', 'user_id'];

    function products()
    {
        return $this->hasMany('App\Product');
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
