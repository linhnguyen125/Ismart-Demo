<?php

namespace App\Http\Controllers;

use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserCartController extends Controller
{
    //

    function show()
    {

        return view('user.cart.show');
    }

    function add(Request $request, $id)
    {
        $product = Product::find($id);
        // $product_code = Str::upper('UNI - ' . Str::random(8));

        Cart::add([
            'id' => $product->id,
            'name' => $product->title,
            'qty' => 1,
            'price' => $product->price,
            'options' => ['thumbnail' => $product->avatar]
        ]);

        return redirect('cart/show')->with('status', 'Đã thêm sản phẩm vào giỏ hàng');
    }

    function remove($rowId)
    {
        Cart::remove($rowId);
        return redirect('cart/show')->with('status', 'Đã xóa sản phẩm khỏi giỏ hàng');
    }

    function destroy()
    {
        Cart::destroy();
        return redirect('cart/show')->with('status', 'Đã xóa giỏ hàng');
    }

    function update(Request $request)
    {
        Cart::update($request->rowId, $request->qty);
    }
}
