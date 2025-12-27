
options_select2_filter = {
    filter_school: {
        selector: $('select[name="filter_school"]'),
        placeholder: 'Chọn trường học',
        multiple: false,
        hide_search: false,
        url: url_ajax_load_schools
    }
}

options_select2 = {
    schools_id: {
        selector: $('select[name="schools_id"]'),
        placeholder: 'Chọn trường học',
        multiple: false,
        hide_search: false,
        url: url_ajax_load_schools
    }
}

$(function () {

    init_data_table();
    init_checkbox_table();
    $('select.is_status').on('change', function () {
        var school = $('select[name="filter_school"]').val()
        var val = $(this).val();
        filterDatatables({
            is_status: val,
            filter_school: school
        });
    });

    $('select[name="filter_school"]').on('change', function () {
        var status = $('select.is_status').val();
        var val = $(this).val();
        filterDatatables({
            is_status: status,
            filter_school: val
        });
    });

    SELECT2.load(options_select2_filter);
});

function add_form() {
    slug_disable = false;
    save_method = 'add';
    SELECT2.load(options_select2);
    $('#modal_form').modal('show');
    $('#modal_form').trigger("reset");
    $('.modal-title').text('Thêm thành viên');
    $('[name="username"],[name="email"]').attr('disabled', false);
}

//form sua
function edit_form(id) {
    save_method = 'update';
    $('#title-form').text('Sửa thành viên');
    $.ajax({
        url: url_ajax_edit + "/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            SELECT2.load(options_select2, data);
            $.each(data, function (key, value) {
                if (key == 'gender') {
                    $('[name="' + key + '"][value="' + value + '"]').prop('checked', true);
                } else {
                    if (key == 'birthday') value = getFormattedDate(value);
                    $('[name="' + key + '"]').val(value);
                }

            });
            // loadImageThumb(data.data.photo,'photo');
            $('[name="username"]').val(data.username).attr('readonly', true);
            $('[name="email"]').val(data.email).attr('readonly', true);
            $('#modal_form select[name="active"] > option[value="' + data.active + '"]').prop("selected", true);
            $('#modal_form').modal('show');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            $(".modal-body").prepend(box_alert('alert-danger', language['error_try_again']));
        }
    });
}

//ajax luu form
function save() {
    $('#btnSave').text(language['btn_saving']); //change button text
    $('#btnSave').attr('disabled', true); //set button disable
    var url;

    if (save_method == 'add') {
        url = url_ajax_add;
    } else {
        url = url_ajax_update;
    }

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
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            $('#btnSave').text(language['btn_save']); //change button text
            $('#btnSave').attr('disabled', false); //set button enable
        }
    });
}

function reset_account(id) {

    swal({
        title: 'Cài lại tài khoán',
        text: 'Việc này sẽ xoá hết mọi dữ liệu về điểm số, và lịch sử chơi của tài khoản!',
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: language['btn_yes'],
        cancelButtonText: language['btn_no'],
        closeOnConfirm: false
    }, function () {
        $.ajax({
            url: url_ajax_reset_account + "/" + id,
            type: "POST",
            dataType: "JSON",
            data: {csrfName: csrfValue},
            success: function (data) {
                if (data.type) {
                    toastr[data.type](data.message);
                }
                swal.close();
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus);
                console.log(jqXHR);
            }
        });
    });
}

function update_payment(id, val) {
    $.ajax({
        url: url_ajax_update_payment + "/" + id,
        type: "POST",
        dataType: "JSON",
        data: {
            value: val,
            csrfName: csrfValue
        },
        success: function (data) {
            if (data.type) {
                toastr[data.type](data.message);
            }
            reload_table();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(textStatus);
            console.log(jqXHR);
        }
    });
}

