@extends('layouts.user')

@section('content')
    <div id="main-content-wp" class="clearfix detail-blog-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ url('/') }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="{{ url('page/blog') }}" title="">Blog</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="detail-blog-wp">
                    <div class="section-head clearfix">
                        <h3 class="section-title">{{ $post->title }}</h3>
                    </div>
                    <div class="section-detail">
                        <span class="create-date">{{ $post->created_at }}</span>
                        <div class="detail">
                            {!! $post->content !!}
                        </div>
                    </div>
                </div>
                <div class="section" id="social-wp">
                    <div class="section-detail">
                        <div class="fb-like" data-href="" data-layout="button_count" data-action="like" data-size="small"
                            data-show-faces="true" data-share="true"></div>
                        <div class="g-plusone-wp">
                            <div class="g-plusone" data-size="medium"></div>
                        </div>
                        <div class="fb-comments" id="fb-comment" data-href="" data-numposts="5"></div>
                    </div>
                </div>
            </div>
            <div class="sidebar fl-left">
                <div class="section" id="selling-wp">
                    <div class="section-head">
                        <h3 class="section-title">Sản phẩm bán chạy</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            @if ($bestSellingProducts->count() > 0)
                                @foreach ($bestSellingProducts as $product)
                                    <li class="clearfix">
                                        <a href="{{ route('detail_product', [$product->slug, $product->id]) }}" title=""
                                            class="thumb fl-left">
                                            <img src="{{ asset($product->avatar) }}" alt="">
                                        </a>
                                        <div class="info fl-right">
                                            <a href="{{ route('detail_product', [$product->slug, $product->id]) }}" title=""
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
                        <a href="?page=detail_product" title="" class="thumb">
                            <img src="{{ asset('images/banner.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
