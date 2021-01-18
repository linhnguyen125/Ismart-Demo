@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-6">
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
                        <form action="{{ route('updateRole', $role->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên nhóm quyền</label>
                                <input class="form-control" type="text" value="{{ $role->name }}" name="name" id="name">
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

                            <button type="submit" name="btn-update" value="Cập nhật" class="btn btn-primary">Cập
                                nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
