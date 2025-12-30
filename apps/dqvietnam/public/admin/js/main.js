var csrfToken = $('meta[name="csrf-token"]');
var csrfName = csrfToken.attr('data-name');
var csrfValue = csrfToken.attr('content');
// $.ajaxSetup({
//   beforeSend: function (jqXHR, Obj) {
//     if (typeof Obj.data != 'undefined') {
//       console.log(Obj);
//       if(Obj.data.indexOf(csrfName) === -1) Obj.data += '&' + csrfName + '=' + csrfValue;
//     }
//   }
// });

function generatePwd(input) {
    const pwd = Math.random().toString(36).slice(-8);
    $(input).val(pwd);
}

$(document).ajaxSend(function (elm, xhr, s) {
    if (s.data != 'undefined') {
        s.data += '&';
    }
    s.data += csrfName + '=' + csrfValue;
});
//file js dinh nghia ham dung chung
var save_method = '',
    slug_disable = false,
    table = '',
    arrId = [],
    qCount = 0,
    limit = 10,
    i = 1,
    dataFilter = {};
var optionTinyMCE = {
    height: "250",
    selector: "textarea.tinymce",
    setup: function (ed) {
        ed.on('DblClick', function (e) {
            if (e.target.nodeName == 'IMG') {
                tinyMCE.activeEditor.execCommand('mceImage');
            }
        });
    },
    plugins: [
        "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker template",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "table contextmenu directionality emoticons template textcolor paste textcolor colorpicker textpattern moxiemanager link image",
    ],

    toolbar1: "newdocument | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect template",
    toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
    toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft insertfile link image",

    templates: [
        {
            title: 'Textbox',
            description: 'Tạo Textbox',
            url: base_url + 'public/admin/plugins/tinymce/templates/text-box.html'
        }
    ],

    menubar: false,
    element_format: 'html',
    extended_valid_elements: "iframe[src|width|height|name|align], embed[width|height|name|flashvars|src|bgcolor|align|play|loop|quality|allowscriptaccess|type|pluginspage]",
    toolbar_items_size: 'small',
    relative_urls: false,
    remove_script_host: false,
    convert_urls: false,
    verify_html: false,
    style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ],

    external_plugins: {
        "moxiemanager": base_url + "/public/admin/plugins/moxiemanager/plugin.min.js"
    }
};

var optionTinyMCEMore = {
    height: "150",
    selector: "textarea.tinymce-more",
    setup: function (ed) {
        ed.on('DblClick', function (e) {
            if (e.target.nodeName == 'IMG') {
                tinyMCE.activeEditor.execCommand('mceImage');
            }
        });
    },
    plugins: [
        "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
        "  visualblocks visualchars code fullscreen  nonbreaking",
        "table contextmenu directionality emoticons textcolor paste textcolor textpattern link code",
    ],

    toolbar1: "newdocument | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | code styleselect formatselect fontselect fontsizeselect cut copy paste  | bullist numlist | outdent indent blockquote  | table | hr removeformat | subscript superscript | charmap emoticons |  fullscreen | ltr rtl | spellchecker | link",
    toolbar2: false,
    menubar: false,
    branding: false,
    statusbar: false,
    element_format: 'html',
    extended_valid_elements: "iframe[src|width|height|name|align], embed[width|height|name|flashvars|src|align|play|loop|quality|allowscriptaccess|type|pluginspage]",
    toolbar_items_size: 'small',
    relative_urls: false,
    remove_script_host: false,
    convert_urls: true,
    verify_html: false,
    external_plugins: {
        "moxiemanager": base_url + "/public/admin/plugins/moxiemanager/plugin.min.js"
    }
};
var url_ = document.URL;
var menuElement = $('a[href="' + url_ + '"]');
// SEO Style
var colors = ["#f44336", "#fbc02d", "#4caf50"];
var cgg = $(".gg").text().split("").join("</span><span>");
$(".gg").html(cgg);
var cgg = $(".gg_1").text().split("").join("</span><span>");
$(".gg_1").html(cgg);
$(function () {
    'use strict';
    menuElement.parent().addClass('active');
    menuElement.parent().parent().show();
    menuElement.parent().parent().parent().addClass('menu-open');
    $(document).ajaxStart(function () {
        Pace.restart();
    });
    //load lang
    load_lang('general');
    $('.number').keyup(function () {
        var phone = $(this).val().replace(/[^0-9]/g, '');
        $(this).val(phone);
    });
    $('.select2').select2({
        allowClear: true,
        placeholder: 'Select an item',
    });

    $('.fancybox').fancybox({
        'overlayOpacity': 0.6,
        'autoScale': false,
        'type': 'iframe'
    });
    $('#datepicker').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true,
        // endDate: "+1 days"
    });

    $('[data-toggle="tooltip"]').tooltip();

    $('.datetimepicker').datetimepicker({
        format: "dd-mm-yyyy hh:ii:ss",
        autoclose: true,
    });
    $('.bootstrapswitch').bootstrapSwitch();
    //$("input.tagsinput").tagsinput();

    loadFilterCategory();
    // loadFilterTag();

    //Update Status
    $(document).on('click', ".btnUpdateStatus", function () {
        let status = $(this).data('value');
        let statusValue = 0;
        switch (status) {
            case 1:
                statusValue = 0; //Bỏ nháp nên để value về 0
                break;
            case 2:
                statusValue = 0;
                break;
            default:
                statusValue = 1;
        }
        updateField($(this).closest('tr').find('[name="id[]"]').val(), 'status', statusValue);
    });

    //Update Status không có nháp
    $(document).on('click', ".btnUpdateStatusnotdarf", function () {
        let status = $(this).data('value');
        let statusValue = 0;
        switch (status) {
            case 1:
                statusValue = 0;
                break;
            default:
                statusValue = 1;
        }
        updateField($(this).closest('tr').find('[name="id[]"]').val(), 'is_status', statusValue);
    });
    //Update Status

    //Update Featured
    $(document).on('click', ".btnUpdateFeatured", function () {
        let value = $(this).data('value');
        let language_code = $('.filter_language_code').val();
        let updateValue = 0;
        switch (value) {
            case 1:
                updateValue = 0;
                break;
            default:
                updateValue = 1;
        }
        updateField($(this).closest('tr').find('[name="id[]"]').val(), 'is_featured', updateValue, language_code);
        return false;
    });
    $(document).on('change', '.update_single_field', function () {
        let _this = $(this);

        let id = _this.attr('data-id');
        let field = _this.attr('name');
        let value = _this.val();
        updateField(id, field, value);
    })


    //Update Featured

    //Event modal
    var modalCms = $('.modal');
    modalCms.modal({backdrop: 'static', keyboard: false, show: false});
    //Event close modal
    modalCms.on('hidden.bs.modal', function (e) {
        window.onbeforeunload = null;
        $(this).find('form').not('input[name=' + csrfName + ']').trigger('reset');
        $(this).find('input[type=hidden]').not('input[name=' + csrfName + ']').val(0);
        $(this).find('input[type=checkbox]').attr('checked', false);
        $('.form-group span.text-danger').remove();
        $("#form .select2").empty().trigger('change');
        $('.alert').remove();
        $('.help-block').empty();

        SEO.reload();
    });

    //Event open modal
    modalCms.on('shown.bs.modal', function (e) {

        initSEO();//Plugin SEO
        btnFly();

        $('form').on('change', 'input[name="view_mode"]', function () {
            view_mode($(this).val());
        });


    });

    $("input[data-type='currency']").on({
        keyup: function () {
            formatCurrency($(this));
        },
        keypress: function () {
            formatCurrency($(this));
        },
        change: function () {
            formatCurrency($(this));
        },
        paste: function () {
            formatCurrency($(this));
        },
        blur: function () {
            formatCurrency($(this));
        }
    });

    $('#data-table').on('change', '.change_order', function () {
        if ($(this).val() < 0) {
            toastr['warning']('Giá trị không đươc nhỏ hơn 0');
            reload_table();
        } else {
            updateField($(this).attr('data-id'), 'order', $(this).val());
        }
    });

    $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true,
        todayHighlight: true,
    });
    $('.item_filter_list').change(function () {
        var form_data = $('#form_filter').serializeArray();
        var filter = {};
        $.each(form_data, function (index, val) {
            if (val.value != '' && val.value != 0) {
                filter[val.name] = val.value;
            }
        });
        filterDatatables(filter);

    })
    init_checkbox_table();

});

