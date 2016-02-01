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

    //Css for select menu
    $('.selectpicker').selectpicker({
        style: 'btn-info',
        size: 8
    });
    $('.select_bank').selectpicker({
        style: 'btn-body',
        size: 4
    });

    //initial payment method
    showMethod();

    //choose payment method
    $('.payment_method').on('change', function () {
        showMethod();
    });

    //submitting payment
    $('.btn_send_payment').on('click', function () {
        /*notie.confirm('Are you sure you want to do that?', 'Yes', 'Cancel', function () {
         $('#payment-change-form').submit();
         });*/

        BootstrapDialog.confirm({
            title: 'WARNING',
            message: 'Are you sure you want to do that?',
            type: BootstrapDialog.TYPE_WARNING, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
            closable: true, // <-- Default value is false
            draggable: true, // <-- Default value is false
            btnCancelLabel: 'Cancel!', // <-- Default value is 'Cancel',
            btnOKLabel: 'Yes!', // <-- Default value is 'OK',
            btnOKClass: 'btn-warning', // <-- If you didn't specify it, dialog type will be used,
            callback: function (result) {
                // result will be true if button was click, while it will be false if users close the dialog directly.
                if (result) {
                    $('#payment-change-form').submit();
                }
            }
        });
    });

})(jQuery, window, document);

function showMethod() {
    if ($('.payment_method option:selected').val() == 1) {
        //Bank
        $('.bank_method').show();
        $('.paypal_method').hide();
    } else {
        //Paypal
        $('.bank_method').hide();
        $('.paypal_method').show();
    }
}

function copy_refer(refer) {
    BootstrapDialog.show({
        title: 'Notice',
        message: 'Your refer link: <input type="text" class="input_copy_refer form-control" value="' + refer + '" onclick="selectAll(this); return false;">'
    });
}

function selectAll(that) {
    //select all while clicking input
    $(that).select();
}