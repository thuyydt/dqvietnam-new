$(function () {
    init_data_table();
    init_checkbox_table();
    $('select.is_status').on('change', function () {
        var val = this.value;
        filterDatatables({is_status: val});
    });


    $("#list-item").sortable({
        containment: "parent",
        items: "> div",
        handle: ".move",
        tolerance: "pointer",
        cursor: "grabbing",
        opacity: 0.7,
        revert: 300,
        delay: 150,
        dropOnEmpty: true,
        start: function (e, ui) {
            ui.placeholder.height(ui.helper.outerHeight());
        },
        update: function (event, ui) {
            let order = $("#list-item").sortable("toArray");
            let data = [];
            order.reverse().map((e, i) => {
                let key = e.split('item_').at(1);
                data.push(DATA.tasks[key]);
            });
            DATA.tasks = data;
            TASKS.fill();
        }
    });
    $("#list-item, .item").disableSelection();

    TASKS.init();
    CHAT.init();

});

function add_form() {
    $('.modal-title').text('Thêm nhiệm vụ');
    slug_disable = false;
    save_method = 'add';
    $.ajax({
        url: url_ajax_get_title,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            $('#modal_form [name="name"]').val('Nhiệm vụ ' + data.key);
            $('#modal_form [name="key"]').val(data.key);
            $('#modal_form').modal('show');
            $('#modal_form').trigger("reset");
            TASKS.reset();
            $('[name="username"],[name="email"]').attr('disabled', false);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $(".modal-body").prepend(box_alert('alert-danger', language['error_try_again']));
        }
    });
}