// Chế độ xem
function view_mode(val) {
    if (typeof val == 'undefined') val = $('[name="view_mode"]:checked').val();
    if (val == 2) {
        $('.private_view input').attr('disabled', false);
        $('.private_view').show();
    } else {
        $('#normal_user').attr('checked', true);
        $('.private_view input').attr('disabled', true);
        $('.private_view').hide();
    }
}

// Jquery Dependency
function formatNumber(n) {
    // format number 1000000 to 1,234,567
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}


function formatCurrency(input, blur) {
    // appends $ to value, validates decimal side
    // and puts cursor back in right position.

    // get input value
    var input_val = input.val();

    // don't validate empty input
    if (input_val === "") {
        return;
    }

    // original length
    var original_len = input_val.length;

    // initial caret position
    var caret_pos = input.prop("selectionStart");

    // check for decimal
    if (input_val.indexOf(".") >= 0) {

        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumber(left_side);

        // validate right side
        right_side = formatNumber(right_side);


        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);

        // join number by .
        input_val = "$" + left_side + "." + right_side;

    } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumber(input_val);
        input_val = input_val;

    }

    // send updated string to input
    input.val(input_val);

    // put caret back in the right position
    var updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
}

function checkImageSrc() {
    var image = $('src');
    image.onload = function () {
        cnsole.log(image);
        if (image.length == 0) {
            image.attr('src', base_url + 'img/no-photo.webp'); // replace with other image
        }
    };
    image.onerror = function () {
        alert('error image');
        image.attr('src', base_url + 'img/no-photo.webp'); // replace with other image
    };
}

function loadImageThumb(url, name) {

    if (typeof name === 'undefined' || name === '') {
        name = 'thumbnail';
    }
    var imageThumbnail = $('[name="' + name + '"]');
    // imageThumbnail.attr('src', media_url + url);
    if (url == '' || url == null) {
        var link = 'https://placehold.co/400x200';
    } else {
        var link = media_url + url;
    }
    imageThumbnail.parent().find('a').attr('href', link);
    imageThumbnail.parent().find('img').attr('src', link);


}

function loadFile(url, name) {
    if (url != '') {
        if (typeof name === 'undefined' || name === '') {
            name = 'file';
        }

        var imageThumbnail = $('[name="' + name + '"]');
    }

}


function loadMultipleMedia(data) {
    if (data !== null && (data).length > 0) {
        $.each(JSON.parse(data), function (i, v) {
            $('#gallery').append(itemGallery(i + 1, v));
        });
    }
}

function loadMultipleMediaByName(name, element, data) {
    if (data !== null && (data).length > 0) {
        data = $.isArray(data) ? data : JSON.parse(data);
        $.each(data, function (i, v) {
            $('#' + element).append(itemGallery_by_name(name, i + 1, v));
        });
    }
}


