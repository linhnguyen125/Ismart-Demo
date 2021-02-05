@extends('layouts.user')

@section('content')
    <div id="main-content-wp" class="cart-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ url('/') }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="{{ route('cart_show') }}" title="">Giỏ hàng</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix">
            @if (session('status'))
                <div class="alert alert-success">
                    {!! session('status') !!}
                </div>
            @endif
            <div class="section" id="info-cart-wp">
                <div class="section-detail table-responsive">
                    <table class="table" id="cartx">
                        <thead>
                            <tr>
                                <td>STT</td>
                                <td>Ảnh sản phẩm</td>
                                <td>Tên sản phẩm</td>
                                <td>Giá sản phẩm</td>
                                <td>Số lượng</td>
                                <td>Thành tiền</td>
                                <td>Tác vụ</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (Cart::count() > 0)
                                @php
                                $t = 0;
                                @endphp
                                @foreach (Cart::content() as $row)
                                    @php
                                    $t++;
                                    @endphp
                                    <tr>
                                        <td style="width: 30px;">{{ $t }}</td>
                                        <td>
                                            <a href="{{ route('detail_product', $row->id) }}" title="" class="thumb">
                                                <img class="img img-fluid" src="{{ asset($row->options->thumbnail) }}"
                                                    alt="">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('detail_product', $row->id) }}" title=""
                                                class="name-product">{{ $row->name }}</a>
                                        </td>
                                        <td>{{ number_format($row->price, 0, ',', '.') }}đ</td>
                                        <td>
                                            {{-- <div class="number-input md-number-input">
                                                <button
                                                    onclick="this.parentNode.querySelector('input[type=number]').stepDown()"
                                                    class="btn btn-sm border minus"><i class="fas fa-minus"></i></button>
                                                <input class="num-order" id="num-order" min="1"
                                                    name="qty[{{ $row->rowId }}]" value="{{ $row->qty }}" type="number"
                                                    style="height: 33px; width: 40px;" data-uri="{{ url('/cart/update') }}"
                                                    onchange="updateCart(this.value, '{{ $row->rowId }}')">
                                                <button
                                                    onclick="this.parentNode.querySelector('input[type=number]').stepUp()"
                                                    class="btn btn-sm border plus"><i class="fas fa-plus"></i></button>
                                            </div> --}}

                                            <input class="num-order" id="num-order_{{ $row->id }}" min="1" name="num-order"
                                                value="{{ $row->qty }}" type="number" data-uri="{{ route('cart_update') }}"
                                                style="height: 35px; width: 45px;"
                                                onChange="updateCart(this.value, '{{ $row->rowId }}')">


                                            {{-- <div id="num-order-wp">
                                                <a title="" id="minus"><i class="fa fa-minus"></i></a>
                                                <input type="text" name="num-order" value="{{ $row->qty }}" id="num-order"
                                                    data-uri="{{ url('/cart/update') }}">
                                                <a title="" id="plus"><i class="fa fa-plus"></i></a>
                                            </div> --}}
                                        </td>
                                        <td>{{ number_format($row->total, 0, ',', '.') }}đ</td>
                                        <td>
                                            <a href="{{ route('cart_remove', $row->rowId) }}" title="Xóa"
                                                class="del-product"><i class="far fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <td colspan="7">
                                    <p class="text-danger m-0">Chưa có sản phẩm nào trong giỏ hàng</p>
                                </td>
                            @endif

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <div class="clearfix">
                                        <p id="total-price" class="fl-right">Tổng giá: <span>{{ Cart::total() }}</span></p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <div class="clearfix">
                                        <div class="fl-right">
                                            <a href="{{ url('thanh-toan') }}" title="" id="checkout-cart">Thanh toán</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="section" id="action-cart-wp">
                <div class="section-detail">
                    <p class="title">Nhấn vào thanh toán để hoàn tất mua hàng.
                    </p>
                    <a href="{{ url('/') }}" title="" id="buy-more">Mua tiếp</a><br />
                    <a href="{{ route('cart_destroy') }}" title="" id="delete-cart">Xóa giỏ hàng</a>
                </div>
            </div>
        </div>
    </div>
@endsection
