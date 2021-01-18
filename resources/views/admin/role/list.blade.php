@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('status_err'))
                        <div class="alert alert-danger">
                            {{ session('status_err') }}
                        </div>
                    @endif
                    <div class="card-header font-weight-bold">
                        <div>Thêm nhóm quyền</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('storeRole') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên nhóm quyền</label>
                                <input class="form-control" type="text" value="{{ request()->session()->get('name') }}"
                                    name="name" id="name">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="module">Module: </label>
                                <select class="form-select" name="module" id="module"
                                    onchange="selectModule(this.value, '{{ url('/admin/role/updatePermission') }}')">
                                    <option value="" selected>-- Chọn Module --</option>
                                    <option value="1">Sản phẩm</option>
                                    <option value="2">Bài viết</option>
                                    <option value="3">Bán hàng</option>
                                    <option value="4">Banner</option>
                                    <option value="5">User</option>
                                </select>
                            </div>
                            <div class="form-group" id="permission">

                            </div>
                            <button type="submit" name="btn-add" value="Thêm mới" class="btn btn-primary">Thêm
                                mới</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        <div>Danh sách nhóm quyền</div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-checkall">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Ngày tạo</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($roles->count() > 0)
                                    @php
                                    $t = 0;
                                    @endphp
                                    @foreach ($roles as $role)
                                        @php
                                        $t++;
                                        @endphp
                                        <tr class="">
                                            <td>{{ $t }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>{{ $role->created_at }}</td>
                                            <td><a href="{{ route('edit_role', $role->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="<small>Sửa</small>"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ route('delete_role', $role->id) }}"
                                                    onclick="return confirm('Bạn có chắc chắn xóa nhóm quyền này ?')"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="<small>Xóa</small>"><i
                                                        class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <td colspan="9">
                                        <p class="text-danger m-0">Không tìm thấy kết quả</p>
                                    </td>
                                @endif
                            </tbody>
                        </table>
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
