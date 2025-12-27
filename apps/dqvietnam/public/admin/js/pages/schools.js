
$(function () {
    init_data_table();
    init_checkbox_table();
    TINYMCE.init();
    $('select.is_status').on('change', function () {
        var val = this.value;
        filterDatatables({is_status: val});
    });
});

function add_form() {
    slug_disable = false;
    save_method = 'add';

    $('#modal_form').modal('show');
    $('#modal_form').trigger("reset");
    TINYMCE.reset_data();
    loadCity();

    $('.modal-title').text('Thêm trường học');
    $('[name="username"],[name="email"]').attr('disabled', false);
}

//form sua
function edit_form(id) {
    save_method = 'update';
    $('#title-form').text('Sửa trường học');
    $.ajax({
        url: url_ajax_edit + "/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            $('#modal_form').modal('show');
            $('#modal_form').trigger("reset");
            TINYMCE.reset_data();

            $.each(data, function (index, value) {
                let elements = $('#modal_form [name="' + index + '"]');
                elements.val(value);
            });

            if (data.city_id.length) {
                loadCity(data.city_id);
                loadDistrict(data.city_id[0].id, data.district_id);
                loadWard(data.district_id[0].id, data.ward_id);
            } else {
                loadCity();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $(".modal-body").prepend(box_alert('alert-danger', language['error_try_again']));
        }
    });
}

//ajax luu form
function save() {
    $('#btnSave').text(language['btn_saving']); //change button text
    $('#btnSave').attr('disabled', true); //set button disable
    var url;

    if (save_method === 'add') {
        url = url_ajax_add;
    } else {
        url = url_ajax_update;
    }

    TINYMCE.create_data();

    // ajax adding data to database
    $.ajax({
        url: url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function (data) {
            toastr[data.type](data.message);
            if (data.type === "warning") {
                $('span.text-danger').remove();
                $.each(data.validation, function (i, val) {
                    $('form [name="' + i + '"]').parent().append(val);
                })
            } else {
                $('#modal_form').modal('hide');
                reload_table();
            }
            $('#btnSave').text(language['btn_save']); //change button text
            $('#btnSave').attr('disabled', false); //set button enable
            $('#token').val(data.token);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#btnSave').text(language['btn_save']); //change button text
            $('#btnSave').attr('disabled', false); //set button enable
        }
    });
}

function loadCity(dataSelected) {
    let selector = $('select[name="city_id"]');
    if (selector.length > 0) {
        selector.select2({
            allowClear: true,
            placeholder: "Chọn tỉnh/thành phố",
            data: dataSelected,
            ajax: {
                url: url_ajax_city,
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
        if (typeof dataSelected !== 'undefined') selector.find('> option').prop("selected", "selected").trigger("change");
        selector.change(function () {
            loadDistrict($(this).val());
        });

    }
}

function loadDistrict(city_id, dataSelected) {
    let selector = $('select[name="district_id"]');
    if (selector.length > 0) {
        selector.select2({
            allowClear: true,
            placeholder: "Chọn quận huyện",
            data: dataSelected,
            ajax: {
                type: "POST",
                url: url_ajax_district + '/' + city_id,
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
        if (typeof dataSelected !== 'undefined') selector.find('> option').prop("selected", "selected").trigger("change");

        selector.change(function () {
            loadWard($(this).val());
        });
    }
}

function loadWard(district_id, dataSelected) {
    let selector = $('select[name="ward_id"]');
    if (selector.length > 0) {
        selector.select2({
            allowClear: true,
            placeholder: "Chọn phường xã",
            data: dataSelected,
            ajax: {
                type: "POST",
                url: url_ajax_ward + '/' + district_id,
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
        selector.find('option').prop("selected", "selected").trigger("change");
    }
}