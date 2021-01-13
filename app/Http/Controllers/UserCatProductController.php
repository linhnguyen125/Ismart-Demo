<?php

namespace App\Http\Controllers;

use App\Product_cat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserCatProductController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);

            return $next($request);
        });
    }

    function show(Request $request, $id)
    {
        $select = 0;
        $list_id = $this->get_id($id);
        $list_brand = DB::table('product_cats')->select('id', 'name')->whereIn('id', $list_id)->get();
        $list_brand1 = DB::table('product_cats')->whereIn('id', $list_id)->get('id');
        unset($list_brand[0]);

        $list_products = DB::table('products')->whereIn('product_cat_id', $list_id)->paginate(40);
        if ($request->input('select')) {
            $select = $request->input('select');
        }
        if ($select == 1 || $select == 0) {
            $list_products = DB::table('products')->whereIn('product_cat_id', $list_id)->orderBy('title', 'desc')->paginate(40);
        }
        if ($select == 2) {
            $list_products = DB::table('products')->whereIn('product_cat_id', $list_id)->orderBy('title', 'asc')->paginate(40);
        }
        if ($select == 3) {
            $list_products = DB::table('products')->whereIn('product_cat_id', $list_id)->orderBy('price', 'desc')->paginate(40);
        }
        if ($select == 4) {
            $list_products = DB::table('products')->whereIn('product_cat_id', $list_id)->orderBy('price', 'asc')->paginate(40);
        }
        $cat_name = Product_cat::find($id)->name;
        $temp = Product_cat::find($id)->parent_id;
        if ($temp != 0) {
            $cat_parent = Product_cat::find($temp);
        }
        $count = DB::table('products')->whereIn('product_cat_id', $list_id)->count();

        $list_cat_name_0 = Product_cat::where('parent_id', 0)->get();

        foreach ($list_cat_name_0 as $item) {
            $list_child[$item->id] = Product_cat::where('parent_id', $item->id)->get();
            $count1[$item->id] = Product_cat::where('parent_id', $item->id)->count();
        }

        return view('user.product.catProduct', compact('list_brand', 'list_products', 'cat_name', 'id', 'count', 'list_cat_name_0', 'list_child', 'count1', 'cat_parent'));
    } 

    function getProductFilterStatus($id, $status_id)
    {
        $list_id = $this->get_id($id);
        unset($list_id[0]);

        foreach ($list_id as $item) {
            $brand_filter[] = $item;
        }

        // $brand_filter = implode(',', $list_id);

        // if (isset($_GET['brand'])) {
        //     $brand_filter = implode(',', $_GET['brand']);
        // }

        if (isset($_GET['status'])) {
            $status = $_GET['status'];
            if ($status == 1) {
                $name = 'title';
                $orderby = 'desc';
            } elseif ($status == 2) {
                $name = 'title';
                $orderby = 'asc';
            } elseif ($status == 3) {
                $name = 'price';
                $orderby = 'desc';
            } elseif ($status == 4) {
                $name = 'price';
                $orderby = 'asc';
            } else {
                $name = 'id';
                $orderby = 'asc';
            }
        }

        if (isset($_GET['brand'])) {
            $brand_filter = $_GET['brand'];
        }

        if (isset($_GET['maximum_price'])) {
            $n = $_GET['maximum_price'];
        }

        if (isset($_GET['minimum_price'])) {
            $m = $_GET['minimum_price'];
        }


        $result = DB::table('products')
            ->whereBetween('price', [$m, $n])
            ->whereIn('product_cat_id', $brand_filter)
            ->orderBy($name, $orderby)
            ->paginate(40);

        // $result = DB::select('select * from products where product_cat_id in ('. $brand_filter. ') and price between ' . $m . ' and ' . $n);

        $output = '';
        if (count($result) > 0) {
            foreach ($result as $item) { 
                $output .= '
                <li>
                    <a href=" ' . route("detail_product", $item->id) . ' " title="" class="thumb">
                        <img src="' . asset($item->avatar) . '">
                    </a>
                    <a href="?page=detail_product" title=""
                        class="product-name text">' . $item->title . '</a>
                    <div class="price">
                        <span class="new">' . number_format($item->price, 0, "", ".") . 'đ</span>
                    </div>
                    <div class="action clearfix">
                        <a href="?page=cart" title="Thêm giỏ hàng" class="add-cart fl-left"><i
                                class="fas fa-cart-plus"></i> Giỏ hàng</a>
                        <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                    </div>
                </li>
                ';
            }
        } else {
            $output .= "<p class='text-danger'>Không tìm thấy sản phẩm nào</p>";
        }
        return $output;
    }

    // đệ quy lấy những id sản phẩm thuộc 1 danh mục
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

}
