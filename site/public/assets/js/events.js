$(document).ready(function () {
    //Open REGISTER/LOGIN modal
    $(".joinus").click(function () {
        $("#joinus_modal").modal();
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
                    "register[first_name]": {
                        required: "Please enter your First Name",
                        minlength: "Your First Name must be at least 2 characters long",
                        maxlength: "Your First Name must not be over 50 characters long"
                    },
                    "register[last_name]": {
                        required: "Please enter your Last Name",
                        minlength: "Your Last Name must be at least 2 characters long",
                        maxlength: "Your Last Name must not be over 50 characters long"
                    },
                    "register[email]": {
                        required: "Please enter a valid email address",
                        minlength: "Your email must be at least 5 characters long",
                        maxlength: "Your email must not be over 100 characters long"
                    },
                    "register[password]": {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long",
                        maxlength: "Your password must not be over 50 characters long"
                    },
                    "register[repeat_password]": {
                        equalTo: "Passwords Do Not Match!"
                    }
                },
                submitHandler: function (form) {
                    $('.submit').prop('disabled', true);
                    //Checking Email is exist
                    var request = $.ajax({
                        url: "/user/checking",
                        async: false,
                        method: "POST",
                        data: {
                            "register[email]": $('#user-email').val(),
                            "register[from_refer]": $('#user-from_refer').val()
                        },
                        dataType: "json",
                        cache: false
                    });

                    request.done(function (response) {
                        if (response.message != '') {
                            $('.common_message').html(response.message);
                            $('.submit').prop('disabled', false);
                            return;
                        } else if (response.message == '') {
                            $('.common_message').html();
                            form.submit();
                        }
                    });

                    request.fail(function (jqXHR, textStatus) {
                        $('.common_message').html(response.message);
                        $('.submit').prop('disabled', false);
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