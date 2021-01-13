<?php

namespace App\Http\Controllers;

use App\Product;
use App\Product_cat;
use App\Thumbnail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminProductController extends Controller
{
    //=================== PRODUCT ======================

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);

            return $next($request);
        });
    }

    function data_tree($data, $parent_id = 0, $level = 0)
    {
        $result = [];
        foreach ($data as $item) {
            if ($item['parent_id'] == $parent_id) {
                $item['level'] = $level;
                $result[] = $item;
                $child = $this->data_tree($data, $item['id'], $level + 1);
                $result = array_merge($result, $child);
            }
        }
        return $result;
    }

    function list(Request $request)
    {
        session(['action' => 'list']);
        $keyword = '';
        $status = $request->input('status');
        if ($status == 'trash') {
            $list_act = array(
                'forceDelete' => 'Xóa vĩnh viễn',
                'restore' => 'Khôi phục'
            );
            if ($request->input('keyword')) {
                $keyword = htmlspecialchars($request->input('keyword'));
            }
            $products = Product::onlyTrashed()->where('title', 'like', "%{$keyword}%")->paginate(10);
        } elseif ($status == '0') {
            $list_act = array(
                'delete' => 'Xóa',
                'still' => 'Cập nhật còn hàng'
            );
            if ($request->input('keyword')) {
                $keyword = htmlspecialchars($request->input('keyword'));
            }
            $products = Product::where('title', 'like', "%{$keyword}%")->where('status', '=', '0')->paginate(10);
        } elseif ($status == '1') {
            $list_act = array(
                'delete' => 'Xóa',
                'over' => 'Cập nhật hết hàng'
            );
            if ($request->input('keyword')) {
                $keyword = htmlspecialchars($request->input('keyword'));
            }
            $products = Product::where('title', 'like', "%{$keyword}%")->where('status', '=', '1')->paginate(10);
        } else {
            $list_act = array(
                'delete' => 'Xóa',
            );
            if ($request->input('keyword')) {
                $keyword = htmlspecialchars($request->input('keyword'));
            }
            $products = Product::where('title', 'like', "%{$keyword}%")->paginate(10);
        }

        $count_products_still = Product::where('status', '=', '1')->count();
        $count_products_over = Product::where('status', '=', '0')->count();
        $count_products_trash = Product::onlyTrashed()->count();
        $count = [$count_products_still, $count_products_over, $count_products_trash];
        return view('admin.product.list', compact('products', 'count', 'list_act'));
    }

    function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            if (!empty($list_check)) {
                $act = $request->input('act');

                //Xóa tạm thời
                if ($act == 'delete') {
                    Product::destroy($list_check);

                    return redirect('admin/product/list')->with('status', 'Xóa sản phẩm thành công');
                }

                // Khôi phục
                if ($act == 'restore') {
                    Product::withTrashed()->whereIn('id', $list_check)
                        ->restore();
                    Product::whereIn('id', $list_check)->update(['status' => '0']);

                    return redirect('admin/product/list')->with('status', 'Khôi phục bài viết thành công');
                }

                if ($act == 'still') {
                    Product::whereIn('id', $list_check)->update(['status' => '1']);

                    return redirect('admin/product/list')->with('status', "Đã chuyển trạng thái sản phẩm thành <b>còn hàng</b>");
                }

                if ($act == 'over') {
                    Product::whereIn('id', $list_check)->update(['status' => '0']);

                    return redirect('admin/product/list')->with('status', "Đã chuyển trạng thái sản phẩm thành <b>hết hàng</b>");
                }

                // Xóa vĩnh viễn
                if ($act == 'forceDelete') {
                    Product::withTrashed()->whereIn('id', $list_check)
                        ->forceDelete();

                    return redirect('admin/product/list?status=trash')->with('status', 'Đã xóa sản phẩm khỏi hệ thống');
                }

                if ($act = 'none') {
                    return redirect('admin/product/list')->with('status_err', 'Bạn cần chọn tác vụ để thao tác');
                }
            }
        } else {
            return redirect('admin/product/list')->with('status_err', 'Bạn cần chọn sản phẩm để thao tác');
        }
    }

    function add()
    {
        session(['action' => 'add']);
        $list_cats = Product_cat::select('id', 'name', 'parent_id')->get();
        $result = $this->data_tree($list_cats, 0, 0);

        return view('admin.product.add', compact('result'));
    }

    function store(Request $request)
    {
        // session(['title'=> $request->input('title')]);
        $request->session()->flash('title', $request->input('title'));
        $request->session()->flash('price', $request->input('price'));
        $request->session()->flash('content', $request->input('content'));
        $request->session()->flash('description', $request->input('description'));
        $request->session()->flash('avatar', $request->input('thumbnail'));

        $request->validate(
            [
                'title' => 'required|string|max:255',
                'content' => 'required',
                'thumbnail' => 'required|image',
                'product_cat' => 'required',
                'price'  => 'required|integer',
                'description' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài lớn nhất :max kí tự',
                'integer' => ':attribute phải là số nguyên'
            ],
            [
                'title' => 'Tên sản phẩm',
                'content' => 'Chi tiết sản phẩm',
                'thumbnail' => 'Ảnh đại diện',
                'product_cat' => 'Danh mục',
                'description' => 'Mô tả sản phẩm',
                'price' => 'Giá sản phẩm'
            ]
        );

        if ($request->hasFile('thumbnail')) {
            $file = $request->thumbnail;
            $fileName = $file->getClientOriginalName();
            $path = 'uploads/product/' . $fileName;
            $file->move('public/uploads/product', $file->getClientOriginalName());

            Product::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'user_id' => Auth::id(),
                'product_cat_id' => $request->input('product_cat'),
                'avatar' => $path,
                'status' => '1',
                'price' => $request->input('price'),
                'description'  => $request->input('description'),
            ]);

            return redirect('admin/product/list')->with('status', 'Thêm sản phẩm thành công');
        } else {
            return redirect('admin/product/list')->with('status_err', 'Thêm sản phẩm thất bại');
        }
    }

    function delete(Request $request, $id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect('admin/product/list')->with('status', 'Xóa sản phẩm thành công');
    }

    function forceDelete($id)
    {
        Product::withTrashed()->where('id', $id)
            ->forceDelete();

        return redirect('admin/product/list?status=trash')->with('status', 'Đã xóa sản phẩm khỏi hệ thống');
    }

    function edit($id)
    {
        $product = Product::find($id);
        $list_cats = Product_cat::select('id', 'name', 'parent_id', 'created_at')->get();
        $result = $this->data_tree($list_cats, 0, 0);
        $old_parent_id = Product::find($id)->product_cat;

        return view('admin.product.edit', compact('result', 'product', 'old_parent_id'));
    }

    function update(Request $request, $id)
    {
        $product = Product::find($id);
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'content' => 'required',
                'thumbnail' => 'image',
                'product_cat' => 'required',
                'price'  => 'required|integer',
                'description' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài lớn nhất :max kí tự',
                'integer' => ':attribute phải là số nguyên'
            ],
            [
                'title' => 'Tên sản phẩm',
                'content' => 'Chi tiết sản phẩm',
                'thumbnail' => 'Ảnh đại diện',
                'product_cat' => 'Danh mục',
                'description' => 'Mô tả sản phẩm',
                'price' => 'Giá sản phẩm'
            ]
        );

        if ($request->hasFile('thumbnail')) {
            $file = $request->thumbnail;
            $fileName = $file->getClientOriginalName();
            $path = 'uploads/product/' . $fileName;
            $file->move('public/uploads/product', $file->getClientOriginalName());
        } else {
            $path = $product->avatar;
        }

        Product::where('id', $id)->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => Auth::id(),
            'product_cat_id' => $request->input('product_cat'),
            'avatar' => $path,
            'status' => '1',
            'price' => $request->input('price'),
            'description'  => $request->input('description'),
        ]);

        return redirect('admin/product/list')->with('status', 'Cập nhật sản phẩm thành công');
    }




    // ================== PRODUCT CAT ==================




    function listCat()
    {
        session(['action' => 'listCat']);
        $list_cats = Product_cat::select('id', 'name', 'slug', 'created_at', 'parent_id')->get();
        $result = $this->data_tree($list_cats, 0, 0);

        //Duyệt từng ptu mảng $result
        foreach ($result as $k => $v) {
            //gán số lượng của tên danh mục  = đếm số bản ghi có post_cat_id là id của danh mục
            $count_post[$v['name']] = Product::where('product_cat_id', $v['id'])->count();
        }
        return view('admin.product.cat', compact('result', 'list_cats', 'count_post'));
    }

    function catStore(Request $request)
    {
        $request->session()->flash('name', $request->input('name'));
        $request->session()->flash('slug', $request->input('slug'));

        $request->validate(
            [
                'name' => 'required|string|max:255',
                'parent_id' => 'required',
                'slug' => 'required|regex:/^[A-Za-z0-9-]+$/|max:255'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài lớn nhất :max kí tự',
                'regex' => ':attribute không đúng định dạng',
            ],
            [
                'name' => 'Tên danh mục',
                'parent_id' => 'Danh mục cha',
                'slug' => 'Slug',
            ]
        );

        Product_cat::create([
            'name' => $request->input('name'),
            'parent_id' => $request->input('parent_id'),
            'user_id' => Auth::id(),
            'slug' => $request->input('slug'),
        ]);

        return redirect('admin/product/cat/list')->with('status', 'Thêm danh mục thành công');
    }

    function deleteCat($id)
    {
        $product_cat = Product_cat::find($id);
        $product_cats = Product_cat::where('parent_id', $product_cat->id)->get();
        $product_cat->delete();

        // Đệ quy xóa tất cả danh mục con
        foreach ($product_cats as $item) {
            $product_cats = $this->deleteCat($item->id);
        }

        return redirect('admin/product/cat/list')->with('status', 'Xóa danh mục thành công');
    }

    function editCat($id)
    {
        $product_cat = Product_cat::find($id);
        $list_cats = Product_cat::select('id', 'name', 'slug', 'parent_id', 'created_at')->get();
        $result = $this->data_tree($list_cats, 0, 0);

        //Danh mục cũ
        if ($product_cat->parent_id != 0) {
            $old_parent_id = Product_cat::find($product_cat->parent_id);
        } else {
            $old_parent_id = $product_cat;
        }

        return view('admin.product.editCat', compact('result', 'product_cat', 'old_parent_id'));
    }

    function updateCat(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'parent_id' => 'required',
                'slug' => 'required|regex:/^[A-Za-z0-9-]+$/|max:255'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài lớn nhất :max kí tự',
                'regex' => ':attribute không đúng định dạng',
            ],
            [
                'name' => 'Tên danh mục',
                'parent_id' => 'Danh mục cha',
                'slug' => 'Slug',
            ]
        );

        Product_cat::where('id', $id)->update([
            'name' => $request->input('name'),
            'parent_id' => $request->input('parent_id'),
            'user_id' => Auth::id(),
            'slug' => $request->input('slug'),
        ]);

        return redirect('admin/product/cat/list')->with('status', 'Cập nhật thông tin thành công');
    }

    function addThumbnail($id)
    {
        $product = Product::find($id);
        $thumbnails = Thumbnail::where('product_id', '=', $id)->get();
        return view('admin.product.addThumbnail', compact('id', 'product', 'thumbnails'));
    }

    function storeThumbnail(Request $request, $id)
    {
        $request->session()->flash('color_name', $request->input('color_name'));
        $request->session()->flash('color_code', $request->input('color_code'));
        $request->session()->flash('thumbnail', $request->input('thumbnail'));
        $path_redirect = 'admin/product/add/thumbnail/' . $id;

        $request->validate(
            [
                'thumbnail' => 'required|image',
                'color_code' => 'max:7'
            ],
            // regex:/^#[a-f0-9]{6}$/
            [
                'required' => ':attribute không được để trống',
                'regex' => ':attribute không hợp lệ',
                'image' => ':attribute phải là file ảnh',
                'max' => ':attribute có độ dài lớn nhất :max kí tự'
            ],
            [
                'thumbnail' => 'Ảnh đại diện',
                'color_name'  => 'Tên màu',
                'color_code' => 'Mã màu'
            ]
        );

        if ($request->hasFile('thumbnail')) {
            $file = $request->thumbnail;
            $fileName = $file->getClientOriginalName();
            $path = 'uploads/thumbnail/' . $fileName;
            $file->move('public/uploads/thumbnail', $file->getClientOriginalName());

            Thumbnail::create([
                'product_id' => $id,
                'color_name'  => $request->input('color_name'),
                'color_code'  => $request->input('color_code'),
                'user_id' => Auth::id(),
                'path' => $path,
            ]);

            return redirect($path_redirect)->with('status', 'Thêm ảnh sản phẩm thành công');
        } else {
            return redirect($path_redirect)->with('status_err', 'Thêm ảnh sản phẩm thất bại');
        }
    }

    function deleteThumbnail($id)
    {
        $thumbnail = Thumbnail::find($id);
        $product_id = $thumbnail->product_id;
        $thumbnail->delete();
        $path_redirect = 'admin/product/add/thumbnail/' . $product_id;

        return redirect($path_redirect)->with('status', 'Xóa ảnh sản phẩm thành công');
    }

    function editThumbnail($id)
    {
        $thumbnail = Thumbnail::find($id);
        $product_id = $thumbnail->product_id;
        $product = Product::find($product_id);

        return view('admin.product.editThumbnail', compact('thumbnail', 'product'));
    }

    function updateThumbnail(Request $request, $id)
    {
        $thumbnail = Thumbnail::find($id);
        $product_id = $thumbnail->product_id;
        $path_redirect = 'admin/product/add/thumbnail/' . $product_id;

        $request->validate(
            [
                'thumbnail' => 'image',
                'color_code' => 'max:7|regex:/^#[a-f0-9]{6}$/'
            ],
            [
                'required' => ':attribute không được để trống',
                'regex' => ':attribute không hợp lệ',
                'image' => ':attribute phải là file ảnh',
                'max' => ':attribute có độ dài lớn nhất :max kí tự'
            ],
            [
                'thumbnail' => 'Ảnh đại diện',
                'color_name'  => 'Tên màu',
                'color_code' => 'Mã màu'
            ]
        );

        if ($request->hasFile('thumbnail')) {
            $file = $request->thumbnail;
            $fileName = $file->getClientOriginalName();
            $path = 'uploads/thumbnail/' . $fileName;
            $file->move('public/uploads/thumbnail', $file->getClientOriginalName());
        } else {
            $path = $thumbnail->path;
        }

        Thumbnail::where('id', $id)->update([
            'color_name'  => $request->input('color_name'),
            'color_code'  => $request->input('color_code'),
            'user_id' => Auth::id(),
            'path' => $path,
        ]);

        return redirect($path_redirect)->with('status', 'Cập nhật ảnh sản phẩm thành công');
    }
}
