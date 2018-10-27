@extends('layouts.master')
@section('title')홈@stop

@section('content')
<div class="banner">
    <img src="https://raw.githubusercontent.com/Yongpal-blockchain/pc-web-front/master/res/banner.png" alt="banner img"
        id="banners" />
</div>

<div class="main_pro_content">
    <h4 class="product_intro">NEW</h4>
    <div class="grid_content">
        <!-- 만약 서버까지 구현한다면 for문 돌려서 8개 가져올 듯? -->

        @foreach($products as $product)
        <div class="product_content" style="cursor:pointer" onClick="window.location.href = '{{ route('get.product.show', ['xid' => $product->product_xid]) }}'">
            @foreach($productSubs as $productSub)
            @if($productSub->xid == $product->product_xid)
            <img src="images/{{ $product->product_xid }}.png" alt="상품이미지" class="pc_img" />
            @endif
            @endforeach
            <div class="pc_underbox">
                <p class="pc_name">
                    {{ $product->product_owner }}</p>
                <p class="pc_pname">
                    {{ $product->product_title }}</p>
                <p class="pc_price">
                    {{ number_format($product->product_price) }}원</p>
                <p class="pc_new">NEW</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="lately_watched_product">
    <h4>최근 본 상품</h4>
    <hr class="all">
    <!--없으면 회색 아니고 아예 없게-->
    <img src="product.jpg" alt="상품이미지">
    <img src="product.jpg" alt="상품이미지">
    <img src="product.jpg" alt="상품이미지">
    <hr class="all">
</div>
@stop
