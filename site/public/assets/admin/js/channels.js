$(document).ready(function () {
    //Initial Selected Multiple
    createSelected('#filter_user_id');
    //createSelected('#filter_channel_id');
    createSelected('#filter_status');

    //Channel List
    //check uncheck ALL
    $("#checkAll").click(function () {
        //$('input:checkbox').not(this).prop('checked', this.checked);
        //$('input:checkbox').find('span').addClass('checked');
        if ($(this).data("status") == 'uncheck') {
            //change to CHECK
            $(this).data("status", 'check');
            $(this).html('Uncheck');
            $('.check_child').parent().addClass('checked');
            $('.check_child').prop('checked', true);
        } else {
            //change to UNCHECK
            $(this).html('Check');
            $(this).data("status", 'uncheck');
            $('.check_child').parent().removeClass('checked');
            $('.check_child').prop('checked', false);
        }
    });

    //Decline multi
    $('.btn_decline_multi').click(function () {
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
                    $('#channel-change_multi-form').submit();
                }
            }
        });
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

function changeStatus(that) {
    var status = $(that).data('status');
    var change_id = $(that).data('change-id');
    var action = $(that).data('action');
    if (action == true) {
        var pr = '0';
        if (status == 1) {
            pr = prompt('Enter month/year for approved date. Format: YYYY-mm-dd', date);
            if (!isDate(pr)) {
                alert('Date format is invalid or incorrect. Example: ' + date);
                return false;
            }
        }
        window.location.href = '/adminntw/channels/status/' + change_id + '/' + status + '/' + pr;
    }
    return false;
}

function decline(that) {
    var channel_id = $(that).data('channel-id');
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
                window.location.href = '/adminntw/channels/remove/' + channel_id;
            }
        }
    });


    return false;
}


function isDate(txtDate) {
    var currVal = txtDate;
    if (currVal == '')
        return false;

    //Declare Regex
    var rxDatePattern = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/;
    var dtArray = currVal.match(rxDatePattern); // is format OK?

    if (dtArray == null)
        return false;

    //Checks for yyyy-mm-ddd format.
    dtDay = dtArray[5];
    dtMonth = dtArray[3];
    dtYear = dtArray[1];

    if (dtMonth < 1 || dtMonth > 12)
        return false;
    else if (dtDay < 1 || dtDay > 31)
        return false;
    else if ((dtMonth == 4 || dtMonth == 6 || dtMonth == 9 || dtMonth == 11) && dtDay == 31)
        return false;
    else if (dtMonth == 2) {
        var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
        if (dtDay > 29 || (dtDay == 29 && !isleap))
            return false;
    }
    return true;
}