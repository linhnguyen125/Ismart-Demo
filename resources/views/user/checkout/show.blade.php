@extends('layouts.user')

@section('content')
    <div id="main-content-wp" class="checkout-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ url('/') }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="{{ url('checkout/show') }}" title="">Thanh toán</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix">
            <div class="section" id="customer-info-wp">
                <div class="section-head">
                    <h1 class="section-title">Thông tin khách hàng</h1>
                </div>
                <div class="section-detail">
                    <form id="checkoutSelect" method="POST" action="{{ asset('store_checkout') }}" name="form-checkout">
                        @csrf
                        <div class="form-row clearfix">
                            <div class="form-col fl-left">
                                <label for="fullname">Họ tên</label>
                                <input type="text" name="fullname" id="fullname">
                            </div>
                            <div class="form-col fl-right">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email">
                            </div>
                        </div>
                        <div class="mt-3 mb-3 pb-2 d-flex">
                            <div>
                                <select id="province" style="display: inline-block; height:25px; width: 170px"
                                    class="form-select mr-4"
                                    onchange="selectProvince(this.value, '{{ url('/checkout/updateDistrict') }}')">
                                    <option value="0" selected>---- Tỉnh/Thành phố ----</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <select id="district" style="display: inline-block; height:25px; width: 170px"
                                    class="form-select mr-4"
                                    onchange="selectDistrict(this.value, '{{ url('/checkout/updateWard') }}')">
                                    <option value="0" selected>------- Quận/Huyện -------</option>
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <select id="ward" style="display: inline-block; height:25px; width: 170px"
                                    class="form-select">
                                    <option value="0" selected>-------- Phường/Xã --------</option>
                                    @foreach ($wards as $ward)
                                        <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row clearfix">
                            <div class="form-col fl-left">
                                <label for="address">Địa chỉ nhà riêng</label>
                                <input type="text" name="address" id="address">
                            </div>
                            <div class="form-col fl-right">
                                <label for="phone">Số điện thoại</label>
                                <input type="tel" name="phone" id="phone">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-col">
                                <label for="notes">Ghi chú</label>
                                <textarea cols="50" rows="3" name="note"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="section" id="order-review-wp">
                <div class="section-head">
                    <h1 class="section-title">Thông tin đơn hàng</h1>
                </div>
                <div class="section-detail">
                    <table class="shop-table">
                        <thead>
                            <tr>
                                <td>Sản phẩm</td>
                                <td>Tổng</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="cart-item">
                                <td class="product-name">Son môi nữ cá tính<strong class="product-quantity">x 1</strong>
                                </td>
                                <td class="product-total">350.000đ</td>
                            </tr>
                            <tr class="cart-item">
                                <td class="product-name">Đồ tẩy trang nhập khẩu Mỹ<strong class="product-quantity">x
                                        2</strong></td>
                                <td class="product-total">500.000đ</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="order-total">
                                <td>Tổng đơn hàng:</td>
                                <td><strong class="total-price">800.000đ</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div id="payment-checkout-wp">
                        <ul id="payment_methods">
                            <li>
                                <input type="radio" id="direct-payment" name="payment-method" value="banking" disabled>
                                <label for="direct-payment">Thanh toán qua Internet banking</label>
                            </li>
                            <li>
                                <input type="radio" id="payment-home" name="payment-method" value="cod">
                                <label for="payment-home">Thanh toán tại nhà</label>
                            </li>
                        </ul>
                    </div>
                    <div class="place-order-wp clearfix">
                        <input type="submit" id="order-now" value="Đặt hàng">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
