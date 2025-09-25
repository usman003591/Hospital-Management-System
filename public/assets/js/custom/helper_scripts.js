$(document).ready(function(){
    BASE_URL = $("meta[name='base-url']").attr("content");
    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $("meta[name='_token']").attr("content")
        }
    });

    $(document).on('click', '.dismiss-modal', function(){
       $('#' + $(this).data('target')).modal('hide');
    });


});


function trim(string, mask) {
    while (~mask.indexOf(string[0])) {
        string = string.slice(1);
    }
    while (~mask.indexOf(string[string.length - 1])) {
        string = string.slice(0, -1);
    }
    return string;
}

function show_message(type, message, messageType = 'single') {
    var showMessage = '';

    if (messageType == 'list') {
        var error = message;
        var array = $.map(error, function(value, index) {  return [value]; });

        for (var i = 0; i < array.length; i++)
            showMessage += array[i] + '\n<br>';

    } else {
        showMessage = message;
    }

    switch (type) {
        case 'success' :
            Swal.fire({ html: showMessage , icon: "success", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn btn-primary" } });
            break;
        case 'error' :
            Swal.fire({ html: showMessage , icon: "error", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn btn-primary" } });
            break;
    }
}

