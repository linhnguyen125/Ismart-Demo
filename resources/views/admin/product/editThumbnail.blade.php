@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                <div>Cập nhật ảnh sản phẩm</div>
            </div>
            <div class="card-body">
                <form action="{{ route('update_thumbnail', $thumbnail->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="">Tên sản phẩm</label>
                        <input class="form-control" type="text" value="{{ $product->title }}" name="title" disabled>
                    </div>
                    <div class="form-group">
                        <label for="color_name">(Tên màu)</label>
                        <input class="form-control" type="text" value="{{ $thumbnail->color_name }}"
                            name="color_name" id="color_name">
                        @error('color_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="color_code">(Mã màu)</label>
                        <input class="form-control" type="text" value="{{ $thumbnail->color_code }}"
                            name="color_code" id="color_code" placeholder="VD: #ff00ff">
                        @error('color_code')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                <img style="width: 80px; height: 80px" src="{{ asset($thumbnail->path) }}"
                                    alt="ảnh cũ">
                            </div>
                            <div class="col-md-10">
                                <label for="file">(Chọn ảnh)</label>
                                <input type="file" name="thumbnail" class="form-control-file mt-2" id="file">
                                @error('thumbnail')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="btn-add" value="Thêm mới" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
