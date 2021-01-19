<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Invoice_order;
use App\Order;
use App\Product;
use App\Product_cat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserHomeController extends Controller
{
    //

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'home']);

            return $next($request);
        });
    }

    function home()
    {
        //========== sản phẩm bán chạy =========
        //----- sắp xếp danh sách id product theo số lượng order giảm dần ----------
        $bestSellingProductId = Invoice_order::select('product_id')
            ->selectRaw("SUM(qty) as qty")->groupBy('product_id')->orderBy('qty', 'desc')->get()
            ->pluck('product_id')->unique();
        $bestSellingProducts = Product::whereIn('id', $bestSellingProductId)
            ->skip(0)->take(10)->get();
        // sản phẩm mới
        $products = Product::where('status', '=', '1')->orderBy('created_at', 'desc')->skip(0)->take(10)->get();
        // lấy ID danh mục thuộc Điện thoại
        $list_id_mobile = $this->get_id(1);
        $list_id_laptop = $this->get_id(2);

        $mobiles = DB::table('products')->where('status', '=', '1')->orderBy('created_at', 'desc')
            ->whereIn('product_cat_id', $list_id_mobile)->skip(0)->take(20)->get();
        $laptops = DB::table('products')->where('status', '=', '1')->orderBy('created_at', 'desc')
            ->whereIn('product_cat_id', $list_id_laptop)->skip(0)->take(20)->get();

        $banners = Banner::where('status', '=', '1')->get();

        $list_cat_name_0 = Product_cat::where('parent_id', 0)->get();
        foreach ($list_cat_name_0 as $item) {
            $list_child[$item->id] = Product_cat::where('parent_id', $item->id)->get();
            $count[$item->id] = Product_cat::where('parent_id', $item->id)->count();
        }
        return view('welcome', compact(
            'products',
            'mobiles',
            'laptops',
            'list_cat_name_0',
            'list_child',
            'count',
            'banners',
            'bestSellingProducts'
        ));
    }

    function get_id($id)
    {
        $cat = Product_cat::find($id);
        $list_id[] = $cat->id;
        $list_cats = Product_cat::where('parent_id', $id)->get();
        foreach ($list_cats as $item) {
            $this->get_id($item->id);
            $list_id[] = $item->id;
        }
        return $list_id;
    }

    function autocomplete(Request $request)
    {
        if ($request->keywords) {
            $products = Product::where('status', '=', '1')->where('title', 'like', '%' . $request->keywords . '%')->get();
            $data = '<ul class="dropdown-menu" style="display: block;">';
            foreach ($products as $product) {
                $data .= '<li class="li-search-ajax"><a href="#">' . $product->title . '</a></li>';
            }
            $data .= '</ul>';
            echo $data;
        }
    }

    function search(Request $request)
    {
        $list_cat_name_0 = Product_cat::where('parent_id', 0)->get();
        foreach ($list_cat_name_0 as $item) {
            $list_child[$item->id] = Product_cat::where('parent_id', $item->id)->get();
            $count[$item->id] = Product_cat::where('parent_id', $item->id)->count();
        }

        $keyword = '';
        if ($request->input('keyword')) {
            $keyword = htmlspecialchars($request->input('keyword'));
        }
        $products = Product::where('title', 'like', "%{$keyword}%")->where('status', '=', '1')->paginate(20);

        return view('user.product.search', compact('products', 'list_cat_name_0', 'list_child', 'count'));
    }
}
