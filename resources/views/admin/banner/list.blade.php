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
                        Thêm banner
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/banner/store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="description">Mô tả</label>
                                <input class="form-control" type="text" name="description"
                                    value="{{ request()->session()->get('description') }}" data-toggle="tooltip"
                                    id="description">
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="file">Banner (848 x 371px)</label>
                                <input type="file" name="banner" class="form-control-file mt-2" id="file">
                                @error('banner')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-1" value="1">
                                <label class="form-check-label" for="status-1">
                                    Active
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-2" value="0" checked>
                                <label class="form-check-label" for="status-2">
                                    Inactive
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2" name="btn-add" value="Thêm mới">Thêm
                                mới</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh sách
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Banner</th>
                                    <th scope="col">Mô tả</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($banners->count() > 0)
                                    @php
                                    $t=0;
                                    @endphp
                                    @foreach ($banners as $banner)
                                        @php
                                        $t++;
                                        @endphp
                                        <tr>
                                            <td scope="row">{{ $t }}</td>
                                            <td><img style="width: 80px; height: auto;" src="{{ asset($banner->path) }}"
                                                    class="img-fluid img-thumbnail" alt="banner"></td>
                                            <td>{{ $banner->description }}</td>
                                            @if ($banner->status == '1')
                                                <td><span class="badge badge-success">Active</span></td>
                                            @else
                                                <td><span class="badge badge-warning">Inactive</span></td>
                                            @endif
                                            <td><a href="{{ route('edit_banner', $banner->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="<small>Sửa</small>"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ route('delete_banner', $banner->id) }}"
                                                    onclick="return confirm('Bạn có chắc chắn xóa banner này?')"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="<small>Xóa</small>"><i
                                                        class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-danger text-center">Không có banner nào</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
