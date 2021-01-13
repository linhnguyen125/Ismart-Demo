@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between">
                <div>Cập nhật sản phẩm</div>
                <div>
                    <a href="{{ route('add_thumbnail', $product->id) }}" class="btn btn-success btn-sm rounded-1 text-white" type="button" data-toggle="tooltip" data-placement="top" title="<small>Thêm ảnh sản phẩm</small>"><i class="fas fa-images"></i></a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('update_product', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="title">Tên sản phẩm</label>
                                <input class="form-control" type="text" value="{{ $product->title }}" name="title"
                                    id="title">
                                @error('title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="price">Giá</label>
                                <input class="form-control" type="text" name="price" value="{{ $product->price }}"
                                    id="price">
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <img style="width: 80px; height: 80px" src="{{ asset($product->avatar) }}"
                                            alt="ảnh cũ">
                                    </div>
                                    <div class="col-md-10">
                                        <label for="file">(Chọn ảnh thumbnail)</label>
                                        <input type="file" name="thumbnail" class="form-control-file mt-2" id="file">
                                        @error('thumbnail')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="description">Mô tả sản phẩm</label>
                                <textarea name="description" class="form-control" id="description" cols="30"
                                    rows="5">{{ $product->description }}</textarea>
                            </div>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content">Chi tiết sản phẩm</label>
                        <textarea name="content" class="form-control" id="content" cols="30"
                            rows="5">{{ $product->content }}</textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Danh mục</label>
                        <select class="form-control" name="product_cat">
                            <option value="{{ $old_parent_id->id }}">Danh mục cũ: {{ $old_parent_id->name }}</option>
                            @foreach ($result as $item)
                                <option value="{{ $item->id }}">{{ str_repeat('-- ', $item->level) . $item->name }}</option>
                            @endforeach
                        </select>
                        @error('product_cat')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" name="btn-edit" value="update" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
