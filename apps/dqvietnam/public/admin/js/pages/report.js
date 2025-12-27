$(function () {

    init_data_table();
    init_parameters_report();
    init_percent_of_levels();
});

function init_parameters_report() {
    $.ajax({
        url: url_ajax_parameters_report,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            // console.log(data);return false;
            $.each(data, function (key, value) {
                $('#' + key).html(value);
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $(".modal-body").prepend(box_alert('alert-danger', language['error_try_again']));
        }
    });
}

function init_percent_of_levels() {
    $.ajax({
        url: url_ajax_percent_of_levels,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            Object.keys(data).map((e, i) => {
                $(`#percent_${e} .info-box-number`).html( data[e].total );
                $(`#percent_${e} .progress-bar`).css('width', data[e].percent + '%');
                $(`#percent_${e} .progress-description .percent`).html(data[e].percent + '%');
            })
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $(".modal-body").prepend(box_alert('alert-danger', language['error_try_again']));
        }
    });
}