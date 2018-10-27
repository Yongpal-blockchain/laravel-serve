@extends('layouts.master')
@section('title')회원가입@stop
@section('content')
<hr class="all">
<div class="main_content">
    <div class="logbox" style="height: 500px">
        <div class="innerbox">
            <h4>MEMBER REGISTER</h4><br><br>
            <form action="{{ route('post.signup') }}" method="POST" name="account" id="login">
                {{ csrf_field() }}
                <input type="text" name="id" placeholder="아이디" required />
                @if ($errors->has('id'))
                <h6 style="text-align: left; margin-left: 30px; font-weight: 100; margin-top: 3px;">{{
                    $errors->first('id') }}</h6>
                @endif
                @if(session()->has('id-verify'))
                {{ session()->get('id-verify') }}
                @endif
                <input type="text" name="name" placeholder="이름" required />
                @if ($errors->has('name'))
                <h6 style="text-align: left; margin-left: 30px; font-weight: 100; margin-top: 3px;">{{
                    $errors->first('name') }}</h6>
                @endif
                <input type="text" name="phone" placeholder="전화번호" required />
                @if ($errors->has('phone'))
                <h6 style="text-align: left; margin-left: 30px; font-weight: 100; margin-top: 3px;">{{
                    $errors->first('phone') }}</h6>
                @endif
                <input type="password" name="password" placeholder="비밀번호" required />
                @if ($errors->has('password'))
                <h6 style="text-align: left; margin-left: 30px; font-weight: 100; margin-top: 3px;">{{
                    $errors->first('password') }}</h6>
                @endif
                <input type="text" id="address_postcode" name="address_postcode" placeholder="우편번호"><br>
                <input type="button" onclick="execDaumPostcode()" value="우편번호 찾기"><br><br><br>
                <input type="text" id="address_roadAddress" name="address_roadAddress" placeholder="도로명주소">
                <input type="text" id="address_jibunAddress" name="address_jibunAddress" placeholder="지번주소">
                <input type="text" id="address_detail" name="address_detail" placeholder="상세주소">
                @if ($errors->has('address_roadAddress') or $errors->has('address_roadAddress'))
                <h6 style="text-align: left; margin-left: 30px; font-weight: 100; margin-top: 3px;">주소를 입력해주세요.</h6>
                @endif
                <span id="guide" style="color:#999"></span>
                @if ($errors->has('address'))
                <h6 style="text-align: left; margin-left: 30px; font-weight: 100; margin-top: 3px;">{{
                    $errors->first('address') }}</h6>
                @endif
                <input type="submit" id="loginbtn" value="REGISTER" />
            </form>
        </div>
    </div>
</div>
@stop

@section('javascript')
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script>
    //본 예제에서는 도로명 주소 표기 방식에 대한 법령에 따라, 내려오는 데이터를 조합하여 올바른 주소를 구성하는 방법을 설명합니다.
    function execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function (data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
                var extraRoadAddr = ''; // 도로명 조합형 주소 변수

                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
                    extraRoadAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if (data.buildingName !== '' && data.apartment === 'Y') {
                    extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if (extraRoadAddr !== '') {
                    extraRoadAddr = ' (' + extraRoadAddr + ')';
                }
                // 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
                if (fullRoadAddr !== '') {
                    fullRoadAddr += extraRoadAddr;
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('address_postcode').value = data.zonecode; //5자리 새우편번호 사용
                document.getElementById('address_roadAddress').value = fullRoadAddr;
                document.getElementById('address_jibunAddress').value = data.jibunAddress;

                // 사용자가 '선택 안함'을 클릭한 경우, 예상 주소라는 표시를 해준다.
                if (data.autoRoadAddress) {
                    //예상되는 도로명 주소에 조합형 주소를 추가한다.
                    var expRoadAddr = data.autoRoadAddress + extraRoadAddr;
                    document.getElementById('guide').innerHTML = '(예상 도로명 주소 : ' + expRoadAddr + ')';

                } else if (data.autoJibunAddress) {
                    var expJibunAddr = data.autoJibunAddress;
                    document.getElementById('guide').innerHTML = '(예상 지번 주소 : ' + expJibunAddr + ')';

                } else {
                    document.getElementById('guide').innerHTML = '';
                }
            }
        }).open();
    }

</script>
@stop
