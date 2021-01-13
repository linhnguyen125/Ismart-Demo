<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    //
    use SoftDeletes;

    protected $fillable = ['id','order_code','user_id','total','address','status'];

    function user(){
        return $this->belongsTo('App\User');
    }

    function invoice_orders(){
        return $this->hasMany('App\Invoice_order');
    }
}