//Chọn ảnh
function chooseImage(idElement, callback) {
    moxman.browse({
        view: 'thumbs',
        fields: idElement,
        // extensions: 'jpg,jpeg,png,ico, gif',
        no_host: true,
        oninsert: function (args) {
            let url = args.focusedFile.url;
            let urlImageResponse = url.replace(script_name + media_name, '');
            let image = args.focusedFile.url;
            if (callback) {
                callback(image, idElement);
                return;
            }
            $('#' + idElement).val(urlImageResponse).parent().find('img').attr('src', image);
        }
    });

}//Chọn file
function chooseFile(idElement) {
    moxman.browse({
        view: 'thumbs',
        fields: idElement,
        extensions: 'jpg,jpeg,png,docx,doc,pdf,xls,xlsx,mp3,mp4',
        no_host: true,
        oninsert: function (args) {
            let url = args.focusedFile.url;
            let urlImageResponse = url.replace(script_name + media_name, '');
            let image = args.focusedFile.thumbnailUrl;
            $('#' + idElement).val(urlImageResponse);
        }
    });
}

// chọn file
function chooseFiless(idElement) {
    moxman.browse({
        path: '/media/files',
        view: 'thumbs',
        fields: idElement,
        extensions: 'jpg,jpeg,png,docx,doc,pdf,xls,xlsx,mp3,mp4',
        no_host: true,
        oninsert: function (args) {
            let url = args.focusedFile.url;
            let urlImageResponse = url.replace(script_name + media_name, '');
            let image = args.focusedFile.thumbnailUrl;
            $('#' + idElement).val(urlImageResponse);
            $('#demo_' + idElement).attr('src', image);
        }
    });
}

//Chọn video
function chooseVideo(idElement) {
    moxman.browse({
        view: 'thumbs',
        fields: idElement,
        extensions: 'mp4, mov',
        oninsert: function (args) {
            let url = args.focusedFile.meta.thumb_url;
            $('#' + idElement).val(url);
        }
    });
}

//Chọn script
function chooseScript(idElement) {
    moxman.browse({
        view: 'thumbs',
        fields: idElement,
        extensions: 'json',
        oninsert: function (args) {
            let url = args.focusedFile.meta.thumb_url;
            $('#' + idElement).val(url);
        }
    });
}

function chooseMultipleMedia(idElement) {
    var count = parseInt($('#' + idElement).attr('data-id'));
    moxman.browse({
        view: 'thumbs',
        multiple: true,
        extensions: 'jpg,jpeg,gif,png,ico,pdf,doc,docx,xls,xlsx',
        no_host: true,
        oninsert: function (args) {
            // $('#gallery').html('');
            $.each(args['files'], function (i, value) {
                count = count + 1;
                var url = value.url;
                var urlImageResponse = url.replace(script_name + media_name, '');
                var html = itemGallery(count, urlImageResponse);
                $('#' + idElement).append(html);
            });
            $('#' + idElement).attr('data-id', $('#' + idElement + ' .item_gallery:last').data('count'));
        }
    });
}

function chooseMultipleMediaName(idElement, name) {
    var count = parseInt($('#' + idElement).attr('data-id'));
    moxman.browse({
        view: 'thumbs',
        multiple: true,
        extensions: 'JPG,PNG,JPEG,jpg,jpeg,gif,png,ico,pdf,doc,docx,xls,xlsx',
        no_host: true,
        upload_auto_close: true,
        oninsert: function (args) {
            $.each(args['files'], function (i, value) {
                count = count + 1;
                var url = value.url;
                var urlImageResponse = url.replace(script_name + media_name, '');
                var html = itemGallery_by_name(name, count, urlImageResponse);
                $('#' + idElement).append(html);
            });
            $('#' + idElement).attr('data-id', $('#' + idElement + ' .item_gallery:last').data('count'));
        }
    });
}

function chooseFiles(idElement) {

    moxman.browse({
        path: '/media/files',
        view: 'thumbs',
        extensions: 'pdf',
        no_host: true,
        oninsert: function (args) {
            var url = args.focusedFile.url;
            var urlImageResponse = url.replace(script_name + media_name, '');
            $('#' + idElement).val(urlImageResponse);
        }
    });
}

function chooseMultipleFiles(idElement) {

    moxman.browse({
        path: '/media/brochure',
        view: 'thumbs',
        multiple: true,
        extensions: 'jpg,jpeg,gif,png,ico,pdf,doc,docx,xls,xlsx',
        no_host: true,
        oninsert: function (args) {
            let arrImage = [];
            $.each(args.files, function (i, val) {
                arrImage[i] = "brochure/" + val.name;
            });
            $('#' + idElement).val(JSON.stringify(arrImage))
        }
    });
}

// add item gallery
function itemGallery(count, urlImageResponse) {
    return html = "<div class='item_gallery item_" + count + "' data-count='" + count + "'>" +
        "<img src='" + media_url + "/" + urlImageResponse + "' id='item_" + count + "' height='120'>" +
        "<input type='hidden' name='album[]' value='" + urlImageResponse + "' >" +
        "<span class='fa fa-times removeInput' onclick='removeInputImage(this)'></span></div>";
}

