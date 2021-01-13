<?php

namespace App\Http\Controllers;

use App\Product;
use App\Product_cat;
use App\Thumbnail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserProductController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);

            return $next($request);
        });
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

    function detail($id)
    {
        $list_cat_name_0 = Product_cat::where('parent_id', 0)->get();

        foreach ($list_cat_name_0 as $item) {
            $list_child[$item->id] = Product_cat::where('parent_id', $item->id)->get();
            $count1[$item->id] = Product_cat::where('parent_id', $item->id)->count();
        }

        $productDetail = Product::find($id);
        $productCatId = $productDetail->product_cat_id;
        $sameCategories = Product::where('product_cat_id', '=', $productCatId)->get();
        $sameCategoriesCount = Product::where('product_cat_id', '=', $productCatId)->count();

        $productThumbnails = Thumbnail::where('product_id', '=', $id)->get();

        return view('user.product.detail', compact('list_cat_name_0', 'list_child', 'count1', 'productDetail', 'productThumbnails', 'sameCategories', 'sameCategoriesCount'));
    }
}
