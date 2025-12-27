options_select2 = {
    school_id: {
        selector: $('select[name="school_id"]'),
        placeholder: 'Chọn trường học',
        multiple: false,
        hide_search: false,
        url: url_ajax_load_school
    },
}


$(function () {
    //load table ajax
    init_data_table();
    //bind checkbox table
    $('[name="username"]').keypress(function (e) {
        var txt = String.fromCharCode(e.which);
        if (!txt.match(/[^&\/\\#,+()^!`$~%'":*?<>{} àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]/g, '_')) {
            return false;
        }
    });

    $('[name="group_id"]').on("input", function () {
        if ($(this).val() == 2) {
            $('#choice_school').show();
        } else {
            $('#choice_school').hide();
        }
    });
});

function togglePwd(input) {
    const type = $(input).attr('type');
    if (type === 'text') {
        $(input).attr('type', 'password');
        $(input).find('i').attr('class', 'fa fa-eye-slash')
    } else {
        $(input).attr('type', 'text');
        $(input).find('i').attr('class', 'fa fa-eye')
    }
}

//form them moi
function add_form() {
    save_method = 'add';
    $('#title-form').text('Thêm tài khoản');
    $('[name="username"]').removeAttr('disabled');
    $('[name="email"]').removeAttr('disabled');
    $('.help-component').empty();
    SELECT2.load(options_select2);
    $('select[name="group_id"]').trigger('input');
    $('#modal_form').modal('show');
    $('#modal_form').trigger("reset");
}

//form sua
function edit_form(id) {
    save_method = 'update';
    $('.help-component').empty();

    //Ajax Load data from ajax
    $.ajax({
        url: url_ajax_edit + "/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            SELECT2.load(options_select2, data);
            $('[name="id"]').val(data.id);
            $('[name="username"]').val(data.username).attr('readonly', true);
            $('[name="email"]').val(data.email).attr('readonly', true);
            $('[name="full_name"]').val(data.full_name);
            $('[name="company"]').val(data.company);
            $('[name="phone"]').val(data.phone);
            $('select[name="group_id"]').val(data.group_id).trigger('input');
            $('select[name="active"]').val(data.active);
            $('[name="active"]').val(data.active);
            $('#modal_form').modal('show');
            $('.modal-title').text('Sửa tài khoản');

        },
        error: function (jqXHR, textStatus, errorThrown) {
            toastr['error'](language['error_try_again']);
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
            if (data.type != "success") {
                $('span.text-danger').remove();
                $.each(data.validation, function (i, val) {
                    $('[name="' + i + '"]').after(val);
                })
            } else {
                $('#modal_form').modal('hide');
                $('.text-danger').empty();
                reload_table();
            }
            $('#btnSave').text(language['btn_save']); //change button text
            $('#btnSave').attr('disabled', false); //set button enable
            $('#token').val(data.token);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            toastr['error'](language['error_try_again']);
            $('#btnSave').text(language['btn_save']); //change button text
            $('#btnSave').attr('disabled', false); //set button enable
        }
    });
}