// add item gallery
function itemGallery_by_name(name, count, urlImageResponse) {
    if ($('[name="' + name + '"][value="' + urlImageResponse + '"]').length == 0) {
        return html = "<div class='item_gallery item_" + count + "' data-count='" + count + "'>" +
            "<a href='" + media_url + "/" + urlImageResponse + "' data-fancybox='gallery'>" +
            "<img src='" + media_url + "/" + urlImageResponse + "' id='item_" + count + "' height='120'>" +
            "</a>" +
            "<input type='hidden' name='" + name + "' value='" + urlImageResponse + "' value='\" + urlImageResponse + \"'  >" +
            "<span class='fa fa-times removeInput' onclick='removeInputImage(this)'></span></div>";
    }
}

function addInputImage(idElement, i, value) {
    var element = $('#' + idElement);
    i = parseInt(i);
    i += 1;
    $.ajax({
        type: "POST",
        url: base_url + "admin/setting/ajax_load_item_album",
        data: {i: i, item: value},
        dataType: "html",
        success: function (inputImage) {
            element.append(inputImage);
            element.attr('data-id', i + 1);
            $('.fancybox').fancybox();
        }
    });
}

function removeInputImage(_this) {
    $(_this).parent().remove();
}

function load_lang(name) {
    var s = document.createElement("script");
    s.type = "text/javascript";
    s.src = base_url + "lang/load/" + name;
    $("head").append(s);
}

function box_alert(className, content) {
    $('#error-box').remove();
    var html = ' <div class="alert ' + className + ' alert-dismissible" id="error-box">';
    html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
    html += '<h4><i class="icon fa fa-ban"></i> Thông báo</h4>'
    html += content;
    html += '</div>';
    return html;
}

function create_slug(title, ele) {
    if (slug_disable) {
        return;
    }
    slug = title.toLowerCase();
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    //slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    slug = slug.replace(/[^a-zA-Z0-9 ]/g, "");
    slug = slug.replace(/ /gi, "-");
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    $(ele).val(slug);
    $(".gg-url").html(base_url + slug);
}

function init_slug(listen, target) {
    $('#' + listen).on('paste', function (e) {
        setTimeout(function () {
            create_slug($('#' + listen).val(), '#' + target);
            if (!slug_disable) {
                $('#meta_title').val($('#' + listen).val());
                checkSEOTitle($('#meta_title'));
            }
        }, 500);
    });
    //su kien keyup
    $('#' + listen).on('keyup', function (e) {
        create_slug($('#' + listen).val(), '#' + target);
        if (!slug_disable) {
            $('#meta_title').val($('#' + listen).val());
            checkSEOTitle($('#meta_title'));
        }
    });
}

function remove_checked_table() {
    $('#data-table-select-all').attr('checked', false);
    $('.chk_id').attr('checked', false);
}

function CopyHTMLToClipboard(_this) {
    $(_this).focus();
    $(_this).select();
}


//init datatable
function init_data_table(limit, order) {
    if (typeof order == 'undefined') order = 1;
    if (typeof limit == 'undefined' || limit == '') limit = 10;
    //load table ajax
    var element = $('#data-table');
    table = element.DataTable({
        'ajax': {
            type: "POST",
            url: url_ajax_list,
            data: function (d) {
                return $.extend({}, d, dataFilter);
            }
        },
        fixedHeader: true,
        'bProcessing': true,
        'serverSide': true,
        'dom': 'Bfrtip',
        'buttons': [],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Vietnamese.json"
        },
        'columnDefs': [
            {
                'targets': 'no-sort',
                "orderable": false,
                'className': 'text-center'
            },
            {
                'targets': 0,
                'visible': element.hasClass("no_check_all") ? false : true,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center',
                'render': function (data, type, full, meta) {
                    return '<input type="checkbox" class="chk_id" name="id[]" value="' + $('<div/>').text(data).html() + '">';
                }
            },
            {
                'targets': -1,
                'searchable': false,
                'orderable': false
            }
        ],
        'order': [[order, 'desc']],
        "fnDrawCallback": function () {
            $("a.fancybox").fancybox();
        }
    });
}

//init datatable
function init_data_table_not_paging(limit, order) {
    if (typeof order == 'undefined') order = 1;
    if (typeof limit == 'undefined' || limit == '') limit = 10;
    //load table ajax
    var element = $('#data-table');
    table = element.DataTable({
        'ajax': {
            type: "POST",
            url: url_ajax_list,
            data: function (d) {
                return $.extend({}, d, dataFilter);
            }
        },
        fixedHeader: true,
        'bProcessing': true,
        'serverSide': true,
        'dom': 'Bfrtip',
        'buttons': [],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Vietnamese.json"
        },
        'columnDefs': [
            {
                'targets': 'no-sort',
                "orderable": false,
                'className': 'text-center'
            },
            {
                'targets': 0,
                'visible': element.hasClass("no_check_all") ? false : true,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center',
                'render': function (data, type, full, meta) {
                    return '<input type="checkbox" class="chk_id" name="id[]" value="' + $('<div/>').text(data).html() + '">';
                }
            },
            {
                'targets': -1,
                'searchable': false,
                'orderable': false
            }
        ],
        'order': [[order, 'desc']],
        "fnDrawCallback": function () {
            $("a.fancybox").fancybox();
        }
    });
}

function init_data_table_not_pagi(limit, order) {
    if (typeof order == 'undefined') order = 1;
    if (typeof limit == 'undefined' || limit == '') limit = 10;
    //load table ajax
    var element = $('#data-table');
    table = element.DataTable({
        'ajax': {
            type: "POST",
            url: url_ajax_list,
            data: function (d) {
                return $.extend({}, d, dataFilter);
            }
        },
        fixedHeader: true,
        'bProcessing': true,
        "bInfo": false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
        "paging": false,//Dont want paging
        "bPaginate": false,//Dont want paging
        'serverSide': true,
        'dom': 'Bfrtip',
        'buttons': [],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Vietnamese.json"
        },
        'columnDefs': [
            {
                'targets': 'no-sort',
                "orderable": false,
                'className': 'text-center'
            },
            {
                'targets': 0,
                'visible': element.hasClass("no_check_all") ? false : true,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center',
                'render': function (data, type, full, meta) {
                    return '<input type="checkbox" class="chk_id" name="id[]" value="' + $('<div/>').text(data).html() + '">';
                }
            },
            {
                'targets': -1,
                'searchable': false,
                'orderable': false
            }
        ],
    });
}

