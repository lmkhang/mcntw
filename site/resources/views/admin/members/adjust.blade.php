<select class="input-small form-control form-inline is_payment_{{$user_id}} payment" data-user-id="{{$user_id}}"
        onchange="isPayment(this);">
    <option value="0">Custom</option>
    <option value="1" selected>Payment</option>
</select>

<select class="input-small form-control form-inline type_{{$user_id}}" disabled>
    @foreach($in_expen_status as $k=>$v)
        <option value="{{$k}}">{{$v}}</option>
    @endforeach
</select>
<div class='input-group'>
    <input type="text" class="input-small form-control amount_{{$user_id}}"
           placeholder="Amount" value="{{$total}}"
           onchange="changeAmount(this, '{{$user_id}}', '{{$payment_method}}'); return false;"/>
    {{--Bank ( VietNam )--}}
    @if($payment_method==1)
        <span class="input-group-addon new_amount_{{$user_id}}">
            {{ number_format(($total*$currency-$tax_pay_bank), 2).' VND'  }}
        </span>
    @endif
</div>

<div class='input-group date' id='filter_month'>
    <input type='text' class="form-control datetime date_{{$user_id}}"
           placeholder="Datetime" value="{{date('m/d/Y')}}"/>
    <span class="input-group-addon">
        mm/dd/YYYY
    </span>
</div>

<input type="text" class="input form-control form-inline reason_{{$user_id}}"
       placeholder="Reason" readonly/>


<button type="button" class="btn btn-sm btn-green form-inline"
        data-user-id="{{$user_id}}"
        onclick="perform(this); return false;">
    Adjust
</button>
<span class="message_{{$user_id}} text-red"></span>