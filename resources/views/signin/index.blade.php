@extends('layouts.master')
@section('title')로그인@stop
@section('content')
<hr class="all">
<div class="main_content">
    <div class="logbox">
        <div class="innerbox">
            <h4>MEMBER LOGIN</h4>
            <form action="{{ route('post.signin') }}" method="POST" name="login" id="login">
                {{ csrf_field() }}
                <img src="https://raw.githubusercontent.com/Yongpal-blockchain/pc-web-front/master/res/profile.png" alt="">
                <input type="text" name="id" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;id" required />
                @if ($errors->has('id'))
                <h6 style="text-align: left; margin-left: 30px; font-weight: 100; margin-top: 3px;">{{
                    $errors->first('id') }}</h6>
                @endif
                <img src="https://raw.githubusercontent.com/Yongpal-blockchain/pc-web-front/master/res/lock.png" alt="">
                <input type="password" name="password" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;password" required />
                @if ($errors->has('password'))
                <h6 style="text-align: left; margin-left: 30px; font-weight: 100; margin-top: 3px;">{{
                    $errors->first('password')
                    }}</h6>
                @endif
                @if(session()->has('no-password'))
                {{ session()->get('no-password') }}
                @endif
                <input type="submit" id="loginbtn" value="LOGIN" />
            </form>
            <a href="{{ route('get.signup') }}"><span class="logtext ">New Account</span></a>
        </div>
    </div>
</div>
@stop
