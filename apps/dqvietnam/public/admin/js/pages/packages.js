
$(function () {
    init_data_table();
    init_checkbox_table();
    $('select.is_status').on('change', function () {
        var val = this.value;
        filterDatatables({is_status: val});
    });
    TINYMCE.init();

    PRICE.init('#price_new');
    PRICE.init('#price_old');
});

function add_form() {
    slug_disable = false;
    save_method = 'add';
    $('#modal_form').modal('show');
    $('#modal_form').trigger("reset");
    TINYMCE.reset_data();
    PRICE.fill('#price_new');
    PRICE.fill('#price_old');
    $('.modal-title').text('Thêm khoá học');
    $('[name="username"],[name="email"]').attr('disabled', false);
}

//form sua
function edit_form(id) {
    save_method = 'update';
    $('#title-form').text('Sửa khoá học');
    $.ajax({
        url: url_ajax_edit + "/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            $('#modal_form').modal('show');
            TINYMCE.reset_data();
            $('#modal_form').trigger("reset");

            $.each(data, function (index, value) {
                let elements = $('#modal_form [name="' + index + '"]');
                elements.val(value);

                if (tinymce.get(index)) {
                    tinymce.get(index).setContent(value);
                }

                if (index == 'is_contact' && value == 1) {
                    $('#modal_form [name="' + index + '"]').prop("checked", true);
                }
            });
            PRICE.fill('#price_old');
            PRICE.fill('#price_new');
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

const PRICE = {
    init: function (block = '') {
        PRICE.input(block);
        PRICE.fill(block);
    },
    fill: function (block = '') {
        let price = $(`${block} input.price`).val();
        price = new Intl.NumberFormat('vi', {
            style: 'currency',
            currency: 'VND'
        }).format(price);

        $(`${block} .price_demo`).html(price)
    },
    input: function (block = '') {
        $(`${block} input.price`).on("input", function () {
            PRICE.fill(block);
        });
    }
}