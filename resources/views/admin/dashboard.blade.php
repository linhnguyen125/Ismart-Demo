@extends('layouts.admin')
@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $orderSuccessful->count() }}</h5>
                        <p class="card-text">Đơn hàng giao dịch thành công</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐANG XỬ LÝ & VẬN CHUYỂN</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $orderProcessing->count() }}</h5>
                        <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                    <div class="card-header">DOANH SỐ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($sales, 0, '', '.') }} VNĐ</h5>
                        <p class="card-text">Doanh số hệ thống</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG HỦY</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $orderCancel->count() }}</h5>
                        <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end analytic  -->
        <div class="card">
            <div class="card-header font-weight-bold">
                ĐƠN HÀNG MỚI
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
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
                        @if ($orders->count() > 0)
                            @php
                            $t=0;
                            @endphp
                            @foreach ($orders as $item)
                                @php
                                $t++;
                                @endphp
                                <tr>
                                    <td>{{ $t }}</td>
                                    <td>{{ $item->order_code }}</td>
                                    <td>
                                        {{ $item->fullname }}
                                    </td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ number_format($item->total, 0, '', '.') }}đ</td>

                                    @if ($item->status == 1)
                                        <td><span class="badge badge-warning">Đang xử lý</span></td>
                                    @elseif ($item->status == 2)
                                        <td><span class="badge badge-primary">Đang vận chuyển</span></td>
                                    @else
                                        <td><span class="badge badge-success">Hoàn thành</span></td>
                                    @endif

                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <a href="{{ route('detail_order', $item->id) }}" style="width: 30px;"
                                            class="btn btn-info btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="<small>Chi tiết</small>"><i
                                                class="fas fa-info"></i></a>
                                        <a href="{{ route('delete_order', $item->id) }}"
                                            onclick="return confirm('Bạn có chắc chắn hủy đơn hàng này?')"
                                            class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="<small>Hủy</small>"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <td colspan="8">
                                <p class="text-danger m-0">Chưa có đơn hàng nào</p>
                            </td>
                        @endif
                    </tbody>
                </table>
                <nav aria-label="Page navigation example">
                    {{ $orders->links() }}
                </nav>
            </div>
        </div>

    </div>
@endsection
