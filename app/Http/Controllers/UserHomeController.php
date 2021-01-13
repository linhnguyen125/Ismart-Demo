<?php

namespace App\Http\Controllers;

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

    function home(){
        $products = Product::all();
        // lấy ID danh mục thuộc Điện thoại
        $list_id_mobile = $this->get_id(1);
        $list_id_laptop = $this->get_id(2);

        $mobiles = DB::table('products')->whereIn('product_cat_id',$list_id_mobile)->paginate(40);
        $laptops = DB::table('products')->whereIn('product_cat_id',$list_id_laptop)->paginate(40);

        $list_cat_name_0 = Product_cat::where('parent_id',0)->get();
        foreach($list_cat_name_0 as $item){
            $list_child[$item->id] = Product_cat::where('parent_id',$item->id)->get();
            $count[$item->id] = Product_cat::where('parent_id',$item->id)->count();
        }
        return view('welcome',compact('products','mobiles','laptops','list_cat_name_0','list_child','count')); 
    }

    function get_id($id){
        $cat = Product_cat::find($id);
        $list_id[]=$cat->id;
        $list_cats = Product_cat::where('parent_id',$id)->get();
        foreach($list_cats as $item){
            $this->get_id($item->id);
            $list_id[] = $item->id;
        }
        return $list_id;
    }
}
