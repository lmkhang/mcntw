(function ($, W, D) {
    //Register
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function () {
            //form validation rules
            $("#sign-contract-form").validate({
                rules: {
                    "sign_contract[email]": {
                        required: true,
                        email: true,
                        minlength: 5,
                        maxlength: 100
                    },
                    "sign_contract[agree]": {
                        required: true
                    }
                },
                messages: {
                    "sign_contract[email]": {
                        required: "Please enter your email",
                        email: "Please enter format of email",
                        minlength: "Your email must be at least 5 characters long",
                        maxlength: "Your email must not be over 100 characters long"
                    },
                    "sign_contract[agree]": {
                        required: "Please see and check 'I agree with the Terms and Conditions'"
                    }
                },
                submitHandler: function (form) {
                    $('.btn_sign_contract').prop('disabled', true);
                    //Checking Email is exist
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
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function ($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);


