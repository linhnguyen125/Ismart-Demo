@extends('layouts.user')

@section('content')
    <div id="main-content-wp" class="home-page clearfix">
        <div class="wp-inner">
            <div class="main-content fl-right">
                @if ($banners->count() > 0)
                    <div class="section" id="slider-wp">
                        <div class="section-detail">
                            @foreach ($banners as $banner)
                                <div class="item">
                                    <img src="{{ asset($banner->path) }}" title="{{ $banner->description }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="section" id="support-wp">
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-1.png">
                                </div>
                                <h3 class="title">Miễn phí vận chuyển</h3>
                                <p class="desc">Tới tận tay khách hàng</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-2.png">
                                </div>
                                <h3 class="title">Tư vấn 24/7</h3>
                                <p class="desc">1900.9999</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-3.png">
                                </div>
                                <h3 class="title">Tiết kiệm hơn</h3>
                                <p class="desc">Với nhiều ưu đãi cực lớn</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-4.png">
                                </div>
                                <h3 class="title">Thanh toán nhanh</h3>
                                <p class="desc">Hỗ trợ nhiều hình thức</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-5.png">
                                </div>
                                <h3 class="title">Đặt hàng online</h3>
                                <p class="desc">Thao tác đơn giản</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="section" id="feature-product-wp">
                    <div class="section-head">
                        <h3 class="section-title"><a href="" class="text-dark">Sản phẩm mới</a></h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            @foreach ($products as $product)
                                <li>
                                    <a href="{{ route('detail_product', $product->id) }}" title=""
                                        class="thumb">
                                        <img class="img-fluid" src="{{ asset($product->avatar) }}">
                                    </a>
                                    <a href="{{ route('detail_product', $product->id) }}" title=""
                                        class="product-name text">{{ $product->title }}</a>
                                    <div class="price">
                                        <span class="new">{{ number_format($product->price, 0, '', '.') }}đ</span>
                                        {{-- <span class="old">6.190.000đ</span>
                                        --}}
                                    </div>
                                    <div class="action clearfix">
                                        <a href="{{ route('cart_add', $product->id) }}" title="" class="add-cart fl-left"><i
                                                class="fas fa-cart-plus"></i> Giỏ hàng </a>
                                        <a href="{{ route('buy_now', $product->id) }}" title="" class="buy-now fl-right">Mua
                                            ngay</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="section" id="list-product-wp">
                    <div class="section-head">
                        <h3 class="section-title"><a href="" class="text-dark">Điện thoại</a></h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            @foreach ($mobiles as $mobile)
                                <li>
                                    <a href="{{ route('detail_product', $mobile->id) }}" title=""
                                        class="thumb">
                                        <img src="{{ asset($mobile->avatar) }}" class="img-fluid">
                                    </a>
                                    <a href="{{ route('detail_product', $mobile->id) }}" title=""
                                        class="product-name text">{{ $mobile->title }}</a>
                                    <div class="price">
                                        <span class="new">{{ number_format($mobile->price, 0, '', '.') }}đ</span>
                                        {{-- <span class="old">8.990.000đđ</span>
                                        --}}
                                    </div>
                                    <div class="action clearfix">
                                        <a href="{{ route('cart_add', $mobile->id) }}" title="Thêm giỏ hàng"
                                            class="add-cart fl-left"><i class="fas fa-cart-plus"></i> Giỏ hàng</a>
                                        <a href="{{ route('buy_now', $mobile->id) }}" title="Mua ngay"
                                            class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                {{-- <div class="float-right">{{ $mobiles->links() }}</div>
                --}}
                <div class="section" id="list-product-wp">
                    <div class="section-head">
                        <h3 class="section-title"><a href="" class="text-dark">Laptop</a></h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            @foreach ($laptops as $laptop)
                                <li>
                                    <a href="{{ route('detail_product', $laptop->id) }}" title=""
                                        class="thumb">
                                        <img class="img-fluid" src="{{ asset($laptop->avatar) }}">
                                    </a>
                                    <a href="{{ route('detail_product', $laptop->id) }}" title=""
                                        class="product-name text">{{ $laptop->title }}</a>
                                    <div class="price">
                                        <span class="new">{{ number_format($laptop->price, 0, '', '.') }}đ</span>
                                        {{-- <span class="old">8.690.000đ</span>
                                        --}}
                                    </div>
                                    <div class="action clearfix">
                                        <a href="{{ route('cart_add', $laptop->id) }}" title="Thêm giỏ hàng"
                                            class="add-cart fl-left"><i class="fas fa-cart-plus"></i> Giỏ hàng</a>
                                        <a href="{{ route('buy_now', $laptop->id) }}" title="Mua ngay"
                                            class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                {{-- <div class="float-right">{{ $laptops->links() }}</div>
                --}}
            </div>
            {{-- CATEGORY --}}
            <div class="sidebar fl-left">
                <div class="section" id="category-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Danh mục sản phẩm</h3>
                    </div>
                    <div class="secion-detail">
                        <ul class="list-item">
                            @foreach ($list_cat_name_0 as $item)
                                <li>
                                    <a href="{{ route('cat_product', $item->id) }}"
                                        title="">{{ $item->name }}</a>
                                    @if ($count[$item->id] > 0)
                                        <ul class="sub-menu">
                                            @foreach ($list_child[$item->id] as $child)
                                                <li>
                                                    <a href="{{ route('cat_product', $child->id) }}"
                                                        title="">{{ $child->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                {{-- END CATEGORY --}}
                <div class="section" id="selling-wp">
                    <div class="section-head">
                        <h3 class="section-title">Sản phẩm bán chạy</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            @if ($bestSellingProducts->count() > 0)
                                @foreach ($bestSellingProducts as $product)
                                    <li class="clearfix">
                                        <a href="{{ route('detail_product', $product->id) }}" title=""
                                            class="thumb fl-left">
                                            <img src="{{ asset($product->avatar) }}" alt="">
                                        </a>
                                        <div class="info fl-right">
                                            <a href="{{ route('detail_product', $product->id) }}" title=""
                                                class="product-name">{{ $product->title }}</a>
                                            <div class="price">
                                                <span class="new">{{ number_format($product->price, 0, '', '.') }}đ</span>
                                            </div>
                                            <a href="{{ route('buy_now', $product->id) }}" title="" class="buy-now">Mua
                                                ngay</a>
                                        </div>
                                    </li>
                                @endforeach
                            @endif

                        </ul>
                    </div>
                </div>
                <div class="section" id="banner-wp">
                    <div class="section-detail">
                        <a href="" title="" class="thumb">
                            <img src="public/images/banner.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
