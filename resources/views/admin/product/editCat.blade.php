@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-8">
                <div class="card">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card-header font-weight-bold">
                        Chỉnh sửa danh mục
                    </div>
                    <div class="card-body">
                        <form action="{{ route('update_product_cat', $product_cat->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên danh mục</label>
                                <input class="form-control" type="text" name="name" value="{{$product_cat->name}}" id="name">
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input class="form-control" type="text" name="slug" value="{{$product_cat->slug}}" data-toggle="tooltip" title="Slug bao gồm chữ cái thường, in hoa, số, kí tự gạch ngang và viết liền không dấu" id="slug">
                                @error('slug')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Danh mục cha</label>
                                <select name="parent_id" class="form-control" id="">
                                    <option value="{{$product_cat->parent_id}}">Danh mục cũ: {{$old_parent_id->name}}</option>
                                    <option value="0">Không</option>
                                    @foreach ($result as $item)
                                        <option value="{{ $item->id }}">{{ str_repeat('-- ', $item->level) . $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" name="btn-edit" value="update" class="btn btn-primary">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
