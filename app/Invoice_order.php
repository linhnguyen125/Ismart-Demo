<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice_order extends Model
{
    //
    protected $table = 'invoice_orders';

    protected $fillable = ['id', 'order_id', 'product_id', 'qty', 'total'];

    function order()
    {
        return $this->belongsTo('App\Order');
    }

    function product()
    {
        return $this->belongsTo('App\Product');
    }
}
