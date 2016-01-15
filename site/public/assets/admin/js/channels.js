(function ($, W, D) {


})(jQuery, window, document);

$(document).ready(function () {
    $('.btn_new_channel').on('click', function () {
        notie.confirm('Are you sure you want to do that?', 'Yes', 'Cancel', function () {
            window.location.href = url_oauth;
        });
    });
});
