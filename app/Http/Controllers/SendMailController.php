<?php

namespace App\Http\Controllers;

use App\Mail\ThongTinDatHang;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    //

    function sendMail()
    {
        // $data = Cart::content();
        // foreach ($data as $row) {
        //     echo $row->total;
        // }
        // Mail::to('linhnguyennd125@gmail.com')->send(new ThongTinDatHang($data));
    }
}
