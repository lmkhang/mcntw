$(document).ready(function () {
    //Datetime picker
    $('.datetime').datetimepicker({
        viewMode: 'days',
        format: 'DD/MM/YYYY',
        icons: {
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        }
    });
});

function perform(that) {
    BootstrapDialog.confirm('Do you want to adjust?', function (result) {
        if (result) {
            //Clear
            $('.message_' + user_id).html();
            //$("#adjust_modal").modal();
            var user_id = $(that).data('user-id');
            var is_payment = $('.is_payment_' + user_id + ' option:selected').val();
            var type = $('.type_' + user_id + ' option:selected').val() ? $('.type_' + user_id + ' option:selected').val() : 2;
            var amount = $('.amount_' + user_id).val();
            var date = $('.date_' + user_id).val();
            var reason = $('.reason_' + user_id).val() ? $('.reason_' + user_id).val() : 'Pay for user';

            //send to Server
            var request = $.ajax({
                url: "/adminntw/member/adjust",
                async: false,
                method: "POST",
                data: {
                    "user_id": user_id,
                    "is_payment": is_payment,
                    "type": type,
                    "amount": amount,
                    "date": date,
                    "reason": reason
                },
                dataType: "json",
                cache: false
            });

            request.done(function (response) {
                if (response.error == true) {
                    BootstrapDialog.show({
                        title: 'Notice',
                        message: 'There are some errors in your input or Invalid!'
                    });
                } else if (response.error == false) {
                    //Result
                    $('.td_amount_' + user_id).html(response.total + '$');
                    $('.td_last_income_' + user_id).html(response.last_income);
                    $('.message_' + user_id).html("OK");
                    //Clear
                    $('.amount_' + user_id).val('');
                    $('.reason_' + user_id).val('');
                    $('.tr_' + user_id).animate({
                        backgroundColor: "#F5F5F5",
                        color: "#B0C8F5"
                    }, 1000);
                }
            });

            request.fail(function (jqXHR, textStatus) {
                BootstrapDialog.show({
                    title: 'Notice',
                    message: 'There are some errors from server!'
                });
            });
        }
    });

}

function isPayment(that) {
    var user_id = $(that).data('user-id');
    if ($('.is_payment_' + user_id).find(":selected").val() == 1) {
        $('.type_' + user_id).val(2);
        $('.type_' + user_id).prop('disabled', true);
        $('.amount_' + user_id).val(parseFloat($('.td_amount_' + user_id).html()));
        $('.reason_' + user_id).attr('readonly', 'readonly');
    } else {
        $('.type_' + user_id).prop('disabled', false);
        $('.amount_' + user_id).val('');
        $('.reason_' + user_id).prop('readonly', false);
    }
}