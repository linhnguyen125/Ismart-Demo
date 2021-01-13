<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    //

    function __construct()
    {
        $this->middleware(function($request, $next){
            session(['module_active'=>'user']);

            return $next($request);
        });
    }

    function list(Request $request){ 
        session(['action'=>'list']);
        $list_act = array(
            'delete'=>'Xóa'
        );
        $status = $request->input('status');
        if($status == 'trash'){
            $list_act = array(
                'forceDelete'=>'Xóa vĩnh viễn',
                'restore'=>'Khôi phục'
            );
            $keyword = " ";
            if($request->input('keyword')){
                $keyword = htmlspecialchars($request->input('keyword'));
            }
            $users = User::onlyTrashed()->where('name','like',"%{$keyword}%")->orWhere('email','like',"%{$keyword}%")
            ->orderBy('updated_at','desc')->paginate(10);
        }else{
            $list_act = array(
                'delete'=>'Xóa'
            );
            $keyword = " ";
            if($request->input('keyword')){
                $keyword = htmlspecialchars($request->input('keyword'));
            }
            $users = User::where('name','like',"%{$keyword}%")->orWhere('email','like',"%{$keyword}%")
            ->orderBy('updated_at','desc')->paginate(10);
        }
        $count_user_active = User::count();
        $count_user_trash = User::onlyTrashed()->count();
        $count = [$count_user_active, $count_user_trash];
        
        return view('admin.user.list', compact('users', 'count','list_act'));
    }

    function add(){
        session(['action'=>'add']);
        return view('admin.user.add');
    }

    function store(Request $request){
        // $timestamp = time();
        $request->validate( 
            [
                'name'=>'required|string|max:255',
                'email'=>'required|string|email|max:255|unique:users',
                'password'=>'required|string|min:8|confirmed'
            ],
            [
                'required'=>':attribute không được để trống',
                'min'=>':attribute có độ dài ít nhất :min kí tự',
                'max'=>':attribute có độ dài lớn nhất :max kí tự',
                'confirmed'=>'Xác nhận mật khẩu không thành công'
            ],
            [
                'name'=>'Tên người dùng',
                'email'=>'Email',
                'password'=>'Mật khẩu'
            ]
        );
        User::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            // 'email_verified_at'=>date("Y-m-d H:i:s", $timestamp),
            'password'=>Hash::make($request->input('password'))
        ]);

        return redirect('admin/user/list')->with('status','Thêm mới thành viên thành công');
    }

    function delete($id){ 
        if(Auth::id() != $id){
            $user = User::find($id);
            $user->delete();

            return redirect('admin/user/list')->with('status', 'Xóa thành viên thành công');
        }else{
            return redirect('admin/user/list')->with('status_err', 'Xóa tài khoản không thành công! Bạn không thể tự xóa chính mình khỏi hệ thống');
        }
    }

    function action(Request $request){
        $list_check = $request->input('list_check');
        if($list_check){
            //Loại bỏ thao tác trên chính user đang login
            foreach($list_check as $k => $id){
                if(Auth::id() == $id)
                    unset($list_check[$k]);
            }
            if(!empty($list_check)){
                $act = $request->input('act');

                // Xóa tạm thời
                if($act == 'delete'){
                    User::destroy($list_check);

                    return redirect('admin/user/list')->with('status','Xóa thành viên thành công');
                }

                // Khôi phục
                if($act == 'restore'){
                    User::withTrashed()->whereIn('id',$list_check)
                    ->restore();

                    return redirect('admin/user/list')->with('status', 'Khôi phục thành viên thành công');
                }

                // Xóa vĩnh viễn
                if($act == 'forceDelete'){
                    User::withTrashed()->whereIn('id',$list_check)
                    ->forceDelete();

                    return redirect('admin/user/list')->with('status', 'Đã xóa thành viên khỏi hệ thống');
                }

                if($act = 'none'){
                    return redirect('admin/user/list')->with('status_err','Bạn cần chọn tác vụ để thao tác');
                }
            }
            return redirect('admin/user/list')->with('status_err','Bạn không thể thao tác trên chính tài khoản của mình');
        }else{
            return redirect('admin/user/list')->with('status_err','Bạn cần chọn thành viên để thao tác');
        }
    }

    function edit($id){
        $user = User::find($id);

        return view('admin.user.edit', compact('user')); 
    }

    function update(Request $request, $id){
        $request->validate(
            [
                'name'=>'required|string|max:255',
                // 'email'=>'required|string|email|max:255|unique:users',
            ],
            [
                'required'=>':attribute không được để trống',
                'max'=>':attribute có độ dài lớn nhất :max kí tự',
            ],
            [
                'name'=>'Tên người dùng',
                // 'email'=>'Email',
            ]
        );
        User::where('id', $id)->update([
            'name'=>$request->input('name'),
            // 'email'=>$request->input('email')
        ]);

        return redirect('admin/user/list')->with('status','Cập nhật thông tin thành công');
    }
}
