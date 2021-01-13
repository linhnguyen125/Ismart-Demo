
@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Chỉnh sửa bài viết
        </div>
        <div class="card-body">
            <form action="{{route('update_post', $post->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Tiêu đề bài viết</label>
                    <input class="form-control" type="text" name="title" value="{{$post->title}}" id="title">
                    @error('title')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Nội dung bài viết</label>
                    <textarea class="form-control" name="content" id="content" cols="30" rows="5">{{$post->content}}</textarea>
                    @error('content')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1">
                            <img style="width: 80px; height: 80px" src="{{asset($post->thumbnail)}}" alt="ảnh cũ">
                        </div>
                        <div class="col-md-11">
                            <label for="exampleFormControlFile1">(Chọn ảnh thumbnail)</label>
                            <input type="file" name="thumbnail" class="form-control-file" id="exampleFormControlFile1">
                            @error('thumbnail')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                  </div>

                <div class="form-group">
                    <label for="">Danh mục</label>
                    <select class="form-control" name="post_cat">
                        <option value="{{$old_parent_id->id}}">Danh mục cũ: {{$old_parent_id->name}}</option>
                        @foreach ($result as $item)
                            <option value="{{$item->id}}">{{str_repeat('-- ', $item->level) . $item->name }}</option>
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
                <button type="submit" name="btn-update" value="update" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
@endsection
