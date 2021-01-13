@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card"> 

        @if (session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif

        @if (session('status_err'))
            <div class="alert alert-danger">
                {{session('status_err')}}
            </div>
        @endif

        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách thành viên</h5>
            <div class="form-search form-inline">
                <form action="#">
                    <input type="" class="form-control form-search" name="keyword" value="{{request()->input('keyword')}}" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['status'=>'active'])}}" class="text-primary">Kích hoạt<span class="text-muted">({{$count[0]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary">Vô hiệu hóa<span class="text-muted">({{$count[1]}})</span></a>
                {{-- <a href="" class="text-primary">Trạng thái 3<span class="text-muted">(20)</span></a> --}}
            </div>
            <form action="{{url('admin/user/action')}}" method="POST">
                @csrf
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" name="act" id="">
                        <option value="none">Chọn</option>
                        {{-- <option value="delete">Xóa</option>
                        <option value="restore">Khôi phục</option> --}}
                        @foreach ($list_act as $k => $v)
                            <option value="{{$k}}">{{$v}}</option>
                        @endforeach
                    </select>
                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" name="checkall">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Họ tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Quyền</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->total()>0)
                        @php
                        $temp = 0;
                        @endphp
                        @foreach ($users as $user)
                        @php
                            $temp++;
                        @endphp 
                        <tr>
                            <td>
                                <input type="checkbox" name="list_check[]" value="{{$user->id}}">
                            </td>
                            <td scope="row">{{$temp}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>Admintrator</td>
                            <td>{{$user->created_at}}</td>
                            <td>
                                <a href="{{route('edit_user', $user->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                @if (Auth::id() != $user->id)
                                    <a href="{{route('delete_user', $user->id)}}" onclick="return confirm('Bạn có chắc chắn xóa tài khoản này ?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                        @else
                            <tr>
                                <td colspan="7"><p class="text-danger m-0">Không tìm thấy kết quả</p></td>
                            </tr>
                        @endif
                        
                    </tbody>
                </table>
            </form>
            {{-- PHÂN TRANG --}}
            {{$users->links()}}
        </div>
    </div>
</div>
@endsection
