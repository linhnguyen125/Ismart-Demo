<?php

namespace App\Http\Controllers;

use App\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBannerController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'banner']);

            return $next($request);
        });
    }

    function list()
    {
        session(['action' => 'list']);
        $banners = Banner::all();

        return view('admin.banner.list', compact('banners'));
    }

    function store(Request $request)
    {
        $request->session()->flash('description', $request->input('description'));
        $request->session()->flash('banner', $request->input('banner'));

        $request->validate(
            [
                'description' => 'required',
                'banner' => 'required|image',
            ],
            [
                'required' => ':attribute không được để trống',
                'image' => ':attribute phải là file ảnh'
            ],
            [
                'description' => 'Mô tả',
                'banner' => 'Banner',
            ]
        );


        if ($request->hasFile('banner')) {
            $file = $request->banner;
            $fileName = $file->getClientOriginalName();
            $path = 'uploads/banner/' . $fileName;
            $file->move('public/uploads/banner', $file->getClientOriginalName());

            Banner::create([
                'description'  => $request->input('description'),
                'path' => $path,
                'status' => $request->input('status'),
                'user_id' => Auth::id(),
            ]);

            return redirect('admin/banner/list')->with('status', 'Thêm banner thành công');
        } else {
            return redirect('admin/banner/list')->with('status_err', 'Thêm banner thất bại');
        }

        return redirect('admin/user/list')->with('status', 'Thêm mới thành viên thành công');
    }

    function delete($id)
    {
        $banner = Banner::find($id);
        $banner->delete();

        return redirect('admin/banner/list')->with('status', 'Xóa banner thành công');
    }

    function edit($id)
    {
        $banner = Banner::find($id);

        return view('admin.banner.edit', compact('banner'));
    }

    function update(Request $request, $id)
    {
        $banner = Banner::find($id);

        $request->validate(
            [
                'description' => 'required',
                'banner' => 'image',
            ],
            [
                'required' => ':attribute không được để trống',
                'image' => ':attribute phải là file ảnh'
            ],
            [
                'description' => 'Mô tả',
                'banner' => 'Banner',
            ]
        );

        if ($request->hasFile('banner')) {
            $file = $request->banner;
            $fileName = $file->getClientOriginalName();
            $path = 'uploads/banner/' . $fileName;
            $file->move('public/uploads/banner', $file->getClientOriginalName());
        } else {
            $path = $banner->path;
        }

        Banner::where('id', $id)->update([
            'description'  => $request->input('description'),
            'user_id' => Auth::id(),
            'status' => $request->input('status'),
            'path' => $path,
        ]);

        return redirect('admin/banner/list')->with('status', 'Cập nhật banner thành công');
    }
}
