(function ($, W, D) {
    //LOGIN
    var JQUERY4ULOGIN = {};

    JQUERY4ULOGIN.UTIL =
    {
        setupFormValidation: function () {
            //form validation rules
            $("#login-admin-form").validate({
                rules: {
                    "login[account]": {
                        required: true,
                        minlength: 5,
                        maxlength: 100
                    },
                    "login[password]": {
                        required: true,
                        minlength: 5,
                        maxlength: 50
                    }
                },
                messages: {
                    "login[account]": {
                        required: "Please enter your account name",
                        minlength: "Your account must be at least 5 characters long",
                        maxlength: "Your account must not be over 100 characters long"
                    },
                    "login[password]": {
                        required: "Please enter a password",
                        minlength: "At least 5 characters long",
                        maxlength: "Not be over 50 characters long"
                    }
                },
                submitHandler: function (form) {
                    $('.btn_login_admin').prop('disabled', true);
                    //Checking Email is exist
                    var request = $.ajax({
                        url: "/adminntw/checking/login",
                        async: false,
                        method: "POST",
                        data: {
                            "login[account]": $('#user-name-email').val(),
                            "login[password]": $('#user-password').val()
                        },
                        dataType: "json",
                        cache: false
                    });

                    request.done(function (response) {
                        if (response.message != '') {
                            $('.common_message').html(response.message);
                            $('.btn_login_admin').prop('disabled', false);
                            return;
                        } else if (response.message == '') {
                            $('.common_message').html();
                            form.submit();
                        }
                    });

                    request.fail(function (jqXHR, textStatus) {
                        $('.common_message').html(response.message);
                        $('.btn_login_admin').prop('disabled', false);
                    });


                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function ($) {
        JQUERY4ULOGIN.UTIL.setupFormValidation();
    });


})(jQuery, window, document);


