@extends('layouts.master')
@section('title')상품 목록@stop
@section('content')
<div class="main_pro_content">
    <h4 class="product_intro">NEW</h4>
    <div class="grid_content">

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
@stop
