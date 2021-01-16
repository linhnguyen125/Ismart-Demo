@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success">
                {!! session('status') !!}
            </div>
        @endif
        @if (session('status_err'))
            <div class="alert alert-success">
                {!! session('status_err') !!}
            </div>
        @endif
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Thông tin khách hàng</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Mã đơn hàng</h5>
                    <p>{{ $order->order_code }}</p>
                    <h5>Tên khách hàng</h5>
                    <p>{{ $order->fullname }}</p>
                    <h5>Địa chỉ</h5>
                    <p>{{ $order->address }}</p>
                    <h5>Số điện thoại</h5>
                    <p>{{ $order->phone }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Email</h5>
                    <p>{{ $order->email }}</p>
                    <h5>Hình thức thanh toán</h5>
                    @if ($order->payments == 'cod')
                        <p>Thanh toán tại nhà</p>
                    @else
                        <p>Thanh toán qua Internet banking</p>
                    @endif
                    <h5>Tình trạng đơn hàng</h5>
                    <div class="form-action form-inline py-1">
                        <form action="{{ route('order_store', $order->id) }}" method="POST">
                            @csrf
                            <select class="form-control form-control-sm mr-1" name="status" id="">
                                <option value="1" {{ $order->status == '1' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="2" {{ $order->status == '2' ? 'selected' : '' }}>Đang vận chuyển</option>
                                <option value="3" {{ $order->status == '3' ? 'selected' : '' }}>Hoàn thành</option>
                            </select>
                            <input type="submit" name="btn-update" value="Cập nhật" class="btn btn-primary btn-sm">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Chi tiết đơn hàng</h5>
            </div>
            <div class="card-body" style="position: relative; padding-bottom: 3rem">
                <table class="table table-striped table-sm table-checkall">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">#</th>
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
                            $products = $detail->product;
                            $t++;
                            @endphp
                            <tr>
                                <td class="text-center" style="min-width: 45px">{{ $t }}</td>
                                <td><img style="width: 80px; height: auto;" src="{{ asset($products->avatar) }}"
                                        class="img-fluid img-thumbnail" alt="ảnh sản phẩm"></td>
                                <td><a href="#">{{ $products->title }}</a></td>
                                <td>{{ number_format($products->price, 0, '', '.') }}đ</td>
                                <td class="text-center">{{ $detail->qty }}</td>
                                <td>{{ number_format($detail->total, 0, '', '.') }}đ</td>
                                <td>{{ $detail->created_at }}</td>
                            </tr>
                        @endforeach
                        <tr class="">
                            <td colspan="7" style="font-size: 18px; padding-top: 1rem; position: absolute; right: 4rem">
                                <strong>Tổng:
                                </strong>{{ number_format($order->total, 0, '', '.') }}đ
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
