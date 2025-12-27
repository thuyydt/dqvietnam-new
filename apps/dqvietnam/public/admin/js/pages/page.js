$(function () {
    //load lang
    // load_lang('page');
    //load slug
    init_slug('title', 'slug');
    //load table ajax
    init_data_table();
    //bind checkbox table
    init_checkbox_table();

    tinymce.init(optionTinyMCE);

});

function add_form() {
    slug_disable = false;
    save_method = 'add';
    $('#modal_form').trigger("reset");
    $('#modal_form').modal('show');
    $('.modal-title').text('Thêm trang tĩnh');
}

function edit_form(id) {
    slug_disable = true;
    save_method = 'update';
    $.ajax({
        url: url_ajax_edit + "/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            LOAD.autoFill(data);
            $('#modal_form').modal('show');
            $('.modal-title').text('Sửa trang tĩnh');
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}

function save() {
    $('#btnSave').text(language['btn_saving']); //change button text
    $('#btnSave').attr('disabled', true); //set button disable
    var url;

    if (save_method === 'add') {
        url = url_ajax_add;
    } else {
        url = url_ajax_update;
    }

    for (var j = 0; j < tinyMCE.editors.length; j++) {
        var content = tinymce.get(tinyMCE.editors[j].id).getContent();
        $('#' + tinyMCE.editors[j].id).val(content);
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
                    $('[name="' + i + '"]').closest('.form-group').append(val);
                })
            } else {
                $('#modal_form').modal('hide');
                reload_table();
            }
            $('#btnSave').text(language['btn_save']);
            $('#btnSave').attr('disabled', false);
        }, error: function (jqXHR, textStatus, errorThrown) {
            $('#btnSave').text(language['btn_save']);
            $('#btnSave').attr('disabled', false);
        }
    });
}

