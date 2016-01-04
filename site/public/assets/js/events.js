$(document).ready(function () {
    //Open REGISTER/LOGIN modal
    $(".joinus").click(function () {
        $("#joinus_modal").modal();
    });

    //Virtual Keyboard
    $.fn.numpad.defaults.gridTpl = '<table class="table modal-content"></table>';
    $.fn.numpad.defaults.backgroundTpl = '<div class="modal-backdrop in"></div>';
    $.fn.numpad.defaults.displayTpl = '<input type="text" class="form-control" />';
    $.fn.numpad.defaults.buttonNumberTpl = '<button type="button" class="btn btn-default"></button>';
    $.fn.numpad.defaults.buttonFunctionTpl = '<button type="button" class="btn" style="width: 100%;"></button>';
    $.fn.numpad.defaults.onKeypadCreate = function () {
        $(this).find('.done').addClass('btn-primary');
    };
    $('#user-pin_code').numpad({
        displayTpl: '<input class="form-control" type="password" />',
        hidePlusMinusButton: true,
        hideDecimalButton: true
    });
});

(function ($, W, D) {
    //Register
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function () {
            //form validation rules
            $("#register-form").validate({
                rules: {
                    "register[username]": {
                        required: true,
                        minlength: 5,
                        maxlength: 50
                    },
                    "register[pin_code]": {
                        required: true,
                        digits: true,
                        minlength: 6,
                        maxlength: 6
                    },
                    "register[first_name]": {
                        required: true,
                        minlength: 2,
                        maxlength: 50
                    },
                    "register[last_name]": {
                        required: true,
                        minlength: 2,
                        maxlength: 50
                    },
                    "register[email]": {
                        required: true,
                        email: true,
                        minlength: 5,
                        maxlength: 100
                    },
                    "register[password]": {
                        required: true,
                        minlength: 5,
                        maxlength: 50
                    },
                    "register[repeat_password]": {
                        equalTo: "#user-pw"
                    }
                },
                messages: {
                    "register[username]": {
                        required: "Please enter your Username",
                        minlength: "Your Username must be at least 5 characters long",
                        maxlength: "Your Username must not be over 50 characters long"
                    },
                    "register[pin_code]": {
                        required: "Please enter your Pin Code",
                        digits: "Please enter only digits",
                        minlength: "At least 6 characters long",
                        maxlength: "Not be over 6 characters long"
                    },
                    "register[first_name]": {
                        required: "Please enter your First Name",
                        minlength: "At least 2 characters long",
                        maxlength: "Not be over 50 characters long"
                    },
                    "register[last_name]": {
                        required: "Please enter your Last Name",
                        minlength: "At least 2 characters long",
                        maxlength: "Not be over 50 characters long"
                    },
                    "register[email]": {
                        required: "Please enter a valid email address",
                        minlength: "Your email must be at least 5 characters long",
                        maxlength: "Your email must not be over 100 characters long"
                    },
                    "register[password]": {
                        required: "Please provide a password",
                        minlength: "At least 5 characters long",
                        maxlength: "Not be over 50 characters long"
                    },
                    "register[repeat_password]": {
                        equalTo: "Passwords Do Not Match!"
                    }
                },
                submitHandler: function (form) {
                    $('.register').prop('disabled', true);
                    //Checking Email is exist
                    var request = $.ajax({
                        url: "/user/checking",
                        async: false,
                        method: "POST",
                        data: {
                            "register[email]": $('#user-email').val(),
                            "register[username]": $('#user-name').val(),
                            "register[from_refer]": $('#user-from_refer').val()
                        },
                        dataType: "json",
                        cache: false
                    });

                    request.done(function (response) {
                        if (response.message != '') {
                            $('.common_message').html(response.message);
                            $('.register').prop('disabled', false);
                            return;
                        } else if (response.message == '') {
                            $('.common_message').html();
                            form.submit();
                        }
                    });

                    request.fail(function (jqXHR, textStatus) {
                        $('.common_message').html(response.message);
                        $('.register').prop('disabled', false);
                    });


                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function ($) {
        JQUERY4U.UTIL.setupFormValidation();
    });





    //LOGIN
    var JQUERY4ULOGIN = {};

    JQUERY4ULOGIN.UTIL =
    {
        setupFormValidation: function () {
            //form validation rules
            $("#login-form").validate({
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
                    $('.login').prop('disabled', true);
                    //Checking Email is exist
                    var request = $.ajax({
                        url: "/user/checking/login",
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
                            $('.common_message_login').html(response.message);
                            $('.login').prop('disabled', false);
                            return;
                        } else if (response.message == '') {
                            $('.common_message_login').html();
                            form.submit();
                        }
                    });

                    request.fail(function (jqXHR, textStatus) {
                        $('.common_message_login').html(response.message);
                        $('.login').prop('disabled', false);
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


