$(document).ready(function () {
    //Initial Selected Multiple
    createSelected('#filter_user_id');

    //Datetime picker
    $('.datetime').datetimepicker({
        viewMode: 'days',
        format: 'MM/DD/YYYY',
        icons: {
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        }
    });
});

function createSelected(id) {
    $(id).multiselect({
        maxHeight: 400,
        inheritClass: true,
        buttonContainer: '<div class="btn-group" />',
        buttonWidth: '250px',
        disableIfEmpty: true,
        nonSelectedText: 'All!'
    });
}

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

            var _reason_temp = is_payment == 1 ? 'Payment for {mm-YYYY} (Dailymotion)' : '';

            var reason = $('.reason_' + user_id).val() ? $('.reason_' + user_id).val() : _reason_temp;

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
                    $('.new_amount_' + user_id).html('');
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

function changeAmount(that, user_id, payment_method) {
    if (payment_method == 1 && $('.is_payment_' + user_id + ' option:selected').val() == 1) {
        //Bank ( VietNam )
        if ($(that).val() > 0) {
            new_amount = (($(that).val() * currency) - tax_pay_bank);
        } else {
            new_amount = 0;
        }
        new_amount = new_amount.toLocaleString();
        //split
        new_amount = new_amount.split(".");
        //get
        new_amount = new_amount[0];
        //replace
        new_amount = new_amount.replace(",", ".") + ' VND';


        $('.new_amount_' + user_id).html(new_amount);
    } else {
        $('.new_amount_' + user_id).html('');
    }
}