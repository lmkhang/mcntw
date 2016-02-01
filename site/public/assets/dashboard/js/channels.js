(function ($, W, D) {


})(jQuery, window, document);

$(document).ready(function () {
    $('.btn_new_channel').on('click', function () {
        /*notie.confirm('Are you sure you want to do that?', 'Yes', 'Cancel', function () {
         window.location.href = url_oauth;
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
                    window.location.href = url_oauth;
                }
            }
        });

    });
});
