function normal_reset() {
    $('#q').val('');
    $("#parent_id").val(' ').trigger("change");
    $("#verification_status").val(2).trigger("change"); // Renamed ID
    updateResults();
}

function updateResults() {
    const url = new URL(window.location);

    // Match param keys to backend expectations
    var filterArray = {
        "q": '',
        "parent_id": '',
        "verification_status": ''
    };

    // Populate filterArray from DOM
    $.each(filterArray, function(index, value) {
        filterArray[index] = $('#' + index).val();
    });

    // Build query string and clean params
    $.each(filterArray, function(index, value) {
        if (index === '0') {
        if (value === " ") {
            value = '';
        } else if (value === "0") {
            url.searchParams.set(index, '0');
            return; // skip default logic
        }
    }
        if (index === 'verification_status' && value == 2) value = '';
        if (value === '') {
            delete filterArray[index];
            url.searchParams.delete(index);
        } else {
            url.searchParams.set(index, value);
        }
    });

    // Make AJAX call
    $.ajax({
        url: url.href,
        type: "get",
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            console.log(data);
            if (data.status === 200) {
                var loadedData = data.data;
                $('#ajax_result').html(loadedData);
                KTMenu.createInstances();
                window.history.pushState({}, '', url);
            }
            if (data.status === 400) {
                let list = Object.values(data.message).map(e => `${e} <br>`).join('');
                Swal.fire("Error!", list, "error");
                KTMenu.createInstances();
            }
            if (data.status === 409) {
                Swal.fire("Error!", data.message, "error");
                KTMenu.createInstances();
            }
        },
        error: function(data) {
            console.log('Error:', data.responseText);
            Swal.fire("Error!", data.responseText, "error");
            KTMenu.createInstances();
        }
    });

    window.history.pushState({}, '', url);
}

$(document).ready(function() {
    var ajax_change = true;

    normal_reset();

    $('.ajax_call_trigger').change(function() {
        if (ajax_change) updateResults();
    });

    $('#advance_search, #normal_search').click(function() {
        updateResults();
    });

    $('#advance_reset').click(function() {
        ajax_change = false;
        advance_reset();
        ajax_change = true;
    });

    $('#normal_reset').click(function() {
        ajax_change = false;
        normal_reset();
        ajax_change = true;
    });
});
