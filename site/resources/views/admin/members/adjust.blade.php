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

<input type="text" class="input-small form-control amount_{{$user_id}}"
       placeholder="Amount" value="{{$total}}"/>
<div class='input-group date' id='filter_month'>
    <input type='text' class="form-control datetime date_{{$user_id}}"
           placeholder="Datetime" value="{{date('d/m/Y')}}"/>
    <span class="input-group-addon">
        <span class="fa fa-calendar">
        </span>
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