function init_data_table_default(width = {}) {
    var element = $('#data-table');
    element.submit(function (e) {
        e.preventDefault();
    })
    table = element.DataTable({
        'ajax': {
            type: "POST",
            url: url_ajax_list,
            data: function (d) {
                d[csrfName] = csrfValue;
                return $.extend({}, d, dataFilter);
            }
        },
        fixedHeader: true,
        'dom': 'Bfrtip',
        // 'serverSide': true,
        'buttons': [],
        'columnDefs': [
            {
                'targets': 'no-sort',
                "orderable": false,
                'className': 'text-center'
            },
            {
                'targets': 0,
                'visible': element.hasClass("no_check_all") ? false : true,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center',
                'render': function (data, type, full, meta) {
                    return '<input type="checkbox" class="chk_id" name="id[]" value="' + $('<div/>').text(data).html() + '">';
                }
            },
            {
                'targets': -1,
                'searchable': false,
                'orderable': false
            }
        ],
        "columns": [
            null,
            null,
            {"orderDataType": "dom-text-numeric"},
            null,
            null,
            null,
        ],
        "search": {
            "regex": false
        },
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Vietnamese.json"
        },
        "fnDrawCallback": function () {
            $("a.fancybox").fancybox();
            $('.dataTables_filter input')
                .off()
                .on('keyup', function () {
                    let value = this.value;
                    table.search(value.trim(), false, false).draw();
                });
        }
    });

    /* Create an array with the values of all the input boxes in a column, parsed as numbers */
    $.fn.dataTable.ext.order['dom-text'] = function (settings, col) {
        return this.api().column(col, {order: 'index'}).nodes().map(function (td, i) {
            return $('input', td).val();
        });
    }
    /* Create an array with the values of all the input boxes in a column, parsed as numbers */
    $.fn.dataTable.ext.order['dom-text-numeric'] = function (settings, col) {
        return this.api().column(col, {order: 'index'}).nodes().map(function (td, i) {
            return $('input', td).val() * 1;
        });
    }

}

function updateSortDatatables() {
    $.extend(
        $.fn.dataTable.RowReorder.defaults,
        {dataSrc: 2, selector: 'td:not(:first-child, :last-child, :nth-child(5), :nth-child(6))'}
    );
    $.fn.dataTable.defaults.rowReorder = true;
    table.on('row-reorder', function (e, diff, edit) {
        var ien = diff.length;
        if (ien >= 2) {
            var rowData1 = table.row(diff[ien - 1].node).data();
            var rowData2 = table.row(diff[ien - 2].node).data();
            updateField(rowData1[1], 'order', rowData2[2]);
            updateField(rowData2[1], 'order', rowData1[2]);
        }
    });
}

function updateField(id, field, value, language_code = "") {
    $.ajax({
        type: "POST",
        url: url_ajax_update_field,
        data: {id: id, field: field, language_code: language_code, value: value},
        dataType: "JSON",
        success: function (response) {
            toastr[response.type](response.message);
            reload_table();
        }
    });
}

function filterDatatables(data) {
    dataFilter = data;
    // reload_table();
    table.page(0).draw(false);
}