//form sua
function edit_form(id) {

    save_method = 'update';
    $('#title-form').text('Sửa nhiệm vụ');
    $.ajax({
        url: url_ajax_edit + "/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (data) {

            TASKS.reset();
            DATA.tasks = JSON.parse(data.tasks_detail);
            TASKS.fill();

            $('#modal_form').modal('show');
            $('#modal_form').trigger("reset");

            $.each(data, function (index, value) {
                let elements = $('#modal_form [name="' + index + '"]');
                elements.val(value);
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

    if (save_method == 'add') {
        url = url_ajax_add;
    } else {
        url = url_ajax_update;
    }

    let data = {};

    $('#form').serializeArray().map((e, i) => {
        data[e.name] = e.value;
    });

    data.order = $("#list-item").sortable("toArray");
    data.tasks = JSON.stringify(DATA.tasks);

    // ajax adding data to database
    $.ajax({
        url: url,
        type: "POST",
        data: data,
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

const DATA = {
    tasks: {},
    answers: {},
    chars: {}
}

const TASKS = {
    key: 0,

    key_current: '',

    data_images: {
        point: 0,
        type: "images"
    },

    data_card: {
        point: 0,
        type: "card"
    },

    init: function () {
        TASKS.add();
        TASKS.remove();
        TASKS.click();
        TASKS.save();
        ANSWERS.init();
        CHARS.init();

    },

    reset: function () {
        TASKS.key = 0;
        TASKS.key_current = '';
        DATA.tasks = {};
        $('#list-item').html("");
        $('#fill-task').html("");
        ANSWERS.reset();
    },

    add: function () {
        $('#tasks .btn-add-new').on("click", function () {
            ANSWERS.reset();
            let type = $('#type_content').val();
            var data = {};
            switch (type) {
                case 'slide':
                    data = SLIDE.data;
                    break;
                case 'question':
                    data = QUESTION.data;
                    data.answers = {};
                    break;
                case 'crossword':
                    data = CROSSWORD.data;
                    break;
                case 'images':
                    data = IMAGES.data;
                    break;
                case 'card':
                    data = CARD.data;
                    break;
                case 'chat':
                    data = CHAT.data;
                    break;
                default:
                    data = FILL.data;
                    data.chars = {};
            }

            TASKS.key_current = TASKS.key;
            DATA.tasks[TASKS.key] = data;

            TASKS.fill();

            $(document).find('#tasks #list-item .item.active').trigger('click')
        });
    },

    save: function () {

        $('#save-data-task').on("click", function () {

            let key = TASKS.key_current;

            let type = $(document).find('#fill-task .task-input').data('type');

            switch (type) {
                case 'slide':
                    SLIDE.save(type, key);
                    break;
                case 'question':
                    QUESTION.save(type, key);
                    break;
                case 'crossword':
                    CROSSWORD.save(type, key)
                    break;
                case 'images':
                    IMAGES.save(type, key)
                    break;
                case 'card':
                    CARD.save(type, key)
                    break;
                case 'chat':
                    CHAT.save(type, key)
                    break;
                default:
                    FILL.save(type, key);
            }

            TASKS.fill();
        });
    },

    remove: function () {
        $(document).on("click", "#tasks .item .remove-item", function () {
            let key = $(this).closest('.item').data('key');
            delete DATA.tasks[key];
            $(this).closest('.item').remove();
        });
    },

    click: function () {
        $(document).on("click", "#tasks #list-item .item", function (event) {
            let type = $(this).data('type');

            if (event.target.classList['value'] === 'glyphicon glyphicon-trash' || event.target.classList['value'] === 'remove-item') {
                //Remove Item
            } else {
                $(document).find('#tasks #list-item .item').removeClass('active');
                $(this).addClass('active');

                TASKS.key_current = $(this).data('key');

                let data = DATA.tasks[TASKS.key_current];
                let fillTask = $('#fill-task');

                switch (type) {
                    case 'slide':
                        SLIDE.click(fillTask, data);
                        break;
                    case 'question':
                        QUESTION.click(fillTask, data)
                        break;
                    case 'crossword':
                        CROSSWORD.click(fillTask, data);
                        break;
                    case 'images':
                        IMAGES.click(fillTask, data);
                        break;
                    case 'card':
                        CARD.click(fillTask, data);
                        break;
                    case 'chat':
                        CHAT.click(fillTask, data);
                        break;
                    default:
                        FILL.click(fillTask, data);
                }
            }
        });
    },

    fill: function () {
        var data = DATA.tasks;
        var key_data = 0;
        $('#list-item').html("");

        Object.keys(data).map(function (key, index) {
            key_data = key;
            var title = 'Slide';
            if (data[key].type !== 'slide') {
                title = data[key].title || 'Chưa có tiêu đề';
            }

            let active = key == TASKS.key_current ? 1 : 0;

            $('#list-item').prepend(TASKS.tag_item(title, data[key].type, key, active));
        });
        TASKS.key = parseInt(key_data) + 1;
    },

    tag_item: (title, type, key, active = 0) => {
        var label_type = '';
        switch (type) {
            case 'slide':
                label_type = 'Slide';
                break;
            case 'question':
                label_type = 'Câu hỏi - Chọn đáp án đúng';
                break;
            case 'crossword':
                label_type = 'Trò chơi - Tìm từ';
                break;
            case 'images':
                label_type = 'Trò chơi - Tìm hình ảnh';
                break;
            case 'card':
                label_type = 'Trò chơi - Thẻ bài';
                break;
            case 'chat':
                label_type = 'Trò chuyện';
                break;
            default:
                label_type = 'Câu hỏi - Điền vào chỗ trống';
                break;
        }
        return `<div id="item_${key}" class="item ${active ? 'active' : ''}" data-type="${type}" data-key="${key}">
                    <div class="move"><i class="glyphicon glyphicon-sort"></i></div>
                    <span>${label_type}</span>
                    <p>${title || 'Chưa có tiêu đề'}</p>
                    <input type="hidden">
                    <button type="button" class="remove-item"><i class="glyphicon glyphicon-trash"></i></button>
                </div>`;
    },
}

const SLIDE = {
    data: {
        type: "slide",
        image: "",
        point: 0,
        is_firework: 0,
        type_point: 1,
    },

    save: (type, key) => {
        var data_save = {type: type};

        let is_firework = $(document).find('#task_is_firework:checked').val() || 0;

        data_save.image = $(document).find('#task_thumbnail').val();
        data_save.is_firework = parseInt(is_firework);
        data_save.point = $(document).find('#task_point').val();
        data_save.type_point = $(document).find('#task_type_point').val();

        DATA.tasks[key] = data_save;
    },

    click: (block, data) => {
        block.html(SLIDE.tag());

        $(document).find('#task_thumbnail').val(data.image);
        $(document).find('#demo_task_thumbnail').attr('src', media_url + data.image);
        $(document).find('#task_is_firework').prop('checked', data.is_firework);
        $(document).find('#task_point').val(data.point);
        $(document).find('#task_type_point').val(data.type_point);
    },

    tag: () => {
        return `<div class="form-group task-input" data-type="slide">
                    <div class="col-xs-12">
                        <div class="input-group input-group-lg">
                            <span class="input-group-addon" onclick="chooseFiless('task_thumbnail')"><i class="fa fa-fw fa-file"></i></span>
                            <input id="task_thumbnail" onclick="chooseFiless('task_thumbnail')" name="task_thumbnail" class="form-control" type="text" value=""/>
                        </div>
                        <img src="" alt="" id="demo_task_thumbnail">
                    </div>
                     <div class="col-xs-12">
                        <input id="task_is_firework" type="checkbox" value="1"/>
                        <label for="task_is_firework" style="margin-left: 5px">Bắn pháo hoa?</label>
                    </div>
                    <div class="col-xs-12">
                        <label>Điểm</label>
                        <input id="task_point" class="form-control" type="number" min="0"/>
                    </div>
                    <div class="col-xs-12">
                        <label for="task_type_point" style="margin-left: 5px">Cộng điểm cho kỹ năng ?</label>
                        <select name="task_type_point" class="form-control" id="task_type_point">
                            <option value="1">Quản lý thời gian tiếp xung màn hình</option>
                            <option value="2">Quản lý bắt nạt trên mạng</option>
                            <option value="3">Quản lý quyền riêng tư</option>
                            <option value="4">Danh tính công dân ký thuật số</option>
                            <option value="5">Quản lý an ninh mạng</option>
                            <option value="6">Quản lý dấu chân kỹ thuật số</option>
                            <option value="7">Tư duy phản biện</option>
                            <option value="8">Cảm thông kỹ thuật số</option>
                        </select>
                    </div>
                </div>`;
    },
}

const QUESTION = {
    data: {
        title: "",
        image: "",
        is_background: 0,
        is_chat: 0,
        answers: {},
        point: 0,
        type_point: 1,
        type: "question",
        layout: 1,
        hide_effect: 0,
        multi_answer: 0,
    },

    save: (type, key) => {
        var data_save = {type: type};

        let is_background = $(document).find('#task_is_background:checked').val() || 0;
        let is_chat = $(document).find('#task_is_chat:checked').val() || 0;
        let hide_effect = $(document).find('#hide_effect:checked').val() || '1';
        ANSWERS.save();

        data_save.image = $(document).find('#task_thumbnail').val();
        data_save.title = $(document).find('#task_name').val();
        data_save.type_point = $(document).find('#task_type_point').val();
        data_save.layout = $(document).find('#task_layout').val();
        data_save.multi_answer = $(document).find('#task_multi_answer').val();
        data_save.answers = DATA.answers;
        // data_save.point = point;
        data_save.is_background = parseInt(is_background);
        data_save.is_chat = parseInt(is_chat);
        data_save.hide_effect = hide_effect === '0';


        DATA.tasks[key] = data_save;
    },

    click: (block, data) => {
        block.html(QUESTION.tag());
        $(document).find('#task_thumbnail').val(data.image);
        $(document).find('#demo_task_thumbnail').attr('src', media_url + data.image);
        $(document).find('#task_name').val(data.title);
        $(document).find('#task_type_point').val(data.type_point);
        $(document).find('#task_layout').val(data.layout);
        $(document).find('#task_multi_answer').val(data.multi_answer);
        $(document).find('#task_is_background').prop('checked', data.is_background);
        $(document).find('#task_is_chat').prop('checked', data.is_chat);
        $(document).find('#hide_effect').prop('checked', data.hide_effect);

        DATA.answers = data.answers;

        ANSWERS.fill();
    },

    tag: () => {
        return `<div class="form-group task-input" data-type="question">
                    <div class="col-xs-12">
                        <label>Câu hỏi</label>
                        <input id="task_name" class="form-control" type="text"/>
                    </div>
                    <div class="col-xs-12">
                        <input id="task_is_chat" type="checkbox" value="1"/>
                        <label for="task_is_chat" style="margin-left: 5px">Là câu hỏi cho phần trò chuyện ?</label>
                    </div>
                    <div class="col-xs-12">
                        <input id="task_is_background" type="checkbox" value="1"/>
                        <label for="task_is_background" style="margin-left: 5px">Hình ảnh là ảnh nền ?</label>
                    </div>
                    <div class="col-xs-12">
                        <input id="hide_effect" name="hide_effect" type="checkbox" value="0" />
                        <label for="hide_effect" style="margin-left: 5px">Ẩn hiệu ứng/âm thanh ?</label>
                    </div>
                    <div class="col-xs-12">
                        <label for="task_layout" style="margin-left: 5px">Chọn nhiều đáp án ?</label>
                        <select name="task_layout" class="form-control" id="task_multi_answer">
                            <option value="0">Không</option>
                            <option value="1">Có</option>
                        </select>
                    </div>
                    <div class="col-xs-12">
                        <label for="task_layout" style="margin-left: 5px">Cột trình bày đáp án ?</label>
                        <select name="task_layout" class="form-control" id="task_layout">
                            <option value="1">1 Cột</option>
                            <option value="2">2 Cột</option>
                            <option value="3">3 Cột</option>
                            <option value="4">4 Cột</option>
                        </select>
                    </div>
                    <div class="col-xs-12">
                        <label>Hình ảnh</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-addon" onclick="chooseFiless('task_thumbnail')"><i class="fa fa-fw fa-file"></i></span>
                            <input id="task_thumbnail" onclick="chooseFiless('task_thumbnail')" name="task_thumbnail" class="form-control" type="text" value=""/>
                        </div>
                        <img src="" alt="" id="demo_task_thumbnail">
                    </div>
                    <div class="col-xs-12">
                        <label>Câu trả lời</label>
                        <div class="list-answers" id="list-answers"></div>
                        <div class="add-answer" id="add-answer">
                            <button type="button" class="btn btn-success">Thêm câu hỏi</button>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <label for="task_type_point" style="margin-left: 5px">Cộng điểm cho kỹ năng ?</label>
                        <select name="task_type_point" class="form-control" id="task_type_point">
                            <option value="1">Quản lý thời gian tiếp xung màn hình</option>
                            <option value="2">Quản lý bắt nạt trên mạng</option>
                            <option value="3">Quản lý quyền riêng tư</option>
                            <option value="4">Danh tính công dân ký thuật số</option>
                            <option value="5">Quản lý an ninh mạng</option>
                            <option value="6">Quản lý dấu chân kỹ thuật số</option>
                            <option value="7">Tư duy phản biện</option>
                            <option value="8">Cảm thông kỹ thuật số</option>
                        </select>
                    </div>
                </div>`;
    },
}

const FILL = {
    data: {
        title: "",
        image: "",
        chars: {},
        point: 0,
        type_point: 1,
        type: "fill"
    },

    save: (type, key) => {
        var data_save = {type: type};

        data_save.image = $(document).find('#task_thumbnail').val();
        data_save.title = $(document).find('#task_name').val();
        data_save.point = $(document).find('#task_point').val();
        data_save.type_point = $(document).find('#task_type_point').val();
        data_save.chars = DATA.chars;

        DATA.tasks[key] = data_save;
    },

    click: (block, data) => {
        block.html(FILL.tag());

        $(document).find('#task_thumbnail').val(data.image);
        $(document).find('#demo_task_thumbnail').attr('src', media_url + data.image);
        $(document).find('#task_name').val(data.title);
        $(document).find('#task_point').val(data.point);
        $(document).find('#task_type_point').val(data.type_point);

        DATA.chars = data.chars || {};
        CHARS.fill();
    },

    tag: () => {
        return `<div class="form-group task-input" data-type="fill">
                    <div class="col-xs-12">
                        <div class="col-xs-12">
                            <label>Câu hỏi</label>
                            <div class="question-render-fill">
                                <input id="task_name" class="form-control" type="text"/>
                                <button type="button" class="btn btn-info render">Render</button>
                            </div>
                        </div>
                        <div class="list-fill"></div>
                        <div class="col-xs-12">
                            <label>Điểm</label>
                            <input id="task_point" class="form-control" type="number" min="0"/>
                        </div>
                        <div class="col-xs-12">
                            <label for="task_type_point" style="margin-left: 5px">Cộng điểm cho kỹ năng ?</label>
                            <select name="task_type_point" class="form-control" id="task_type_point">
                                <option value="1">Quản lý thời gian tiếp xung màn hình</option>
                                <option value="2">Quản lý bắt nạt trên mạng</option>
                                <option value="3">Quản lý quyền riêng tư</option>
                                <option value="4">Danh tính công dân ký thuật số</option>
                                <option value="5">Quản lý an ninh mạng</option>
                                <option value="6">Quản lý dấu chân kỹ thuật số</option>
                                <option value="7">Tư duy phản biện</option>
                                <option value="8">Cảm thông kỹ thuật số</option>
                            </select>
                        </div>
                        <div class="col-xs-12">
                            <label>Hình ảnh</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon" onclick="chooseFiless('task_thumbnail')"><i class="fa fa-fw fa-file"></i></span>
                                <input id="task_thumbnail" onclick="chooseFiless('task_thumbnail')" name="task_thumbnail" class="form-control" type="text" value=""/>
                            </div>
                            <img src="" alt="" id="demo_task_thumbnail">
                        </div>
                    </div>
                </div>`;
    },
}

const CROSSWORD = {
    data: {
        crossword: [],
        point: 0,
        type_point: 1,
        type: "crossword"
    },

    save: (type, key) => {
        var data_save = {type: type};

        let crossword = [];
        let crosswordItem = [];
        $(document).find('#form-crossword').serializeArray().map((e, i) => {
            let y = parseInt(e.name.split('[').at(1).split(']').at(0));
            let x = parseInt(e.name.split('[').at(2).split(']').at(0));

            if (x === 0 && y > 0) {
                crossword.push(crosswordItem);
                crosswordItem = [];
            }

            crosswordItem.push(e.value);
        });
        crossword.push(crosswordItem);

        data_save.title = $(document).find('#task_name').val();
        data_save.point = $(document).find('#task_point').val();
        data_save.type_point = $(document).find('#task_type_point').val();
        data_save.crossword = crossword;

        DATA.tasks[key] = data_save;
    },

    click: (block, data) => {
        block.html(CROSSWORD.tag());

        $(document).find('#task_name').val(data.title);
        $(document).find('#task_point').val(data.point);
        $(document).find('#task_type_point').val(data.type_point);
        data.crossword.map((e, i) => {
            e.map((ec, ic) => {
                $(document).find(`input[name="crossword[${i}][${ic}]"]`).val(ec);
            })
        })
    },

    tag: () => {

        let html = '';
        for (let x = 0; x < 15; x++) {
            html += `<tr id="row_${x}">`;
            for (let y = 0; y < 15; y++) {
                html += `<td class="item crossword" id="cell_${y}"> <input type="text" name="crossword[${x}][${y}]" maxlength="1"> </td>`;
            }
            html += '</tr>';
        }

        return `<div class="form-group task-input" data-type="crossword">
                    <div class="col-xs-12">
                        <label>Các từ cần tìm (các nhau bằng dẩu phẩy ',')</label>
                        <textarea id="task_name" class="form-control" type="text" placeholder="từ 1, từ 2, ..."></textarea>
                    </div>
                    <div class="col-xs-12">
                        <label>Điểm</label>
                        <input id="task_point" class="form-control" type="number" min="0"/>
                    </div>
                    <div class="col-xs-12">
                        <label for="task_type_point" style="margin-left: 5px">Cộng điểm cho kỹ năng ?</label>
                        <select name="task_type_point" class="form-control" id="task_type_point">
                            <option value="1">Quản lý thời gian tiếp xung màn hình</option>
                            <option value="2">Quản lý bắt nạt trên mạng</option>
                            <option value="3">Quản lý quyền riêng tư</option>
                            <option value="4">Danh tính công dân ký thuật số</option>
                            <option value="5">Quản lý an ninh mạng</option>
                            <option value="6">Quản lý dấu chân kỹ thuật số</option>
                            <option value="7">Tư duy phản biện</option>
                            <option value="8">Cảm thông kỹ thuật số</option>
                        </select>
                    </div>
                    <div class="col-xs-12">
                        <form action="" id="form-crossword"><table id="table-crossword">${html}</table></form> 
                    </div>
                </div>`;
    }
}

const IMAGES = {
    data: {
        title: '',
        background: '',
        image: '',
        time: 30,
        point: 0,
        type_point: 1,
        type: 'images'
    },

    save: (type, key) => {
        var data_save = {type: type};

        //code
        data_save.background = $(document).find('#task_background').val();
        data_save.title = $(document).find('#task_name').val();
        data_save.image = $(document).find('#task_thumbnail').val();
        data_save.time = $(document).find('#task_time').val();
        data_save.point = $(document).find('#task_point').val();
        data_save.type_point = $(document).find('#task_type_point').val();

        DATA.tasks[key] = data_save;
    },

    click: (block, data) => {
        block.html(IMAGES.tag());

        //code
        $(document).find('#task_background').val(data.background);
        $(document).find('#task_name').val(data.title);
        $(document).find('#demo_task_background').attr('src', media_url + data.background);
        $(document).find('#task_thumbnail').val(data.image);
        $(document).find('#demo_task_thumbnail').attr('src', media_url + data.image);
        $(document).find('#task_time').val(data.time);
        $(document).find('#task_point').val(data.point);
        $(document).find('#task_type_point').val(data.type_point);
    },

    tag: () => {
        return `<div class="form-group task-input" data-type="images">
                    <div class="col-xs-12">
                        <label>Câu hỏi</label>
                        <input id="task_name" class="form-control" type="text"/>
                    </div>
                    <div class="col-xs-12">
                        <label>Hình nền</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-addon" onclick="chooseFiless('task_background')"><i class="fa fa-fw fa-file"></i></span>
                            <input id="task_background" onclick="chooseFiless('task_background')" name="task_background" class="form-control" type="text" value=""/>
                        </div>
                        <img src="" alt="" id="demo_task_background">
                    </div>
                    <div class="col-xs-12">
                        <label>Hình ảnh cần tìm (nên chọn tệp có định dạng .png)</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-addon" onclick="chooseFiless('task_thumbnail')"><i class="fa fa-fw fa-file"></i></span>
                            <input id="task_thumbnail" onclick="chooseFiless('task_thumbnail')" name="task_thumbnail" class="form-control" type="text" value=""/>
                        </div>
                        <img src="" alt="" id="demo_task_thumbnail">
                    </div>
                    <div class="col-xs-12">
                        <label>Thời gian chơi (giây)</label>
                        <input id="task_time" class="form-control" type="number" value="30" min="30"/>
                    </div>
                    <div class="col-xs-12">
                        <label>Điểm</label>
                        <input id="task_point" class="form-control" type="number" min="0"/>
                    </div>
                    <div class="col-xs-12">
                        <label for="task_type_point" style="margin-left: 5px">Cộng điểm cho kỹ năng ?</label>
                        <select name="task_type_point" class="form-control" id="task_type_point">
                            <option value="1">Quản lý thời gian tiếp xung màn hình</option>
                            <option value="2">Quản lý bắt nạt trên mạng</option>
                            <option value="3">Quản lý quyền riêng tư</option>
                            <option value="4">Danh tính công dân ký thuật số</option>
                            <option value="5">Quản lý an ninh mạng</option>
                            <option value="6">Quản lý dấu chân kỹ thuật số</option>
                            <option value="7">Tư duy phản biện</option>
                            <option value="8">Cảm thông kỹ thuật số</option>
                        </select>
                    </div>
                </div>`;
    }
}

const CARD = {
    data: {
        cards: [],
        type_point: 1,
        type: "card"
    },

    save: (type, key) => {
        var data_save = {type: type};

        data_save.cards = [];
        for (let i = 0; i < 8; i++) {
            data_save.cards.push({
                card: $(document).find(`#task_thumbnail_card_${i}`).val(),
                point: $(document).find(`#task_point_card_${i}`).val()
            })
        }
        data_save.type_point = $(document).find('#task_type_point').val();

        DATA.tasks[key] = data_save;
    },

    click: (block, data) => {
        block.html(CARD.tag());

        if (data.cards.length) {
            data.cards.map((e, i) => {
                $(document).find(`#task_thumbnail_card_${i}`).val(e.card);
                $(document).find(`#demo_task_thumbnail_card_${i}`).attr('src', media_url + e.card);
                $(document).find(`#task_point_card_${i}`).val(e.point)
            })
        }

        $(document).find('#task_type_point').val(data.type_point);
    },

    tag: () => {
        let card = '';
        for (let i = 0; i < 8; i++) {
            card += `<div class="col-xs-3">
                        <div class="card">
                            <div class="choose" onclick="chooseFiless('task_thumbnail_card_${i}')">
                                <img src="" alt="" id="demo_task_thumbnail_card_${i}">
                                <input id="task_thumbnail_card_${i}" class="form-control" type="hidden" value=""/>
                            </div>
                            <input type="number" class="form-control" id="task_point_card_${i}" min="0" value="0">
                        </div>
                    </div>`;
        }
        return `<div class="form-group task-input" data-type="card">
                    <div class="col-xs-12"><label>Chọn các thẻ bài và nhập điểm tương ứng</label></div>
                    ${card}
                    <div class="col-xs-12">
                        <label for="task_type_point" style="margin-left: 5px">Cộng điểm cho kỹ năng ?</label>
                        <select name="task_type_point" class="form-control" id="task_type_point">
                            <option value="1">Quản lý thời gian tiếp xung màn hình</option>
                            <option value="2">Quản lý bắt nạt trên mạng</option>
                            <option value="3">Quản lý quyền riêng tư</option>
                            <option value="4">Danh tính công dân ký thuật số</option>
                            <option value="5">Quản lý an ninh mạng</option>
                            <option value="6">Quản lý dấu chân kỹ thuật số</option>
                            <option value="7">Tư duy phản biện</option>
                            <option value="8">Cảm thông kỹ thuật số</option>
                        </select>
                    </div>
                </div>`;
    }
}

// task chat
const CHAT = {
    data: {
        point: 0,
        type: "chat",
        answers: {},
        title: "",
        sender: "",
        check: true,
    },
    checked: true,

    init: () => {
        CHAT.showListAnswers();
    },

    save: (type, key) => {


        let data_save = {type: type};
        data_save.point = 0;
        data_save.title = $(document).find("#task_title").val();
        data_save.sender = $(document).find("#sel_sender").val();
        let ADataAnswer = $(document).find("#A_Answer").val();
        let BDataAnswer = $(document).find("#B_Answer").val();
        let aPointAnswer = $(document).find("#task_point_A").val();
        let bPointAnswer = $(document).find("#task_point_B").val();
        data_save.answers = DATA.answers;
        if (CHAT.checked) {
            data_save.answers = CHAT.data.answers;
            data_save.check = true;
        } else {
            data_save.answers = {
                A: {data: ADataAnswer, point: aPointAnswer},
                B: {data: BDataAnswer, point: bPointAnswer},
            };
            data_save.check = false;
        }

        DATA.tasks[key] = data_save;
    },

    click: (block, data) => {
        block.html(CHAT.tag());

        CHAT.exCheck(data.check);
        $(document).find("#task_title").val(data.title);
        $(document).find("#task_check").prop("checked", data.check);
        $(document).find("#sel_sender").val(data.sender);

        if (data.check) {
            $(document).find("#A_Answer").val("");
            $(document).find("#B_Answer").val("");
            $(document).find("#task_point_A").val("");
            $(document).find("#task_point_B").val("");
        } else {
            console.log(data.answers.A.data)
            $(document).find("#A_Answer").val(data.answers.A.data);
            $(document).find("#B_Answer").val(data.answers.B.data);
            $(document).find("#task_point_A").val(data.answers.A.point);
            $(document).find("#task_point_B").val(data.answers.B.point);
        }
        //code
    },
    showListAnswers: () => {
        $(document).on("change", "#task_check", function () {
            CHAT.checked = $(this).prop("checked");
            CHAT.exCheck(CHAT.checked);
        });
    },

    exCheck: (check) => {
        if (check) {
            $("#list-answers").html("");
        } else {
            $("#list-answers").html(CHAT.tagChatAnswer());
        }
    },

    tag: () => {
        return `<div class="form-group task-input" data-type="chat">
                    <div class="col-xs-12">
                        <label>Tiêu đề:(các câu nhắn cách nhau bằng dấu ',')</label> <br>
                        <textarea placeholder="câu 1, câu 2, câu 3" id="task_title" class="form-control" style="width: 100%; height: 300px;"  name="review" rows="4" cols="50">
                        </textarea>
                    </div>
                    <div class="col-xs-12" style="margin:20px 0;">
                        <label for="sel1">Người gửi:</label>
                        <select class="form-control" id="sel_sender">
                            <option value="lita">Lita</option>
                            <option value="alvin">Alvin</option>
                            <option value="amiga">Amiga</option>
                        </select>
                    </div>
                    <div class="col-xs-12">
                        <input type="checkbox" id="task_check" checked value="" min="0"/> 
                        <label for="task_check"> Phải chọn câu trả lời ? </label>
                    </div>
                    <div class="col-xs-12" id="list-answers"></div>
                </div>`;
    },
    tagChatAnswer: () => {
        return `<div class="form-group" style="margin: 10px 0 0  0;" >
                     <label>Câu trả lời:</label> <br>
                     
                     <div class="col-xs-12" style="display: flex">
                        <input type="text" class="form-control"  placeholder = "Câu trả lời"  id="A_Answer">
                        <input id="task_point_A" class="form-control" type="number" style="width: 70px"/>
                    </div>
                    <div class="col-xs-12" style="display: flex">
                        <input type="text" class="form-control"  placeholder = "Câu trả lời"  id="B_Answer">
                        <input id="task_point_B" class="form-control" type="number" style="width: 70px"/>
                    </div>
                 </div>`;
    },
};
//end task chat


const ANSWERS = {

    key: 0,

    data_answer: {
        title: "",
        point: 0,
        is_right: 0
    },

    init: function () {
        ANSWERS.add();
        ANSWERS.remove();
    },

    add: function () {
        $(document).on("click", '#add-answer', function () {
            ANSWERS.save();
            DATA.answers[ANSWERS.key] = ANSWERS.data_answer;
            ANSWERS.fill();
        });
    },

    remove: function () {
        $(document).on("click", '.remove-answer', function () {
            let key = $(this).closest('.answer').data('key');
            delete DATA.answers[key];
            $(this).closest('.answer').remove();
        });
    },

    reset: function () {
        ANSWERS.key = 0;
        DATA.answers = {};
        $(document).find('#list-answers').html("");
    },

    save: function () {
        var data = DATA.answers;
        var data_new = {};

        Object.keys(data).map(function (key, index) {
            data_new[key] = {
                title: $(document).find(`.answer[data-key="${key}"] .title`).val(),
                point: $(document).find(`.answer[data-key="${key}"] .point`).val(),
                is_right: $(document).find(`.answer[data-key="${key}"] .checkbox:checked`).val() ? 1 : 0,
            };
        });

        DATA.answers = data_new;
    },

    fill: function () {
        var data = DATA.answers;
        var key_data = 0;
        $(document).find('#list-answers').html("");

        Object.keys(data).map(function (key, index) {
            key_data = key;
            $(document).find('#list-answers').append(ANSWERS.tag(data[key].title, data[key].point || 0, data[key].is_right, key));
        });
        ANSWERS.key = parseInt(key_data) + 1;
    },

    tag: (title, point, is_right, key) => {
        return `<div class="answer" data-key="${key}">
                    <input type="checkbox" class="checkbox" ${is_right ? 'checked' : ''}>
                    <input type="text" value="${title}" class="title form-control">
                    <input type="number" min="0" value="${point}" class="point form-control" style="width: 60px; margin-left: 10px">
                    <button type="button" class="remove-answer btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button>
                </div>`;
    }
}

const CHARS = {

    data_chars: {
        char: '',
        is_fill: 0,
        is_space: 0,
    },

    init: () => {
        CHARS.render();
        CHARS.choice();
    },

    render: () => {
        $(document).on("click", '.question-render-fill button', function () {
            let content = $(document).find('#task_name').val().trim().split('');
            let html = '';
            let data = {};

            if (content.length > 0) {
                content.map((char, i) => {
                    let space = char === ' ' ? 'space' : '';
                    let last = data[Object.keys(data).pop()] || {is_space: 0};

                    if (!last.is_space || char !== ' ') {
                        html += `<input readonly type="text" class="char-fill ${space}" value="${char}" data-checked="" data-key="${i}">`;

                        data[i] = {
                            char: char,
                            is_fill: 0,
                            is_space: space ? 1 : 0,
                        };
                    }
                });
            }

            DATA.chars = data;

            $(document).find('.list-fill').html(html);
        });
    },

    choice: () => {
        $(document).on("click", '.list-fill .char-fill', function () {
            let key = $(this).data('key');
            let checked = $(this).data('checked');

            if (!DATA.chars[key].is_space) {
                if (checked) {
                    $(this).data('checked', '');
                    $(this).removeClass('checked');
                    DATA.chars[key].is_fill = 0;
                } else {
                    $(this).data('checked', 'checked');
                    $(this).addClass('checked');
                    DATA.chars[key].is_fill = 1;
                }
            }
        });
    },

    fill: () => {
        let data = DATA.chars;
        let html = '';

        Object.keys(data).map(function (key, index) {
            let space = data[key].is_space ? 'space' : '';
            let checked = data[key].is_fill ? 'checked' : '';
            html += `<input readonly type="text" class="char-fill ${checked} ${space}" value="${data[key].char}" data-checked="${checked}" data-key="${index}">`;
        });

        $(document).find('.list-fill').html(html);
    }
}
