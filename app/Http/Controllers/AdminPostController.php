<?php

namespace App\Http\Controllers;

use App\Post;
use App\Post_cat;
use App\Post_status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminPostController extends Controller
{
    // 

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'post']);

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
        session(['action'=>'list']);
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
            $posts = Post::onlyTrashed()->where('title', 'like', "%{$keyword}%")->orderBy('updated_at', 'desc')->paginate(10);
        } elseif ($status == 'pending') {
            $list_act = array(
                'delete' => 'Xóa',
                'public' => 'Công khai'
            );
            if ($request->input('keyword')) {
                $keyword = htmlspecialchars($request->input('keyword'));
            }
            $posts = Post::where('title', 'like', "%{$keyword}%")->where('post_status_id', 1)->orderBy('updated_at', 'desc')->paginate(10);
        } else {
            $list_act = array(
                'delete' => 'Xóa',
                'pending' => 'Chờ duyệt'
            );
            if ($request->input('keyword')) {
                $keyword = htmlspecialchars($request->input('keyword'));
            }
            $posts = Post::where('title', 'like', "%{$keyword}%")->where('post_status_id', 2)->orderBy('updated_at', 'desc')->paginate(10);
        }
        $count_post_pending = Post::where('post_status_id', 1)->count();
        $count_post_public = Post::where('post_status_id', 2)->count();
        $count_post_trash = Post::onlyTrashed()->count();
        $count = [$count_post_pending, $count_post_public, $count_post_trash];
        return view('admin.post.list', compact('posts', 'count', 'list_act','action'));
    }

    function add()
    {
        session(['action'=>'add']);
        $list_cats = Post_cat::select('id', 'name', 'parent_id')->get();
        $result = $this->data_tree($list_cats, 0, 0);
        $post_status = Post_status::all();
        return view('admin.post.add', compact('result', 'post_status'));
    }

    // Xử lý add post
    function store(Request $request)
    {
        $request->session()->flash('title', $request->input('title'));
        $request->session()->flash('content', $request->input('content'));

        $request->validate(
            [
                'title' => 'required|string|max:255',
                'content' => 'required',
                'thumbnail' => 'required|image',
                'post_cat' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài lớn nhất :max kí tự',
            ],
            [
                'title' => 'Tên bài viết',
                'content' => 'Nội dung',
                'thumbnail' => 'Ảnh đại diện',
                'post_cat' => 'Danh mục'
            ]
        );

        if ($request->hasFile('thumbnail')) {
            $file = $request->thumbnail;
            $fileName = $file->getClientOriginalName();
            $path = 'uploads/post/' . $fileName;
            $file->move('public/uploads/post', $file->getClientOriginalName());

            Post::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'user_id' => Auth::id(),
                'post_cat_id' => $request->input('post_cat'),
                'thumbnail' => $path,
                'post_status_id' => $request->input('post_status')
            ]);

            return redirect('admin/post/list')->with('status', 'Thêm bài viết thành công');
        } else {
            return redirect('admin/post/list')->with('status_err', 'Thêm bài viết thất bại');
        }
    }

    function delete(Request $request, $id)
    {
        $post = Post::find($id);
        $post->delete();

        return redirect('admin/post/list?status=trash')->with('status', 'Xóa bài viết thành công');
    }

    function forceDelete($id)
    {
        Post::withTrashed()->where('id', $id)
            ->forceDelete();

        return redirect('admin/post/list?status=trash')->with('status', 'Đã xóa bài viết khỏi hệ thống');
    }

    function edit(Request $request, $id){
        $post = Post::find($id);
        $list_cats = Post_cat::select('id', 'name', 'parent_id', 'created_at')->get();
        $result = $this->data_tree($list_cats, 0, 0);
        $post_status = Post_status::all();
        $old_parent_id = Post::find($id)->post_cat;

        return view('admin.post.edit', compact('result','post_status','post','old_parent_id'));
    }

    function update(Request $request, $id){
        $post = Post::find($id);
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'content' => 'required',
                'thumbnail' => 'image',
                'post_cat' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài lớn nhất :max kí tự',
            ],
            [
                'title' => 'Tên bài viết',
                'content' => 'Nội dung',
                'thumbnail' => 'Ảnh đại diện',
                'post_cat' => 'Danh mục'
            ]
        );

        if ($request->hasFile('thumbnail')) {
            $file = $request->thumbnail;
            $fileName = $file->getClientOriginalName();
            $path = 'uploads/post/' . $fileName;
            $file->move('public/uploads/post', $file->getClientOriginalName());
        }else{
            $path = $post->thumbnail;
        }

        Post::where('id', $id)->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => Auth::id(),
            'post_cat_id' => $request->input('post_cat'),
            'thumbnail' => $path,
            'post_status_id' => $request->input('post_status')
        ]);

        return redirect('admin/post/list')->with('status', 'Cập nhật bài viết thành công');
    }

    function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            if (!empty($list_check)) {
                $act = $request->input('act');

                //Xóa tạm thời
                if ($act == 'delete') {
                    Post::destroy($list_check);

                    return redirect('admin/post/list')->with('status', 'Xóa bài viết thành công');
                }

                // Khôi phục
                if ($act == 'restore') {
                    Post::withTrashed()->whereIn('id', $list_check)
                        ->restore();
                    Post::whereIn('id', $list_check)->update(['post_status_id' => 1]);

                    return redirect('admin/post/list')->with('status', 'Khôi phục bài viết thành công');
                }

                if ($act == 'public') {
                    Post::whereIn('id', $list_check)->update(['post_status_id' => 2]);

                    return redirect('admin/post/list')->with('status', 'Đã chuyển trạng thái bài viết thành công khai');
                }

                if ($act == 'pending') {
                    Post::whereIn('id', $list_check)->update(['post_status_id' => 1]);

                    return redirect('admin/post/list')->with('status', 'Đã chuyển trạng thái bài viết thành công khai');
                }

                // Xóa vĩnh viễn
                if ($act == 'forceDelete') {
                    Post::withTrashed()->whereIn('id', $list_check)
                        ->forceDelete();

                    return redirect('admin/post/list?status=trash')->with('status', 'Đã xóa bài viết khỏi hệ thống');
                }

                if ($act = 'none') {
                    return redirect('admin/post/list')->with('status_err', 'Bạn cần chọn tác vụ để thao tác');
                }
            }
        } else {
            return redirect('admin/post/list')->with('status_err', 'Bạn cần chọn bài viết để thao tác');
        }
    }

    //========================= POST CAT ======================

    function listCat(Request $request)
    {
        session(['action'=>'listCat']);
        $list_cats = Post_cat::select('id', 'name', 'parent_id', 'created_at')->get();
        $result = $this->data_tree($list_cats, 0, 0);

        //Duyệt từng ptu mảng $result
        foreach ($result as $k => $v) {
            //gán số lượng của tên danh mục  = đếm số bản ghi có post_cat_id là id của danh mục
            $count_post[$v['name']] = Post::where('post_cat_id', $v['id'])->count();
        }

        return view('admin.post.cat', compact('result', 'list_cats', 'count_post'));
    }

    //Xử lý add cat
    function catStore(Request $request)
    {

        $request->session()->flash('name', $request->input('name'));
        $request->session()->flash('slug', $request->input('slug'));

        $request->validate(
            [
                'name' => 'required|string|max:255',
                'parent_id' => 'required',
                'slug' => 'required|regex:/^[A-Za-z0-9-]+$/|max:255',
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

        Post_cat::create([
            'name' => $request->input('name'),
            'parent_id' => $request->input('parent_id'), 
            'user_id' => Auth::id(),
            'slug' => $request->input('slug'),
        ]);

        return redirect('admin/post/cat/list')->with('status', 'Thêm danh mục thành công');
    }

    function editCat($id){
        $post_cat = Post_cat::find($id);
        $list_cats = Post_cat::select('id', 'name', 'parent_id', 'created_at')->get();
        $result = $this->data_tree($list_cats, 0, 0);
        //Danh mục cũ
        if($post_cat->parent_id != 0){
            $old_parent_id = Post_cat::find($post_cat->parent_id);
        }else{
            $old_parent_id = $post_cat;
        }
        
        return view('admin.post.editCat', compact('result','post_cat','old_parent_id'));
    }

    function updateCat(Request $request, $id){
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'parent_id' => 'required',
                'slug' => 'required|regex:/^[A-Za-z0-9-]+$/|max:255',
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài lớn nhất :max kí tự',
                'regex' => ':attribute không đúng định dạng',
            ],
            [
                'name' => 'Tên danh mục',
                'parent_id' => 'Danh mục cha',
                'regex' => ':attribute không đúng định dạng',
            ]
        );

        Post_cat::where('id', $id)->update([
            'name'=>$request->input('name'),
            'parent_id' => $request->input('parent_id'),
            'user_id' => Auth::id(),
            'slug' => $request->input('slug'),
        ]);

        return redirect('admin/post/cat/list')->with('status','Cập nhật thông tin thành công');
    }

    function deleteCat($id){
        $post_cat = Post_cat::find($id);
        $post_cats = Post_cat::where('parent_id', $post_cat->id)->get();
        $post_cat->delete();

        // Đệ quy xóa tất cả danh mục con
        foreach($post_cats as $item){
            $post_cats = $this->deleteCat($item->id);
        }

        return redirect('admin/post/cat/list')->with('status','Xóa danh mục thành công');
    }
}
