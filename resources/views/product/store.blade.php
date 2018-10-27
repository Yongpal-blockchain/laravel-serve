@extends('layouts.master')
@section('title')상품 등록@stop
@section('content')
<form action="{{ route('post.product.add') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="text" name="title" placeholder="상품 제목" required />
    <input type="text" name="content" placeholder="상품 내용" required />
    <input type="text" name="address" placeholder="거래 장소" required />
    <input type="text" name="item_status" placeholder="상품 상태" required />
    <input type="text" name="price" placeholder="상품 가격" required />
    <input type="file" name="file" required />
    <!-- unique key, 제목, 내용(DB저장), 글쓴이, 거래지역, 상품상태, 가격 -->
    <button type="submit">submit</button>
</form>
@stop