function init_checkbox_table() {
    // checkbox check all
    $('#data-table-select-all').on('click', function () {

        var rows = table.rows({'search': 'applied'}).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    $('#data-table tbody').on('change', 'input[type="checkbox"]', function () {
        if (!this.checked) {
            var el = $('#data-table-select-all').get(0);
            if (el && el.checked && ('indeterminate' in el)) {
                el.indeterminate = true;
            }
        }
    });
}

//reload table
function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
}

//xoa mot ban ghi
function delete_item(id) {
    swal({
        title: language['mess_alert_title'],
        text: language['mess_confirm_delete'],
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: language['btn_yes'],
        cancelButtonText: language['btn_no'],
        closeOnConfirm: false
    }, function () {
        $.ajax({
            url: url_ajax_delete + "/" + id,
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

//xoa nhieu ban ghi
function delete_multiple() {
    var tmpArr = $('.chk_id:checkbox:checked').map(function () {
        return this.value;
    }).get();
    if (tmpArr.length > 0) {
        swal({
            title: language['mess_alert_title'],
            text: language['mess_confirm_delete'],
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: language['btn_yes'],
            cancelButtonText: language['btn_no'],
            closeOnConfirm: false
        }, function () {

            arrId = tmpArr;
            delete_queue(0);

        });
        $('#data-table-select-all').prop('checked', false);
    } else {
        toastr['warning']('Vui lòng chọn thông tin cần xóa');
    }
}

//queue xoa tu ban ghi tuan tu
function delete_queue(index) {
    $.ajax({
        url: url_ajax_delete + "/" + arrId[index],
        type: "POST",
        dataType: "JSON",
        data: {csrfName: csrfValue},
        success: function (data) {
            index++;
            if (index >= arrId.length) {
                arrId = [];
                remove_checked_table();
                swal.close();
                reload_table();
                toastr[data.type](data.message);
            } else {
                delete_queue(index);
            }
        }
    });
}

//sao chép nhieu ban ghi
function copy_multiple() {
    swal({
        title: language['mess_alert_title'],
        text: language['mess_confirm_copy'],
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-primary",
        confirmButtonText: language['btn_yes'],
        cancelButtonText: language['btn_no'],
        closeOnConfirm: false
    }, function () {
        var tmpArr = $('.chk_id:checkbox:checked').map(function () {
            return this.value;
        }).get();
        if (tmpArr.length > 0) {
            arrId = tmpArr;
            copy_queue(0);
        }
    });
}

//queue sao chep tu ban ghi tuan tu
function copy_queue(index) {
    $.ajax({
        url: url_ajax_copy + "/" + arrId[index],
        type: "POST",
        dataType: "JSON",
        success: function (data) {
            if (data.type) {
                toastr[data.type](data.message);
            }
            index++;
            if (index >= arrId.length) {
                arrId = [];
                remove_checked_table();
                swal.close();
                reload_table();
            } else {
                copy_queue(index);
            }
        }
    });
}

//format 001
function pad(number, length) {

    var str = '' + number;
    while (str.length < length) {
        str = '0' + str;
    }

    return str;

}

function loadTinyMce() {
    tinymce.init(optionTinyMCE)
};

function initSEO() {
    //  For title
    $("input[name^='meta_title']").keyup(function () {
        checkSEOTitle($(this));
    });
    //  For slug
    $("input[name^='slug']").keyup(function () {
        $(".gg-url").html(base_url + $(this).val());
    });
    //  For Focus Keywords
    $(".bootstrap-tagsinput input").keyup(function () {
        checkSEOKeyword($(this));
    });
    //  For Decriptions
    $("textarea[name^='meta_description']").keyup(function () {
        checkSEODesc($(this));
    });
    /*//Default check
    var text_ti = "Lorem Ipsum is simply dummy text of the printing happyy";
    var text_fk = "Focus Keyword";
    var text_ur = "http://example.com/your-title-url-<b>focus-keyword</b>-more-description";
    var text_de = "<b>Focus Keyword</b> with Lorem Ipsum is simply dummy text of the printing and typesetting industry. has been the industry's standard dummy text es verynice.";
    $(".gg-result").val(text_fk);
    $(".gg-title").html(text_ti);
    $(".gg-url").html(text_ur);
    $(".gg-desc").html(text_de);

    $("input[name^='meta_title'], .bootstrap-tagsinput input, textarea[name^='meta_title']").blur(function (){
        if($(this).val() == "" || $(this).val() == " "){
            $(".gg-result").val(text_fk);
            $(".gg-title").html(text_ti);
            $(".gg-url").html(text_ur);
            $(".gg-desc").html(text_de);
        }
    });*/

    //Check SEO
    $(".gg-url").html(base_url + $("input[name^='slug']").val());
    if ($("input[name^='meta_title']").length) checkSEOTitle("input[name^='meta_title']");
    if ($("input[name^='meta_description']").length) checkSEODesc("textarea[name^='meta_description']");
}

function checkSEOTitle(_this) {
    _this = $(_this);
    var c_title = _this.val().length;
    var l_title = $("span.count-title");
    $(l_title).html(c_title);
    if (c_title >= 40 && c_title <= 80) {
        _this.css({"color": colors[2], border: "3px solid" + colors[2]});
        $(l_title).css("color", colors[2])
    } else if (c_title >= 25 && c_title < 40) {
        _this.css({"color": colors[1], border: "3px solid" + colors[1]});
        $(l_title).css("color", colors[1])
    } else {
        _this.css({"color": colors[0], border: "3px solid" + colors[0]});
        $(l_title).css("color", colors[0])
    }
    var seo_title = _this.val();
    $(".gg-title").html(seo_title);
}

function checkSEODesc(_this) {
    _this = $(_this);
    var c_desc = _this.val().length;
    var l_desc = $(".count-desc");
    $(l_desc).html(c_desc);
    if (c_desc >= 120 && c_desc <= 150) {
        _this.css({"color": colors[2], border: "3px solid" + colors[2]});
        $(l_desc).css("color", colors[2])
    } else if (c_desc >= 90 && c_desc < 120) {
        _this.css({"color": colors[1], border: "3px solid" + colors[1]});
        $(l_desc).css("color", colors[1])
    } else {
        _this.css({"color": colors[0], border: "3px solid" + colors[0]});
        $(l_desc).css("color", colors[0])
    }
    var seo_desc = _this.val();
    $(".gg-desc").html(seo_desc);
}

function checkSEOKeyword(_this) {
    _this = $(_this);
    var c_key = _this.val().length;
    var l_key = $("span.count-key");
    $(l_key).html(c_key);
    if (c_key >= 10 && c_key <= 15) {
        _this.css({"color": colors[2], border: "3px solid" + colors[2]});
        $(l_key).css("color", colors[2])
    } else if (c_key >= 6 && c_key < 10) {
        _this.css({"color": colors[1], border: "3px solid" + colors[1]});
        $(l_key).css("color", colors[1])
    } else {
        _this.css({"color": colors[0], border: "3px solid" + colors[0]});
        $(l_key).css("color", colors[0])
    }
    var seo_key = _this.val();
    $(".gg-result").val(seo_key);
}

function analyticKeyword(_arrKey) {

}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function btnFly() {
    $("body").append('<style>.modal-footer-top-button{position:fixed;z-index:999999;top:0;right:0px;}</style>');
    var diaLogScroll = $('#modal_form'),
        diaLogScrollHeight = diaLogScroll.find('.modal-header').height(),
        diaLogScrollFooter = diaLogScroll.find('.modal-footer');
    diaLogScroll.find('.modal-footer').addClass('modal-footer-top-button');
    diaLogScroll.scroll(function () {
        if (diaLogScroll.scrollTop() <= diaLogScrollHeight + 35) {
            diaLogScrollFooter.addClass('modal-footer-top-button');
        } else {
            diaLogScrollFooter.removeClass('modal-footer-top-button');
        }
    });
}

function loadFilterCategory() {
    $("select.filter_category").select2({
        allowClear: true,
        placeholder: $('.filter_category').attr('data-place'),
        ajax: {
            url: url_ajax_load,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true,
        }
    });
    $("select.filter_category").on('change', function () {
        var id = $(this).val();
        var dataCategory = {
            parent_id: id,
            category_id: id,
            tag_id: $('.filter_tag').val(),
            filter_language_code: $('.filter_language_code').val()
        };
        filterDatatables(dataCategory);
    });
}

function loadFilterTag() {
    $("select.filter_tag").select2({
        allowClear: true,
        placeholder: $('.filter_tag').attr('data-place'),
        ajax: {
            url: url_ajax_load_tag,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true,
        }
    });

    $("select.filter_tag").on('change', function () {
        var id = $(this).val();
        var catId = $('.filter_category').val();
        var dataTag = {
            parent_id: catId,
            category_id: catId,
            tag_id: id,
            filter_language_code: $('.filter_language_code').val()
        };
        filterDatatables(dataTag);
    });

}


function getYouTubeID(url) {
    var ID = '';
    url = url.replace(/(>|<)/gi, '').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
    if (url[2] !== undefined) {
        ID = url[2].split(/[^0-9a-z_\-]/i);
        ID = ID[0];
    } else {
        ID = url;
    }
    return ID;
}

//format so 100,000,000
function number_format(number, decimals, dec_point, thousands_sep) {
    var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
    var d = dec_point == undefined ? "," : dec_point;
    var t = thousands_sep == undefined ? "." : thousands_sep, s = n < 0 ? "-" : "";
    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;

    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

//init lich date ranger
function initDateRanger() {
    var objDate = $('.date-ranger'),
        curYear = new Date().getFullYear();
    objDate.daterangepicker(
        {
            format: 'DD/MM/YYYY',
            ranges: {
                'Hôm nay': [moment(), moment()],
                'Hôm qua': [moment().subtract('days', 1), moment().subtract('days', 1)],
                'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                'Tháng trước': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')],
                'Qúy 1': [moment(curYear + '-01-01'), moment(curYear + '-03-01').endOf('month')],
                'Qúy 2': [moment(curYear + '-04-01'), moment(curYear + '-06-01').endOf('month')],
                'Qúy 3': [moment(curYear + '-07-01'), moment(curYear + '-09-01').endOf('month')],
                'Qúy 4': [moment(curYear + '-10-01'), moment(curYear + '-12-01').endOf('month')],
            },
            locale: {
                format: "DD/MM/YYYY",
                separator: " - ",
                applyLabel: "Áp dụng",
                cancelLabel: "Thoát",
                fromLabel: "Từ",
                toLabel: "Đến",
                customRangeLabel: "Tùy chỉnh",
                daysOfWeek: [
                    "CN",
                    "T2",
                    "T3",
                    "T4",
                    "T5",
                    "T6",
                    "T7"
                ],
                monthNames: [
                    "Tháng 1",
                    "Tháng 2",
                    "Tháng 3",
                    "Tháng 4",
                    "Tháng 5",
                    "Tháng 6",
                    "Tháng 7",
                    "Tháng 8",
                    "Tháng 9",
                    "Tháng 10",
                    "Tháng 11",
                    "Tháng 12"
                ],
                firstDay: 1
            }
        },
        function (start, end) {
            if (start.format('DD/MM/YYYY') == end.format('DD/MM/YYYY'))
                objDate.val(start.format('DD/MM/YYYY'));
            else
                objDate.val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
        }
    );
}

function getFormattedDate(date, element) {
    if (date != '' && date != '0000-00-00') {
        if (typeof element == 'undefined') element = $('.datepicker');
        else element = $('[name="' + element + '"]');
        element.datepicker("update", new Date(date));
        date = new Date(date);
        let year = date.getFullYear();
        let month = (1 + date.getMonth()).toString().padStart(2, '0');
        let day = date.getDate().toString().padStart(2, '0');
        return day + '/' + month + '/' + year;
    } else {
        return '';
    }
}

function getFormattedDateTime(date, element) {
    if (date != '' && date != '0000-00-00 00:00:00') {
        if (typeof element == 'undefined') element = $('.datetimepicker');
        else element = $('[name="' + element + '"]');
        let expl = date.split(' ');
        element.datepicker("update", new Date(expl[0]));
        date = new Date(date);
        let year = date.getFullYear();
        let month = (1 + date.getMonth()).toString().padStart(2, '0');
        let day = date.getDate().toString().padStart(2, '0');
        return day + '-' + month + '-' + year + ' ' + expl[1];
    } else {
        return '';
    }
}

function strip_tags(str, allowed_tags) {
    let key = '', allowed = false;
    let matches = [];
    let allowed_array = [];
    let allowed_tag = '';
    let i = 0;
    let k = '';
    let html = '';
    let replacer = function (search, replace, str) {
        return str.split(search).join(replace);
    };
    if (allowed_tags) {
        allowed_array = allowed_tags.match(/([a-zA-Z0-9]+)/gi);
    }
    str += '';
    matches = str.match(/(<\/?[\S][^>]*>)/gi);
    for (key in matches) {
        if (isNaN(key)) {
            continue;
        }
        html = matches[key].toString();
        allowed = false;

        for (k in allowed_array) {
            allowed_tag = allowed_array[k];
            i = -1;
            if (i != 0) {
                i = html.toLowerCase().indexOf('<' + allowed_tag + '>');
            }
            if (i != 0) {
                i = html.toLowerCase().indexOf('<' + allowed_tag + ' ');
            }
            if (i != 0) {
                i = html.toLowerCase().indexOf('</' + allowed_tag);
            }
            if (i == 0) {
                allowed = true;
                break;
            }
        }
        if (!allowed) {
            str = replacer(html, "", str);
        }
    }
    return str;
}

function number_format(number, decimals, dec_point, thousands_sep) {
    var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 0 : decimals;
    var d = dec_point == undefined ? "." : dec_point;
    var t = thousands_sep == undefined ? "," : thousands_sep, s = n < 0 ? "-" : "";
    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;

    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

function load_select2_ajax(options, dataSelected) {
    options.selector.select2({
        allowClear: true,
        placeholder: options.placeholder,
        multiple: options.multiple,
        data: dataSelected,
        ajax: {
            url: options.url,
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
    if (typeof dataSelected !== 'undefined') options.selector.find('> option').prop("selected", "selected").trigger("change");
}

function loadSelect() {
    $("select[name='is_status']").parent('.form-group').html(select);
}

const TINYMCE = {
    init: function () {
        tinymce.init(optionTinyMCE);
    },
    create_data: function () {
        for (let j = 0; j < tinyMCE.editors.length; j++) {
            let content = tinymce.get(tinyMCE.editors[j].id).getContent();
            $('#' + tinyMCE.editors[j].id).val(content);
        }
    },
    reset_data: function () {
        for (let j = 0; j < tinyMCE.editors.length; j++) {
            tinymce.get(tinyMCE.editors[j].id).setContent('');
        }
    }
};

const SELECT2 = {

    init: function () {
        $('.select2').select2({
            allowClear: true,
            minimumResultsForSearch: 1,
            placeholder: $(this).data("placeholder") || '',
        });

        $('.select2_not_search').select2({
            allowClear: true,
            minimumResultsForSearch: -1,
        });
    },

    load: function (options, data = '', lang = 'vn') {
        data = typeof data === 'object' ? data : {};
        Object.keys(options).map(function (key, index) {
            let dataSelected = typeof data[key] !== 'undefined' ? data[key] : '';
            SELECT2.call(options[key], dataSelected, lang);
        });
    },

    call: function (options, dataSelected, lang = 'vn') {

        options.selector.select2({
            allowClear: true,
            placeholder: options.placeholder || options.selector.data("placeholder"),
            multiple: options.multiple,
            data: dataSelected,
            minimumResultsForSearch: options.hideSearch ? -1 : 1,
            language: lang,
            ajax: {
                url: options.url,
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        }).on('select2:close', function (e) {
            // $(this).trigger('focus');
        })

        if (typeof dataSelected !== 'undefined') options.selector.find('> option').prop("selected", "selected").trigger("change");
    }

}


const SEO = {
    init: function () {
        this.check();
        this.style();
        init_slug('name', 'slug');
    },
    reload: function () {
        $("span.count-title").text(0);
        $("span.count-desc").text(0);
        $("span.count-key").text(0);
    },
    check: function () {
        //  For Title
        $("input[name^='meta_title']").keyup(function () {
            checkSEOTitle($(this));
        });
        //  For Slug
        $("input[name^='slug']").keyup(function () {
            $(".gg-url").html(base_url + $(this).val());
        });
        //  For Focus Keywords
        $(".bootstrap-tagsinput input").keyup(function () {
            checkSEOKeyword($(this));
        });
        //  For Decriptions
        $("textarea[name^='meta_description']").keyup(function () {
            checkSEODesc($(this));
        });

        //Check SEO
        $(".gg-url").html(base_url + $("input[name^='slug']").val());
        if ($("input[name^='meta_title']").length) checkSEOTitle("input[name^='meta_title']");
        if ($("input[name^='meta_description']").length) checkSEODesc("textarea[name^='meta_description']");
    },
    style: function () {
        let gg = $(".gg_1");
        var cgg = gg.text().split("").join("</span><span>");
        gg.html(cgg);
    }
};

function view_point_item(id) {
    $.ajax({
        url: url_ajax_view_detail + '/' + id,
        type: "POST",
        data: {id: id},
        dataType: "JSON",
        success: function (data) {
            $('#modal_view_detail').modal('show');

            $('#modal_view_detail #full_name').html(data.account.full_name || '');
            $('#modal_view_detail #username').html(data.account.username || '');

            $('#modal_view_detail #point-type-1').html(data.list[1] || 0);
            $('#modal_view_detail #point-type-2').html(data.list[2] || 0);
            $('#modal_view_detail #point-type-3').html(data.list[3] || 0);
            $('#modal_view_detail #point-type-4').html(data.list[4] || 0);
            $('#modal_view_detail #point-type-5').html(data.list[5] || 0);
            $('#modal_view_detail #point-type-6').html(data.list[6] || 0);
            $('#modal_view_detail #point-type-7').html(data.list[7] || 0);
            $('#modal_view_detail #point-type-8').html(data.list[8] || 0);

            $('#modal_view_detail #point-medium').html(data.medium || 0);

        },
        error: function (jqXHR, textStatus, errorThrown) {
            $(".modal-body").prepend(box_alert('alert-danger', language['error_try_again']));
        }
    });
}

