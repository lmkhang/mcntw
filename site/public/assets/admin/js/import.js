(function ($, W, D) {


})(jQuery, window, document);

$(document).ready(function () {
    //Initial Selected Multiple
    $('#channel_id').multiselect({
        includeSelectAllOption: true,
        maxHeight: 400,
        checkboxName: 'multiselect[]',
        inheritClass: true,
        buttonContainer: '<div class="btn-group" />',
        buttonWidth: '300px',
        numberDisplayed: 1,
        selectAllText: 'Check all!'
    });

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

    //Open csv file
    $('.btn_choose_csv').on('click', function () {
        $('#csv_file').click();
    });

    //get name of csv file
    $(":file").change(function () {
        $('.csv_file_name').html($(":file").val());
    });

    //import
    $('.btn_import_data').click(function () {
        notie.alert(4, 'Importing...', 999999);
        $('#stats-import-form').submit();
    });
});
