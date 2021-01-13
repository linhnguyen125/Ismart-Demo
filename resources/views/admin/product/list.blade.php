@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách sản phẩm</h5>
            <div class="form-search form-inline">
                <form action="#">
                    <input type="" class="form-control form-search" name="keyword" value="{{request()->input('keyword')}}" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{ request()->fullUrlWithQuery(['status' => '1']) }}" class="text-primary">Còn hàng<span class="text-muted">({{$count[0]}})</span></a>
                <a href="{{ request()->fullUrlWithQuery(['status' => '0']) }}" class="text-primary">Hết hàng<span class="text-muted">({{$count[1]}})</span></a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Đã xóa<span class="text-muted">({{$count[2]}})</span></a>
            </div>
            <form action="{{ url('admin/product/action') }}" method="POST">
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
                            <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col" style="width: 435px;">Tên sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($products->total()>0)
                        @php
                            $t = 0;
                        @endphp
                        @foreach ($products as $product)
                            @php
                                $t++;
                            @endphp
                            <tr class="">
                                <td>
                                    <input type="checkbox" name="list_check[]" value="{{$product->id}}">
                                </td>
                                <td>{{$t}}</td>
                                <td><img style="width: 80px; height: 80px;" src="{{asset($product->avatar)}}" class="img-fluid img-thumbnail" alt="ảnh sản phẩm"></td>
                                <td><a href="#">{{$product->title}}</a></td>
                                <td>{{ number_format($product->price, 0, '', '.') }}đ</td>
                                <td>{{$product->product_cat->name}}</td>
                                <td>{{$product->created_at}}</td>
                                @if ($product->status == '1')
                                    <td><span class="badge badge-success">Còn hàng</span></td>
                                @else
                                    <td><span class="badge badge-warning">Hết hàng</span></td>
                                @endif
                                <td><a href="{{ route('edit_product', $product->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="<small>Sửa</small>"><i class="fa fa-edit"></i></a>
                                @if (empty($product->deleted_at))
                                    <a href="{{ route('delete_product', $product->id) }}" onclick="return confirm('Bạn có chắc chắn xóa bài viết này ?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="<small>Xóa</small>"><i class="fa fa-trash"></i></a>
                                @else
                                    <a href="{{ route('forceDelete_product', $product->id) }}" onclick="return confirm('Bạn có chắc chắn xóa bài viết này khỏi hệ thống ?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                @endif
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
            {{$products->links()}}
        </div>
    </div>
</div>
@endsection