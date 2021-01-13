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
                    <div class="card-header font-weight-bold">
                        Thêm danh mục
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/post/cat/store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên danh mục</label>
                                <input class="form-control" type="text" name="name" value="{{ request()->session()->get('name') }}" id="name">
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input class="form-control" type="text" name="slug" value="{{ request()->session()->get('slug') }}" data-toggle="tooltip" title="Slug bao gồm chữ cái thường, in hoa, số, kí tự gạch ngang và viết liền không dấu" id="slug">
                                @error('slug')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Danh mục cha</label>
                                <select name="parent_id" class="form-control" id="">
                                    <option value="">Chọn danh mục</option>
                                    <option value="0">Không</option>
                                    @foreach ($result as $item)
                                        <option value="{{ $item->id }}">{{ str_repeat('-- ', $item->level) . $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" name="btn-add" value="Thêm mới" class="btn btn-primary">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh mục
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên danh mục</th>
                                    <th scope="col">Số bài viết</th>
                                    <th scope="col">Ngày tạo</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($result))
                                    @php
                                    $t=0;
                                    @endphp
                                    @foreach ($result as $item)
                                        @php
                                        $t++;
                                        @endphp
                                        <tr>
                                            <th scope="row">{{ $t }}</th>
                                            <td>{{ str_repeat('-- ', $item->level) . $item->name }}</td>
                                            <td class="text-center">{{ $count_post[$item->name] }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td><a href="{{route('edit_post_cat', $item->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{route('delete_post_cat', $item->id)}}" onclick="return confirm('Bạn có chắc chắn xóa danh mục này? Mọi bài viết và danh mục con nằm trong danh mục này cũng sẽ bị xóa !')"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <td colspan="5" class="text-danger">Không có danh mục nào</td>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
