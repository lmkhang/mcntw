(function ($, W, D) {
    //Save profile
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function () {
            //form validation rules
            $("#profile-change-form").validate({
                rules: {
                    "profile[first_name]": {
                        required: true,
                        minlength: 2,
                        maxlength: 50
                    },
                    "profile[last_name]": {
                        required: true,
                        minlength: 2,
                        maxlength: 50
                    },
                    "profile[country]": {
                        required: true
                    }
                },
                messages: {
                    "profile[first_name]": {
                        required: "Please enter your First Name",
                        minlength: "At least 2 characters long",
                        maxlength: "Not be over 50 characters long"
                    },
                    "profile[last_name]": {
                        required: "Please enter your Last Name",
                        minlength: "At least 2 characters long",
                        maxlength: "Not be over 50 characters long"
                    },
                    "profile[country]": {
                        required: "Please choose your country"
                    }
                },
                submitHandler: function (form) {
                    $('.btn_save').prop('disabled', true);
                    form.submit();
                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function ($) {
        JQUERY4U.UTIL.setupFormValidation();
    });


    //Change password
    var JQUERY4UPWD = {};

    JQUERY4UPWD.UTIL =
    {
        setupFormValidation: function () {
            //form validation rules
            $("#profile-change-password-form").validate({
                rules: {
                    "profile[password]": {
                        required: true,
                        minlength: 5,
                        maxlength: 50
                    },
                    "profile[confirm_password]": {
                        equalTo: "#profile-password"
                    }
                },
                messages: {
                    "profile[password]": {
                        required: "Please provide a password",
                        minlength: "At least 5 characters long",
                        maxlength: "Not be over 50 characters long"
                    },
                    "profile[confirm_password]": {
                        equalTo: "Passwords Do Not Match!"
                    }
                },
                submitHandler: function (form) {
                    $('.btn_change_password').prop('disabled', true);
                    form.submit();
                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function ($) {
        JQUERY4UPWD.UTIL.setupFormValidation();
    });
})(jQuery, window, document);


