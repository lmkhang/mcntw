$(document).ready(function () {

});

function perform(that) {
    //$("#adjust_modal").modal();
    var user_id = $(that).data('user-id');
    var type = $('.type_' + user_id + ' option:selected').val();
    var amount = $('.amount_' + user_id).val();
    var reason = $('.reason_' + user_id).val();

    //send to Server
    var request = $.ajax({
        url: "/dashboard/checking/sign_contract",
        async: false,
        method: "POST",
        data: {
            "sign_contract[email]": $('#sign_contract-email').val()
        },
        dataType: "json",
        cache: false
    });

    request.done(function (response) {
        if (response.message != '') {
            $('.common_message').html(response.message);
            $('.btn_sign_contract').prop('disabled', false);
            return;
        } else if (response.message == '') {
            $('.common_message').html();
            form.submit();
        }
    });

    request.fail(function (jqXHR, textStatus) {
        $('.common_message').html(response.message);
        $('.btn_sign_contract').prop('disabled', false);
    });
}
