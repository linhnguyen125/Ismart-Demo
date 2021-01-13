@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách đơn hàng</h5>
            <div class="form-search form-inline">
                <form action="#">
                    <input type="" class="form-control form-search" name="keyword" value="{{request()->input('keyword')}}" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">  
            <div class="analytic">
                <a href="{{ request()->fullUrlWithQuery(['status' => '1']) }}" class="text-primary">Đang xử lý<span class="text-muted">({{$count[0]}})</span></a>
                <a href="{{ request()->fullUrlWithQuery(['status' => '2']) }}" class="text-primary">Đang vận chuyển<span class="text-muted">({{$count[1]}})</span></a>
                <a href="{{ request()->fullUrlWithQuery(['status' => '3']) }}" class="text-primary">Hoàn thành<span class="text-muted">({{$count[2]}})</span></a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Đã xóa<span class="text-muted">({{$count[3]}})</span></a>
            </div>
            <form action="{{ url('admin/order/action') }}" method="POST">
                @csrf
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" name="act" id="">
                        <option value="none">Chọn</option>
                        @foreach ($list_act as $k=>$v)
                            <option value="{{$k}}">{{$v}}</option>
                        @endforeach
                    </select>
                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                </div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {!! session('status') !!}
                    </div>
                @endif

                @if (session('status_err'))
                    <div class="alert alert-danger">
                        {!! session('status_err') !!}
                    </div>
                @endif
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" name="checkall">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Mã</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Giá trị</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($orders->total()>0)
                            @php
                                $t=0;
                            @endphp
                            @foreach ($orders as $item)
                                @php
                                    $t++;
                                @endphp
                                <tr>
                                    <td>
                                        <input type="checkbox" name="list_check[]" value="{{$item->id}}">
                                    </td>
                                    <td>{{$t}}</td>
                                    <td>{{$item->order_code}}</td>
                                    <td>
                                        {{$item->name}}
                                    </td>
                                    <td>{{$item->phone}}</td>
                                    <td>{{ number_format($item->total, 0, '', '.') }}đ</td>

                                    @if ($item->status == 1)
                                        <td><span class="badge badge-warning">Đang xử lý</span></td>
                                    @elseif ($item->status == 2)
                                        <td><span class="badge badge-primary">Đang vận chuyển</span></td>
                                    @else
                                        <td><span class="badge badge-success">Hoàn thành</span></td>
                                    @endif

                                    <td>{{$item->created_at}}</td>
                                    <td>
                                        <a href="{{ route('detail_order', $item->id) }}" style="width: 30px;" class="btn btn-info btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="<small>Chi tiết</small>"><i class="fas fa-info"></i></a>
                                        <a href="{{ route('delete_order', $item->id) }}" onclick="return confirm('Bạn có chắc chắn xóa đơn hàng này?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="<small>Xóa</small>"><i class="fa fa-trash"></i></a>
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
            </form>
            {{$orders->links()}}
        </div>
    </div>
</div>
@endsection