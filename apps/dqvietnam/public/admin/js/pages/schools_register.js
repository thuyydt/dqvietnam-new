
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

                if (tinymce.get(index)) {
                    tinymce.get(index).setContent(value);
                }
            });
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