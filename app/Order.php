<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    //
    use SoftDeletes;

    protected $fillable = ['id', 'order_code', 'fullname', 'phone', 'total', 'address', 'email', 'status'];

    function invoice_orders()
    {
        return $this->hasMany('App\Invoice_order');
    }
}
