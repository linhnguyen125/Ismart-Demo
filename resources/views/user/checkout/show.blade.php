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
            @if (session('status'))
                <div class="alert alert-success">
                    {!! session('status') !!}
                </div>
            @endif
            <form id="checkoutSelect" method="POST" action="{{ route('store_checkout') }}" name="form-checkout">
                @csrf
                <div class="section" id="customer-info-wp">
                    <div class="section-head">
                        <h1 class="section-title">Thông tin khách hàng</h1>
                    </div>
                    <div class="section-detail">
                        <div class="form-row clearfix">
                            <div class="form-col fl-left">
                                <label for="fullname">Họ tên</label>
                                <input type="text" name="fullname" value="{{ request()->session()->get('fullname') }}"
                                    id="fullname">
                                @error('fullname')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-col fl-right">
                                <label for="email">Email</label>
                                <input type="email" name="email" value="{{ request()->session()->get('email') }}"
                                    id="email">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-3 mb-3 pb-2 d-flex">
                            <div>
                                <select id="province" name="province"
                                    style="display: inline-block; height:25px; width: 170px" class="form-select mr-4"
                                    onchange="selectProvince(this.value, '{{ url('/checkout/updateDistrict') }}')">
                                    <option value="" selected>---- Tỉnh/Thành phố ----</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                                @error('province')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div>
                                <select id="district" name="district"
                                    style="display: inline-block; height:25px; width: 170px" class="form-select mr-4"
                                    onchange="selectDistrict(this.value, '{{ url('/checkout/updateWard') }}')">
                                    <option value="" selected>------- Quận/Huyện -------</option>
                                </select>
                                @error('district')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div>
                                <select id="ward" name="ward" style="display: inline-block; height:25px; width: 170px"
                                    class="form-select">
                                    <option value="" selected>-------- Phường/Xã --------</option>
                                </select>
                                @error('ward')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row clearfix">
                            <div class="form-col fl-left" style="width: 50%; padding-right: 30px">
                                <label for="address">Địa chỉ nhà riêng</label>
                                <input type="text" name="address" value="{{ request()->session()->get('address') }}"
                                    id="address">
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-col fl-right" style="width: 50%">
                                <label for="phone">Số điện thoại</label>
                                <input type="tel" name="phone" value="{{ request()->session()->get('phone') }}" id="phone">
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-col">
                                <label for="notes">Ghi chú</label>
                                <textarea cols="75" rows="3" name="note">{{ request()->session()->get('note') }}</textarea>
                            </div>
                        </div>

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
                                @foreach (Cart::content() as $row)
                                    <tr class="cart-item">
                                        <td class="product-name">{{ $row->name }} <strong class="product-quantity"> x
                                                {{ $row->qty }}</strong>
                                        </td>
                                        <td class="product-total">{{ number_format($row->total, 0, ',', '.') }}đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="order-total">
                                    <td>Tổng đơn hàng:</td>
                                    <td><strong class="total-price">{{ Cart::total() }}</strong>
                                    </td>
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
                                    <input type="radio" id="payment-home" name="payment-method" value="cod" checked>
                                    <label for="payment-home">Thanh toán tại nhà</label>
                                </li>
                            </ul>
                        </div>
                        <div class="place-order-wp clearfix">
                            <input type="submit" id="order-now" value="Đặt hàng">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
