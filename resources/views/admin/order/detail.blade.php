@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Thông tin khách hàng</h5>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>Mã đơn hàng</h5>
                <p>{{$order->order_code}}</p>
                <h5>Tên khách hàng</h5>
                <p>{{$order->user->name}}</p>
                <h5>Địa chỉ</h5>
                <p>{{$order->address}}</p>
                <h5>Số điện thoại</h5>
                <p>{{$order->user->phone}}</p>
            </div>
            <div class="col-md-6">
                <h5>Email</h5>
                <p>{{$order->user->email}}</p>
                <h5>Hình thức thanh toán</h5>
                <p>Thanh toán tại nhà</p>
                <h5>Tình trạng đơn hàng</h5>
                <div class="form-action form-inline py-1">
                    <select class="form-control form-control-sm mr-1" name="act" id=""> 
                        <option value="1">Đang xử lý</option>
                        <option value="2">Đang vận chuyển</option>
                        <option value="3">Hoàn thành</option>
                    </select>
                    <input type="submit" name="btn-update" value="Cập nhật" class="btn btn-primary btn-sm">
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Chi tiết đơn hàng</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped table-sm table-checkall">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Ảnh sản phẩm</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Đơn giá</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Thành tiền</th>
                        <th scope="col">Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $t=0;
                    @endphp
                    @foreach ($details as $detail)
                        @php
                            $products = $detail->products;
                        @endphp
                        @foreach ($products as $item)
                        @php
                            $t++;
                        @endphp
                            <tr>
                            <td>{{$t}}</td>
                            <td><img style="width: 80px; height: 80px;" src="{{asset($item->avatar)}}" class="img-fluid img-thumbnail" alt="ảnh sản phẩm"></td>
                            <td><a href="#">{{$item->title}}</a></td>
                            <td>{{ number_format($item->price, 0, '', '.') }}đ</td>
                            <td class="text-center">{{$detail->qty}}</td>
                            <td>{{number_format($detail->qty * $item->price,0,'','.')}}đ</td>
                            <td>{{$detail->created_at}}</td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection