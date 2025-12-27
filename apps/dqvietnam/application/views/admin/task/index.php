<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-7 col-xs-12">
                            <div class="row">
                                <form action="" id="form_filter" method="post">
                                    <!--                                    <div class="col-md-6">-->
                                    <!--                                        --><?php //$this->load->view($this->template_path . "_block/where_status") ?>
                                    <!--                                    </div>-->
                                </form>
                            </div>
                        </div>
                        <?php $this->load->view($this->template_path . "_block/button") ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <form action="" id="form-table" method="post">
                        <input type="hidden" value="0" name="msg"/>
                        <table id="data-table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="60">
                                    <input type="checkbox" name="select_all" value="1" id="data-table-select-all">
                                </th>
                                <th width="60">ID</th>
                                <th><?php echo lang('text_title'); ?></th>
                                <th>Nổi bật</th>

                                <th><?php echo lang('text_created_time'); ?></th>
                                <th>Trạng thái</th>
                                <?php showColumnAction(); ?>
                            </tr>
                            </thead>
                        </table>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog" style="width: 70%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="title-form"><?= lang('heading_title_add'); ?></h3>
            </div>
            <div class="modal-body form">
                <?= form_open('', ['id' => 'form', 'class' => '']) ?>
                <input type="hidden" name="id" value="0">
                <input type="hidden" name="key" value="1">
                <!-- Custom Tabs -->
                <div class="box-body">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label>Tiêu đề <?php showRequiredField() ?></label>
                            <input name="name" placeholder="" readonly
                                   class="form-control" type="text"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <label>Thế loại <?php showRequiredField() ?></label>
                            <select name="type" id="" class="form-control">
                                <option value="0">Dùng chung</option>
                                <option value="1">Gói cá nhận</option>
                                <option value="2">Gói nhà trường</option>
                            </select>
                        </div>

                        <div class="col-xs-6">
                            <label>Trạng thái <?php showRequiredField() ?></label>
                            <select name="status" id="" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?= form_close() ?>
                <div class="box-body">
                    <div class="col-xs-12">
                        <fieldset class="form-group album-contain" id="tasks" style="padding-bottom: 20px">
                            <legend>Nội dung</legend>

                            <div class="col-xs-6">
                                <div style="display: flex" class="add-new">
                                    <select id="type_content" class="form-control">
                                        <option value="slide">Slide</option>
                                        <option value="question">Câu hỏi - Chọn đáp án đúng</option>
                                        <option value="fill">Câu hỏi - Điền vào chỗ trống</option>
                                        <option value="crossword">Trò chơi - Tìm từ</option>
                                        <option value="images">Trò chơi - Tìm hình ảnh</option>
                                        <option value="card">Trò chơi - Thẻ bài</option>
                                        <option value="chat">Trò chuyện</option>
                                    </select>
                                    <button type="button" class="btn-add-new btn btn-success" style="margin-left: 15px">
                                        Thêm
                                    </button>
                                </div>
                                <div class="list-item" id="list-item"></div>
                            </div>
                            <div class="col-xs-6" id="tasks-right">
                                <div style="height: 600px; border: 1px solid #b9b9b9; border-radius: 10px; padding-top: 25px; overflow: auto"
                                     id="fill-task">
                                </div>
                                <div class="save-tasks">
                                    <button class="btn btn-success" id="save-data-task" type="button">Lưu nội dung
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <!-- nav-tabs-custom -->

            </div>
            <div class="modal-footer">
                <?php $this->load->view($this->template_path . '_block/form_button') ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
<style>

    .list-fill {
        margin: 0 15px;
    }

    .list-fill .char-fill {
        margin: 10px 5px 0 0;
        border: 1px solid #d2d6de;
        width: 30px;
        height: 30px;
        outline: none;
        cursor: pointer;
        text-align: center;
    }

    .list-fill .char-fill.space {
        border: none;
        background: #fff;
        cursor: auto;
        width: 10px;
    }

    .list-fill .char-fill.checked {
        background: #e75555;
        color: #fff;
    }

    #tasks-right {
        position: relative;
    }

    #tasks-right .save-tasks {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0 15px;
    }

    .list-item {

    }

    .list-item .item {
        margin-top: 15px;
        padding: 5px 20px 10px 35px;
        border: 1px solid #b9b9b9;
        border-radius: 5px;
        background: #fff;
        cursor: pointer;
        position: relative;
        transition: 0.3s all;
    }

    .list-item .item .move {
        position: absolute;
        left: 0;
        padding: 0 10px;
        height: 100%;
        line-height: 55px;
        color: #979797;
        font-size: 16px;
        top: 0px;
        cursor: -webkit-grab;
    }

    .list-item .item.active {
        background: #c5e5ff;
    }

    .list-item .item span {
        font-weight: bold;
        font-size: 11px;
        opacity: 0.7;
    }

    .list-item .item button {
        position: absolute;
        right: -5px;
        top: -5px;
        background: #d72e2e;
        width: 30px;
        height: 30px;
        line-height: 20px;
        text-align: center;
        border: none;
        border-radius: 50%;
        color: #fff;
        font-size: 11px;
    }

    .list-item .item p {
        margin: 0;
        font-weight: bold;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }

    .task-input .col-xs-12 {
        padding-top: 15px;
    }

    .task-input img {
        height: 150px;
        object-fit: cover;
    }

    .list-answers .answer {
        display: flex;
        padding-top: 15px;
    }

    .list-answers .answer .checkbox {
        width: 25px;
        height: 25px;
        margin-right: 15px;
        cursor: pointer;
    }

    .list-answers .answer button {
        margin-left: 15px;
    }

    .add-answer {
        padding-top: 15px;
    }

    .question-render-fill {
        display: flex;
    }

    #table-crossword .item {
        width: 30px;
    }

    #table-crossword .item input {
        width: 30px;
        height: 30px;
        text-align: center;
        text-transform: capitalize;
        font-weight: 700;
        font-size: 17px;
    }

    .card .choose {
        border: 1px solid #999;
        height: 160px;
        position: relative;
        cursor: pointer;
    }

    .card .choose:before {
        content: '+';
        position: absolute;
        font-size: 50px;
        text-align: center;
        color: #999999;
        width: 60px;
        display: inline;
        height: 60px;
        line-height: 56px;
        border: 3px solid #999999;
        border-radius: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        top: 50%;
        cursor: pointer;
    }

    .card .choose img {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }

    .card {
        margin-top: 15px;
    }

    .list-answers.list-crossword .checkbox {
        display: none;
    }
</style>
<script>
    var url_ajax_load_category = '<?= site_url('admin/category/ajax_load/post') ?>';
    var url_ajax_load_tag = '<?= site_url('admin/tag/ajax_load') ?>';
    var url_ajax_load = '<?= site_url('admin/category/ajax_load/post') ?>';
    var url_ajax_get_title = '<?= site_url('admin/task/ajax_get_title') ?>';
</script>
