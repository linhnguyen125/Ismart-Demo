@extends('layouts.user')

@section('content')
<div id="main-content-wp" class="home-page clearfix">
    <div class="wp-inner">
        <div class="main-content fl-right">

            @foreach ($list_products as $k=>$v)
            <div class="section" id="list-product-wp">
                
                <div class="section-head">
                    <h3 class="section-title"><a href="" class="text-dark">{{$k}}</a></h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        @foreach ($v as $n)
                            @foreach ($n as $item)
                                <li>
                                <a href="{{route('detail_product', $item->id)}}" title="" class="thumb">
                                    <img src="{{asset($item->avatar)}}" class="img-fluid">
                                </a>
                                <a href="{{route('detail_product', $item->id)}}" title="" class="product-name text">{{$item->title}}</a>
                                <div class="price">
                                    <span class="new">{{number_format($item->price,0,'','.')}}đ</span>
                                </div>
                                <div class="action clearfix">
                                    <a href="{{ route('cart_add', $item->id) }}" title="Thêm giỏ hàng" class="add-cart fl-left"><i class="fas fa-cart-plus"></i> Giỏ hàng</a>
                                    <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                                </div>
                                </li>
                            @endforeach
                        @endforeach
                    </ul>
                </div>
            </div>
            {{-- <div class="float-right">{{$list_products->links()}}</div> --}}
            @endforeach
            
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
                            <a href="{{route('cat_product',$item->id)}}" title="">{{$item->name}}</a>
                            @if ($count[$item->id] > 0)
                            <ul class="sub-menu">
                                @foreach ($list_child[$item->id] as $child)
                                <li>
                                    <a href="{{route('cat_product',$child->id)}}" title="">{{$child->name}}</a>
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
            <div class="section" id="filter-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Bộ lọc</h3>
                </div>
                <div class="section-detail">
                    <form method="POST" action="">
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2">Giá</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="radio" name="r-price" value="1"></td>
                                    <td>Dưới 500.000đ</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price" value="2"></td>
                                    <td>500.000đ - 1.000.000đ</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price" value="3"></td>
                                    <td>1.000.000đ - 5.000.000đ</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price" value="4"></td>
                                    <td>5.000.000đ - 10.000.000đ</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price" value="5"></td>
                                    <td>Trên 10.000.000đ</td>
                                </tr>
                            </tbody>
                        </table>
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2">Hãng</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="radio" name="r-brand" value="1"></td>
                                    <td>Acer</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-brand" value="2"></td>
                                    <td>Apple</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-brand" value="3"></td>
                                    <td>Hp</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-brand" value="4"></td>
                                    <td>Lenovo</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-brand" value="5"></td>
                                    <td>Samsung</td>
                                </tr>
                            </tbody>
                        </table>
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2">Loại</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="radio" name="r-type" value="1"></td>
                                    <td>Điện thoại</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-type" value="2"></td>
                                    <td>Laptop</td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
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