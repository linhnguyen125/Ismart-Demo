@extends('layouts.user')

@section('content')
    <div id="main-content-wp" class="clearfix category-product-page">
        <div class="wp-inner">
            <div class="main-content fl-right">
                <div class="section" id="list-product-wp">
                    <div class="section-detail">
                        <ul class="list-item clearfix" id="list_products">
                            @if (empty($products))
                                <p class="text-danger">Không tìm thấy sản phẩm</p>
                            @else
                                @foreach ($products as $product)
                                    <li>
                                        <a href="{{ route('detail_product', $product->id) }}" title="" class="thumb">
                                            <img src="{{ asset($product->avatar) }}">
                                        </a>
                                        <a href="?page=detail_product" title=""
                                            class="product-name text">{{ $product->title }}</a>
                                        <div class="price">
                                            <span class="new">{{ number_format($product->price, 0, '', '.') }}đ</span>
                                        </div>
                                        <div class="action clearfix">
                                            <a href="{{ route('cart_add', $product->id) }}" title="Thêm giỏ hàng" class="add-cart fl-left"><i
                                                    class="fas fa-cart-plus"></i> Giỏ hàng</a>
                                            <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="section" id="paging-wp">
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            {{ $products->links() }}
                        </ul>
                    </div>
                </div>
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
            </div>
        </div>
    </div>
@endsection
