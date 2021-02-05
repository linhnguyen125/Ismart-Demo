@extends('layouts.user')

@section('content')
    <div id="main-content-wp" class="clearfix blog-page">
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
                <div class="section" id="list-blog-wp">
                    <div class="section-head clearfix">
                        <h3 class="section-title">Blog</h3>
                    </div>
                    <div class="section-detail">
                        @if ($posts->count() > 0)
                            <ul class="list-item">
                                @foreach ($posts as $post)
                                    <li class="clearfix">
                                        <a href="{{ route('detail_blog', $post->id) }}" title="" class="thumb fl-left">
                                            <img class="img-fluid" src="{{ asset($post->thumbnail) }}" alt="blog">
                                        </a>
                                        <div class="info fl-right">
                                            <a href="{{ route('detail_blog', $post->id) }}" title=""
                                                class="title">{{ $post->title }}</a>
                                            <span class="create-date">{{ $post->created_at }}</span>
                                            <div class="desc">{!! $post->content !!}</div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-danger">Hiện tại chưa có bài viết nào...</div>
                        @endif
                    </div>
                    <div class="pagination float-right">
                        {{ $posts->links() }}
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
                        <a href="{{ url('page/blog/detail') }}_product" title="" class="thumb">
                            <img src="{{ asset('images/banner.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
