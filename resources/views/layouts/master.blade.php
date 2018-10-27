<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>라운드샵 :: @yield('title')</title>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    <header>
        <div class="main_content">
            <div class="left_float" id="sns">
                <a href="#"><img src="https://raw.githubusercontent.com/Yongpal-blockchain/pc-web-front/master/res/RD_LOGO_m.png"
                        alt="" id="logos"></a>
                <a href="http://facebook.com"><img src="https://raw.githubusercontent.com/Yongpal-blockchain/pc-web-front/master/res/facebook.png"
                        alt=""></a>
                <a href="http://instagram.com"><img src="https://raw.githubusercontent.com/Yongpal-blockchain/pc-web-front/master/res/insta.png"
                        alt=""></a>
            </div>

            <div class="right_float helvetica" id="head">
                <ul class="menu_list">
                    @if(Auth::check())
                    <li><a href="{{ route('logout') }}">LOGOUT</a></li>
                    @if(Auth::User()->level >= 1)
                    <a href="{{ route('get.product.add') }}">PRODUCT ADD</a>
                    @endif
                    @else
                    <li><a href="{{ route('login') }}">SIGNIN</a></li>
                    <li><a href="{{ route('get.signup') }}">SIGNUP</a></li>
                    @endif

                    <li><a href="mypage.html">MYPAGE</a></li>
                    <li><a href="cart.html">CART(1)</a></li>
                </ul>
            </div>
            <div class="clear_float">asdf</div>
        </div>
    </header>
    <hr class="all" />
    <div class="main_content">
        <h1><img src="https://raw.githubusercontent.com/Yongpal-blockchain/pc-web-front/master/res/logo.png" alt="" onClick="window.location.href='{{ route('main') }}'" style="cursor:pointer"></h1>

        <form action="search.html" method="get" id="searchbox">
            <input type="text" class="text">
            <input type="image" class="button" src="https://raw.githubusercontent.com/Yongpal-blockchain/pc-web-front/master/res/search.png">
        </form>
    </div>
    <hr class="all">

    <div class="main_content">
        <nav>
            <ul class="menu_list" id="navs">
                <li><a href="allmenu.html">
                        <img src="https://raw.githubusercontent.com/Yongpal-blockchain/pc-web-front/master/res/hamburger.png"
                            alt="hamburger button" id="hams" />
                    </a></li>
                <li><a href="menu_aboutus.html">ABOUT US</a></li>
                <li><a href="menu_onlineshop.html">ONLINE SHOP</a></li>
                <li><a href="menu_mystore.html">MY STORE</a></li>
                <li><a href="menu_talk.html">TALK</a></li>
            </ul>
        </nav>
    </div>
    @yield('content')
    <hr class="all">
    <div class="main_content center_align">
        <ul class="menu_list" id="moremargin">
            <li><a href="notice.html">
                    공지사항
                </a></li>
            <li><a href="faq.html">
                    자주 묻는 질문
                </a></li>
            <li><a href="OPpolicy.html">
                    운영정책
                </a></li>
            <li><a href="ad.html">
                    광고센터
                </a></li>
            <li><a href="personalQA.html">
                    1:1문의
                </a></li>
            <li><a href="PrivacyPolicy.html">
                    개인정보취급방침
                </a></li>
        </ul>
    </div>
    <footer>
        <div class="short_content left_align">
            상호명 : 라운드샵 | 사업자 등록번호 : 11@-81-95574 | 사업자등록번호 확인<br> 통신판매업신고: 제 2018-서울강남-@2962호 | 주소 : 서울특별시 강남구 테헤란로
            131,36층 | 대표자 : 박용팔<br> 라운드샵Copyright&copy;RoundShop.All rights reserved.
        </div>
    </footer>

    <script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
    @include('sweetalert::alert')
    @yield('javascript')
</body>

</html>
