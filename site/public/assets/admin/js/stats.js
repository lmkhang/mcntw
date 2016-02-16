$(document).ready(function () {
    //Initial Selected Multiple
    createSelected('#filter_user_id');
    createSelected('#filter_type');
    createSelected('#filter_status');
    createSelected('#filter_is_payment');

    //Datetime picker
    $('#filter_month').datetimepicker({
        viewMode: 'years',
        format: 'MM/YYYY',
        icons: {
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        }
    });
});

function createSelected(id) {
    $(id).multiselect({
        maxHeight: 400,
        inheritClass: true,
        buttonContainer: '<div class="btn-group" />',
        buttonWidth: '250px',
        disableIfEmpty: true,
        nonSelectedText: 'All!'
    });
}
