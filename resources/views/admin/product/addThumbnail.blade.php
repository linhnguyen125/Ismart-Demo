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
                            {{ session('status_arr') }}
                        </div>
                    @endif
                    <div class="card-header font-weight-bold">
                        <div>Thêm ảnh sản phẩm</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('storeThumbnail', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">Tên sản phẩm</label>
                                <input class="form-control" type="text" value="{{ $product->title }}" name="title" disabled>
                            </div>
                            <div class="form-group">
                                <label for="color_name">(Tên màu)</label>
                                <input class="form-control" type="text"
                                    value="{{ request()->session()->get('color_name') }}" name="color_name" id="color_name">
                                @error('color_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="color_code">(Mã màu)</label>
                                <input class="form-control" type="text"
                                    value="{{ request()->session()->get('color_code') }}" name="color_code" id="color_code" placeholder="VD: #ff00ff">
                                @error('color_code')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="file">Ảnh</label>
                                <input type="file" name="thumbnail" class="form-control-file mt-2" id="file">
                                @error('thumbnail')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
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
                        <div>Ảnh sản phẩm</div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-checkall">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Ảnh</th>
                                    <th scope="col">Tên màu</th>
                                    <th scope="col">Mã màu</th>
                                    <th scope="col">Ngày tạo</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($thumbnails))
                                    @php
                                    $t = 0;
                                    @endphp
                                    @foreach ($thumbnails as $thumbnail)
                                        @php
                                        $t++;
                                        @endphp
                                        <tr class="">
                                            <td>{{ $t }}</td>
                                            <td><img style="width: 80px; height: 80px;" src="{{ asset($thumbnail->path) }}"
                                                    class="img-fluid img-thumbnail" alt="ảnh sản phẩm"></td>
                                            <td>@if (!empty($thumbnail->color_name))
                                                {{ $thumbnail->color_name }}
                                            @else
                                                {{ "Null" }}
                                            @endif</td>
                                            <td>@if (!empty($thumbnail->color_code))
                                                {{ $thumbnail->color_code }}
                                            @else
                                                {{ "Null" }}
                                            @endif</td>
                                            <td>{{ $thumbnail->created_at }}</td>
                                            <td><a href="{{ route('edit_thumbnail', $thumbnail->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="<small>Sửa</small>"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ route('delete_thumbnail', $thumbnail->id) }}"
                                                    onclick="return confirm('Bạn có chắc chắn xóa ảnh sản phẩm này ?')"
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
