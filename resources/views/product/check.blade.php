@extends('layouts.master')

@section('title')상품 체크@stop

@section('content')
<hr class="all">
<div class="main_content">
    <div class="logbox" style="height: 500px">
        <div class="innerbox">
            <h4>CHECK</h4><br><br>

            @foreach($paymentCheckProducts as $index=>$product)
            <div>
                @foreach($paymentProductCall as $call)
                @if($product->payment_xid == $call->xid)
                {{ $call->content }} ({{ number_format($product->payment_price) }}원) -

                <select name="status{{ $product->payment_xid }}" id="status{{ $product->payment_xid }}">
                    <option value="ok">구매 확정</option>
                    <option value="no">환불</option>
                </select>
                <button type="button" onClick="check({{ $product->payment_xid }})">확인</button>
                @endif
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
</div>
@stop

@section('javascript')
<script src="{{ asset('js/jquery.js') }}"></script>
<script>
    function check(xid) {
        console.log(xid);
        var select = document.getElementById("status" + xid);
        var val =$("#status" + xid + " option:selected").val();

        console.log(val);

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
            url: "{{ route('post.product.payment.check') }}",
            type: "post",
            data: {
                'xid': xid,
                'status': val
            },
            success: function (d) {
                alert('확정 되었습니다.');
                window.location.href = '{{ route('main') }}';
            }
        });
    }

</script>
@stop
