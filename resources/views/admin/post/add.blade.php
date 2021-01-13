
@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm bài viết
        </div>
        <div class="card-body">
            <form action="{{url('admin/post/store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Tiêu đề bài viết</label>
                    <input class="form-control" type="text" name="title" value="{{ request()->session()->get('title') }}" id="title">
                    @error('title')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Nội dung bài viết</label>
                    <textarea class="form-control" name="content" value="{{ request()->session()->get('content') }}" id="content" cols="30" rows="5"></textarea>
                    @error('content')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="file">Chọn ảnh thumbnail</label>
                    <input type="file" name="thumbnail" class="form-control-file mt-2" id="file">
                    @error('thumbnail')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Danh mục</label>
                    <select class="form-control" name="post_cat">
                        <option value="">Chọn danh mục</option>
                        @foreach ($result as $item)
                            <option value="{{$item->id}}">{{ str_repeat('-- ', $item->level) . $item->name }}</option>
                        @endforeach
                    </select>
                    @error('post_cat')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Trạng thái</label>
                    @php
                        $t = 0;
                    @endphp
                    @foreach ($post_status as $item)
                    @php
                        $t++;
                    @endphp
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="post_status" id="exampleRadios{{$t}}" value="{{$item->id}}" checked>
                        <label class="form-check-label" for="exampleRadios{{$t}}">
                        {{$item->name}}
                        </label>
                    </div>
                    @endforeach
                </div>
                <button type="submit" name="btn-add" value="Thêm mới" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection
