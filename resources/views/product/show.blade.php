@extends('layouts.master')
@section('title')상품 상세정보@stop
@section('content')
<hr class="all">
<div class="clear_float">asdfasdf<br><br><br></div>
<div class="main_content">
    <div class="imgview">
        <img src="{{ asset('images/' . $product[0]->product_xid . '.png') }}" alt="" class="bigimg">
        <img src="res/S_IMG.png" alt="" class="smallimg1">
        <img src="res/S_IMG%202.png" alt="" class="smallimg1">
    </div>
    <div class="detailview">
        <div class="detailhead">
            <h3>{{ $product[0]->product_title }}</h3>
            <hr class="all1">
            <div class="detailname">판매자 :
                <!--판매자명--> {{ $product[0]->product_owner }}</div>
        </div>
        <table class="detailtable">
            <tr>
                <td>가격</td>
                <td class="detail_price">{{ number_format($product[0]->product_price) }}원</td>
            </tr>
            <tr>
                <td>상품상태</td>
                <td>{{ $product[0]->product_status }}</td>
            </tr>
            <tr>
                <td>배송비</td>
                <td>배송비 별도</td>
            </tr>
            <tr>
                <td>거래지역</td>
                <td>{{ $product[0]->product_address }}</td>
            </tr>
        </table>
        <br>
        @if(Auth::Check())
        <form action="{{ route('post.product.payment') }}" method="POST" style="display: inline-block">
            {{ csrf_field() }}
            <input type="submit" value="바로구매" class="btn blackbtn" style="cursor: pointer">
            <input type="hidden" name="xid" value="{{ $product[0]->product_xid }}">
            <input type="hidden" name="username" value="{{ Auth::User()->user_id }}">
            <input type="hidden" name="price" value="{{ $product[0]->product_price }}">
        </form>
        @else
        <input type="button" value="바로구매" class="btn blackbtn" style="cursor: pointer" onClick="alert('로그인을 해주시기 바랍니다.')">
        @endif
        <input type="button" value="연락하기" class="btn whitebtn">
        <input type="button" value="관심상품" class="btn whitebtn">

        <hr class="all1">
        <div class="viewreview">판매자 평가 보기</div>



        <br>
    </div>
    <div class="clear_float">zasdfasdfasf</div>
    <div class="main_content pad">
        <br>상품정보
        <hr class="all1">
        {{ $productSub->content }}
    </div>
</div>
@stop
