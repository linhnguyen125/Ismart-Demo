@extends('layouts.user') 

@section('content')
    <div id="main-content-wp" class="clearfix category-product-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ url('/') }}" title="">Trang chủ</a>
                        </li>
                        @if (!empty($cat_parent))
                            <li>
                                <a href="{{ route('cat_product', $cat_parent->id) }}" title="">{{ $cat_parent->name }}</a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('cat_product', $id) }}" title="">{{ $cat_name }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="list-product-wp">
                    <div class="section-head clearfix">
                        <h3 class="section-title fl-left">{{ $cat_name }}</h3>
                        <div class="filter-wp fl-right">
                            <p class="desc">
                                @if ($count < 40)
                                    Hiển thị {{ $count }}/{{ $count }} sản phẩm
                                @else
                                    Hiển thị 40/{{ $count }} sản phẩm
                                @endif
                            </p>
                            <div class="form-filter">
                                <select name="select" id="status_filter">
                                    <option value="0">Sắp xếp</option>
                                    <option value="1">Từ A-Z</option>
                                    <option value="2">Từ Z-A</option>
                                    <option value="3">Giá cao xuống thấp</option>
                                    <option value="4">Giá thấp lên cao</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix" id="list_products">
                            @if (empty($list_products))
                                <p class="text-danger">Không tìm thấy sản phẩm</p>
                            @else
                                @foreach ($list_products as $product)
                                    <li>
                                        <a href="{{ route('detail_product', $product->id) }}" title="" class="thumb">
                                            <img src="{{ asset($product->avatar) }}">
                                        </a>
                                        <a href="?page=detail_product" title=""
                                            class="product-name text">{{ $product->title }}</a>
                                        <div class="price">
                                            <span class="new">{{ number_format($product->price, 0, '', '.') }}đ</span>
                                            {{-- <span class="old">20.900.000đ</span>
                                            --}}
                                        </div>
                                        <div class="action clearfix">
                                            <a href="?page=cart" title="Thêm giỏ hàng" class="add-cart fl-left"><i
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
                            {{ $list_products->links() }}
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
                <div class="section" id="filter-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Bộ lọc</h3>
                    </div>
                    <div class="section-detail">
                        
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2" class="pb-0">Giá</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="hidden" id="hidden_minimum_price" value="0">
                                        <input type="hidden" id="hidden_maximum_price" value="100000000">
                                    </td>
                                    <tr>
                                        <td><p id="price_show">Từ 500000 - 100000000</p>
                                        <div id="price_range"></div></td>
                                    </tr>
                                </tr>
                            </tbody>
                        </table>
                        
                        @if (count($list_brand)>0)
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2">Hãng</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_brand as $item)
                                    <tr>
                                        <td><input type="checkbox" class="common_selector brand" value="{{ $item->id }}">
                                        </td>
                                        <td>{{ $item->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>

                {{-- <div class="section" id="banner-wp">
                    <div class="section-detail">
                        <a href="?page=detail_product" title="" class="thumb">
                            <img src="public/images/banner.png" alt="">
                        </a>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
