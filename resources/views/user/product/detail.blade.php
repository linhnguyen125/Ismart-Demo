@extends('layouts.user')

@section('content')
    <div id="main-content-wp" class="clearfix detail-product-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Điện thoại</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="detail-product-wp">
                    <div class="section-detail clearfix">
                        <div class="thumb-wp fl-left" id="show">
                            <a href="" id="main-thumb">
                                <img id="show_img" src="{{ asset($productDetail->avatar) }}" width="350" height="350" />
                            </a>
                            <div id="list-thumb">
                                @foreach ($productThumbnails as $productThumbnail)
                                    <a href="" id="onn">
                                        <img src="{{ asset($productThumbnail->path) }}"
                                            alt="{{ $productThumbnail->color_name }}"
                                            title="{{ $productThumbnail->color_name }}" />
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="thumb-respon-wp fl-left">
                            <img src="public/images/img-pro-01.png" alt="">
                        </div>
                        <div class="info fl-right">
                            <h3 class="product-name">{{ $productDetail->title }}</h3>
                            <div class="desc">
                                {!! html_entity_decode($productDetail->description) !!}
                            </div>
                            <div class="num-product">
                                <span class="title">Sản phẩm: </span>
                                <span class="status">Còn hàng</span>
                            </div>
                            <p class="price">{{ number_format($productDetail->price, 0, '', '.') }}đ</p>
                            <div id="num-order-wp">
                                <a title="" id="minus"><i class="fa fa-minus"></i></a>
                                <input type="text" name="num-order" value="1" id="num-order">
                                <a title="" id="plus"><i class="fa fa-plus"></i></a>
                            </div>
                            <a href="{{ route('cart_add', $productDetail->id) }}" title="Thêm giỏ hàng" class="add-cart">Thêm giỏ hàng</a>
                        </div>
                    </div>
                </div>
                <div class="section" id="post-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Mô tả sản phẩm</h3>
                    </div>
                    <div class="section-detail">
                        {!! $productDetail->content !!}
                    </div>
                </div>
                @if ($sameCategoriesCount > 1)
                    <div class="section" id="same-category-wp">
                        <div class="section-head">
                            <h3 class="section-title">Cùng chuyên mục</h3>
                        </div>
                        <div class="section-detail">
                            <ul class="list-item">
                                @foreach ($sameCategories as $sameCategory)
                                    <li>
                                        <a href="{{route('detail_product', $sameCategory->id)}}" title="" class="thumb">
                                            <img src="{{ asset($sameCategory->avatar) }}">
                                        </a>
                                        <a href="{{route('detail_product', $sameCategory->id)}}" title="" class="product-name">{{ $sameCategory->title }}</a>
                                        <div class="price">
                                            <span class="new">{{ number_format($sameCategory->price, 0, '', '.') }}đ</span>
                                            {{-- <span class="old">20.900.000đ</span>
                                            --}}
                                        </div>
                                        <div class="action clearfix">
                                            <a href="" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                            <a href="" title="" class="buy-now fl-right">Mua ngay</a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
            <div class="sidebar fl-left">
                <div class="section" id="category-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Danh mục sản phẩm</h3>
                    </div>
                    <div class="secion-detail">
                        <ul class="list-item">
                            @foreach ($list_cat_name_0 as $item)
                                <li>
                                    <a href="{{ route('cat_product', $item->id) }}" title="">{{ $item->name }}</a>
                                    @if ($count1[$item->id] > 0)
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
