
options_select2 = {
    package_id: {
        selector: $('select[name="package_id"]'),
        placeholder: 'Chọn khoá học',
        multiple: false,
        hide_search: false,
        url: url_ajax_load_package
    },
    account_id: {
        selector: $('select[name="account_id"]'),
        placeholder: 'Chọn tài khoản',
        multiple: false,
        hide_search: false,
        url: url_ajax_load_account
    }
}

$(function () {
    init_data_table();
    init_checkbox_table();
    $('select.is_status').on('change', function () {
        var val = this.value;
        filterDatatables({is_status: val});
    });

    PRICE.init();

    $('select[name="account_id"]').on('change', function (e) {
        let account_id = $(this).val();
        $.ajax({
            url: url_ajax_load_schools + "/" + account_id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $('input[name="schools_name"]').val(data.name || '')
                $('input[name="school_id"]').val(data.id || '')
            }
        });
    });
});

function add_form() {
    slug_disable = false;
    save_method = 'add';
    SELECT2.load(options_select2);
    $('#modal_form').modal('show');
    $('#modal_form').trigger("reset");
    PRICE.fill();
    $('.modal-title').text('Thêm thanh toán');
    $('[name="username"],[name="email"]').attr('disabled', false);
}

//form sua
function edit_form(id) {
    save_method = 'update';
    $('#title-form').text('Sửa thanh toán');
    $.ajax({
        url: url_ajax_edit + "/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            SELECT2.load(options_select2, data);
            $('#modal_form').modal('show');
            $('#modal_form').trigger("reset");

            $.each(data, function (index, value) {
                let elements = $('#modal_form [name="' + index + '"]');
                elements.val(value);
            });
            PRICE.fill();
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

const PRICE = {
    init: function () {
        PRICE.input();
        PRICE.fill();
    },
    fill: function () {
        let price = $('input.price').val();
        price = new Intl.NumberFormat('vi', {
            style: 'currency',
            currency: 'VND'
        }).format(price);

        $('.price_demo').html(price)
    },
    input: function () {
        $('input.price').on("input", function () {
            PRICE.fill();
        });
    }
}