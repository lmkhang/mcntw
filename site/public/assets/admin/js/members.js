$(document).ready(function () {

});

function perform(that) {
    //Clear
    $('.message_' + user_id).html();
    //$("#adjust_modal").modal();
    var user_id = $(that).data('user-id');
    var type = $('.type_' + user_id + ' option:selected').val();
    var amount = $('.amount_' + user_id).val();
    var reason = $('.reason_' + user_id).val();

    //send to Server
    var request = $.ajax({
        url: "/adminntw/member/adjust",
        async: false,
        method: "POST",
        data: {
            "user_id": user_id,
            "type": type,
            "amount": amount,
            "reason": reason
        },
        dataType: "json",
        cache: false
    });

    request.done(function (response) {
        if (response.error == true) {
            BootstrapDialog.show({
                title: 'Notice',
                message: 'There are some errors in your input!'
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
            }, 1000 );
        }
    });

    request.fail(function (jqXHR, textStatus) {
        BootstrapDialog.show({
            title: 'Notice',
            message: 'There are some errors from server!'
        });
    });
}
