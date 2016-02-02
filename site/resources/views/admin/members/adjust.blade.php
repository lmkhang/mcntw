<select class="input-small form-control form-inline type_{{$user_id}}">
    @foreach($in_expen_status as $k=>$v)
        <option value="{{$k}}">{{$v}}</option>
    @endforeach
</select>
<input type="text" class="input-small form-control amount_{{$user_id}}"
       placeholder="Amount"/>
<input type="text" class="input form-control form-inline reason_{{$user_id}}"
       placeholder="Reason"/>

<button type="button" class="btn btn-sm btn-green form-inline"
        data-user-id="{{$user_id}}"
        onclick="perform(this); return false;">
    Adjust
</button>
<span class="message_{{$user_id}} text-red"></span>