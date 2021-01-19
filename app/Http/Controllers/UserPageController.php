<?php

namespace App\Http\Controllers;

use App\Invoice_order;
use App\Post;
use App\Product;
use Illuminate\Http\Request;

class UserPageController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'blog']);

            return $next($request);
        });
    }

    function blog()
    {
        $posts = Post::where('post_status_id', '=', '2')->paginate('6');

        //========== sản phẩm bán chạy =========
        //----- sắp xếp danh sách id product theo số lượng order giảm dần ----------
        $bestSellingProductId = Invoice_order::select('product_id')
            ->selectRaw("SUM(qty) as qty")->groupBy('product_id')->orderBy('qty', 'desc')->get()
            ->pluck('product_id')->unique();
        $bestSellingProducts = Product::whereIn('id', $bestSellingProductId)
            ->skip(0)->take(10)->get();

        return view('user.page.blog', compact('posts', 'bestSellingProducts'));
    }

    function detail_blog($slug, $id)
    {
        $post = Post::find($id);

        $bestSellingProductId = Invoice_order::select('product_id')
            ->selectRaw("SUM(qty) as qty")->groupBy('product_id')->orderBy('qty', 'desc')->get()
            ->pluck('product_id')->unique();
        $bestSellingProducts = Product::whereIn('id', $bestSellingProductId)
            ->skip(0)->take(10)->get();

        return view('user.page.detail_blog', compact('post', 'bestSellingProducts'));
    }
}
