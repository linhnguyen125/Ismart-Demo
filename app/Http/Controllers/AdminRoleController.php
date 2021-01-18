<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRoleController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'role']);

            return $next($request);
        });
    }

    function list()
    {
        session(['action' => 'list']);
        $roles = Role::paginate(8);

        return view('admin.role.list', compact('roles'));
    }

    function updatePermission(Request $request)
    {
        // $listPermission = [];

        if ($request->roleId == '1') {
            $listPermission = [
                '1' => 'Thêm sản phẩm',
                '2' => 'Sửa sản phẩm',
                '3' => 'Xóa sản phẩm',
                '4' => 'Xem sản phẩm'
            ];
        } elseif ($request->roleId == '2') {
            $listPermission = [
                '5' => 'Thêm bài viết',
                '6' => 'Sửa bài viết',
                '7' => 'Xóa bài viết',
                '8' => 'Xem bài viết'
            ];
        } elseif ($request->roleId == '3') {
            $listPermission = [
                '9' => 'Xem đơn hàng',
                '10' => 'Cập nhật trạng thái',
                '11' => 'Hủy đơn hàng',
            ];
        } elseif ($request->roleId == '4') {
            $listPermission = [
                '12' => 'Thêm banner',
                '13' => 'Sửa banner',
                '14' => 'Xóa banner',
                '15' => 'Xem banner'
            ];
        } elseif ($request->roleId == '5') {
            $listPermission = [
                '18' => 'Thêm user',
                '19' => 'Xem user',
                '22' => 'Sửa user',
                '20' => 'Xóa user',
                '16' => 'Thêm quyền cho user',
                '17' => 'Cập nhật quyền cho ',
            ];
        }

        $t = 0;
        // echo '<div class="form-check">
        //         <input class="form-check-input" type="checkbox" name="list_check[]" value="21" checked>
        //             <label class="form-check-label">
        //                 Admin
        //         </label>
        //     </div>';
        foreach ($listPermission as $k => $v) {
            $t++;
            echo '<div class="form-check">
                      <input class="form-check-input" type="checkbox" name="list_check[]" value="' . $k . '" id="select_' . $t . '">
                      <label class="form-check-label" for="select_' . $t . '">
                             ' . $v . '
                      </label>
                  </div>';
        }
    }

    function store(Request $request)
    {
        $list_check = $request->input('list_check');

        $request->validate([
            [
                'name' => 'required|string|max:50',

            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài lớn nhất :max kí tự',
            ],
            [
                'name' => 'Tên nhóm quyền',
            ]
        ]);

        if (!empty($list_check)) {
            Role::create([
                'name' => $request->input('name')
            ]);
            // Lấy id role thêm cuối cùng
            $lastRoleId = Role::orderBy('id', 'desc')->first();

            RolePermission::create([
                'role_id' => $lastRoleId->id,
                'permission_id' => 21,
            ]);

            foreach ($list_check as $item) {
                RolePermission::create([
                    'role_id' => $lastRoleId->id,
                    'permission_id' => $item
                ]);
            }
            return redirect('admin/role/list')->with('status', 'Thêm nhóm quyền thành công');
        } else {
            return redirect('admin/role/list')->with('status_err', 'Thêm nhóm quyền thất bại, vui lòng chọn quyền');
        }
    }

    function delete($id)
    {
        $role = Role::find($id);
        $role->delete();

        return redirect('admin/role/list')->with('status', 'Xóa nhóm quyền thành công');
    }

    function edit($id)
    {
        $role = Role::find($id);

        return view('admin.role.edit', compact('role'));
    }

    function update(Request $request, $id)
    {
        $list_check = $request->input('list_check');

        $request->validate([
            [
                'name' => 'required|string|max:50',

            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài lớn nhất :max kí tự',
            ],
            [
                'name' => 'Tên nhóm quyền',
            ]
        ]);

        if (!empty($list_check)) {
            Role::where('id', $id)->update([
                'name' => $request->input('name')
            ]);

            // xóa role_permission cũ
            RolePermission::where('role_id', $id)->delete();

            RolePermission::create([
                'role_id' => $id,
                'permission_id' => 21
            ]);

            foreach ($list_check as $item) {
                RolePermission::create([
                    'role_id' => $id,
                    'permission_id' => $item
                ]);
            }
            return redirect('admin/role/list')->with('status', 'Thêm nhóm quyền thành công');
        } else {
            return redirect('admin/role/list')->with('status_err', 'Thêm nhóm quyền thất bại, vui lòng chọn quyền');
        }
    }
}
