<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    //

    protected $fillable = ['id','title','description','content','user_id','product_cat_id','avatar','price','status'];

    function product_cat(){
        return $this->belongsTo('App\Product_cat');
    }

    function thumbnails(){
        return $this->hasMany('App\Thumbnail');
    }

    function invoice_order(){
        return $this->belongsTo('App\Invoice_order');
    }
}
