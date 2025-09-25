function normal_reset() {
    $('#q').val('');
    $("#hospital").val(0).trigger("change");

    updateResults();
}

function updateResults() {
    const url = new URL(window.location);
    var filterArray = {
        "q" : '',
        "hospital": '',
    };


    $.each(filterArray, function( index, value ) {
        filterArray[index] = $('#' + index ).val();
    });


    $.each(filterArray, function( index, value ) {
        filterArray[index] = trim(filterArray[index], ',');
    });

    $.each(filterArray, function( index, value) {

        if(index == 'hospital' && value == 0)
            value = '';

        if(index == 'parent' && value == 0)
            value = '';


        if(value == '')
            delete filterArray[index];
        value == ''
            ? url.searchParams.delete(index)
            : url.searchParams.set(index, value);
    });



    $.ajax({
        url: url.href,
        type: "get",
        dataType: 'json',
        cache:false,
        contentType: false,
        processData: false,
        success: function (data) {
            if(data.status === 200) {
                console.log(data);
                var loadedDate = data.data;
                $('#ajax_result').html(loadedDate);
                window.history.pushState({}, '', url);
            }
            if(data.status === 400) {
                var error = data.message
                var array = $.matasks-containerp(error, function(value, index) {  return [value]; });
                let list = '';
                for (var i = 0; i < array.length; i++)
                    list += array[i] + '\n <br>';
                Swal.fire("Error!",list, "error");

            }
            if(data.status === 409){
                var error = data.message
                Swal.fire("Error!", error, "error");
            }
        },
        error: function (data) {
            console.log(data);
            console.log('Error:', data.responseText);
            var error = data.responseText
            Swal.fire("Error!", error, "error");
        }
    });

    window.history.pushState({}, '', url);
}

$(document).ready(function() {

    var ajax_change = true;

    $('.ajax_call_trigger').change(function () {
        if (ajax_change)
            updateResults();
    });
    $('#advance_search').click(function () {
        updateResults();
    });
    $('#normal_search').click(function () {
        updateResults();
    });

    $('#advance_reset').click(function () {
        ajax_change = false;
        advance_reset();
        ajax_change = true;
    });
    $('#normal_reset').click(function () {
        ajax_change = false;
        normal_reset();
        ajax_change = true;
    });

});
