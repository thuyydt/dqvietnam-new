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
                                <th>Vị trí</th>
                                <th>Trạng thái</th>
                                <th><?php echo lang('text_created_time'); ?></th>
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
    <div class="modal-dialog" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="title-form"><?= lang('heading_title_add'); ?></h3>
            </div>
            <div class="modal-body form">
                <?= form_open('', ['id' => 'form', 'class' => '']) ?>
                <input type="hidden" name="id" value="0">

                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_info" data-toggle="tab">Thông tin chung</a>
                        </li>
                        <li>
                            <a href="#tab_seo" data-toggle="tab">Meta Seo</a>
                        </li>
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane active" id="tab_info">
                            <!-- Custom Tabs -->
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <label>Tiêu đề <?php showRequiredField() ?></label>
                                        <input name="name" id="name" placeholder="" class="form-control" type="text"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <label>Link dẫn</label>
                                        <input name="outer_link" id="outer_link" placeholder="Link external" class="form-control" type="text"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="location">Vị trí</label>
                                        <select name="location" id="location" class="form-control">
                                            <option value="">Không</option>
                                            <option value="1">Phải</option>
                                            <option value="2">Trải</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="layout">Layout Page</label>
                                        <select name="layout" id="layout" class="form-control">
                                            <option value="page">Trang tĩnh</option>
                                            <option value="hero">Người hùng DQ</option>
                                            <option value="rules">Điều khoản sủ dụng</option>
                                            <option value="privacy">Chính sách bảo mật</option>
                                            <option value="support">Hỗ trợ</option>
                                            <option value="active_account">Kích hoạt tài khoản</option>
                                            <option value="tutorial">Hướng dẫn học</option>
                                            <option value="faqs">Câu hỏi thường gặp</option>
                                            <option value="payment_guide">Hướng dẫn thanh toán</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-6">
                                        <label>Trạng thái <?php showRequiredField() ?></label>
                                        <select name="status" id="" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-6">
                                        <label>Thứ tự</label>
                                        <input name="sort" type="number" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <label>Nội dung chi tiết - HTML</label>
                                        <textarea name="content" class="tinymce form-control" id="content"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- nav-tabs-custom -->
                        </div>
                        <div class="tab-pane" id="tab_seo">
                            <?php $this->load->view($this->template_path . '_block/seo_meta') ?>
                        </div>
                    </div>

                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <?php $this->load->view($this->template_path . '_block/form_button') ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
<script>

</script>
