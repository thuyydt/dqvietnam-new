<?php

defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-7 col-xs-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-filter"></i></span>
                                            <select class="form-control is_status" name="is_status"
                                                    style="width: 100%;" tabindex="-1" aria-hidden="true">
                                                <option value="">Lựa chọn trạng thái</option>
                                                <option value="1">Đang hoạt động</option>
                                                <option value="0">Ngừng hoạt động</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <?php if (!isset($this->session->school_id)) : ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-filter"></i></span>
                                                <select class="form-control filter_school select2" name="filter_school"
                                                        style="width: 100%;" tabindex="-1" aria-hidden="true"> </select>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php $this->load->view($this->template_path . "_block/button", ['display_button' => ['add']]) ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <table id="data-table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th><input type="checkbox" name="select_all" value="1" id="data-table-select-all"></th>
                            <th>Mã TT</th>
                            <th><?php echo lang('text_email'); ?></th>
                            <th>Điểm số</th>
                            <th><?php echo lang('text_status'); ?></th>
                            <th>Thanh toán</th>
                            <th>Ngày đăng ký</th>
                            <?php showColumnAction(); ?>
                        </tr>
                        </thead>
                    </table>
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
                <h3 class="modal-title" id="title-form"><?php echo lang('heading_title_add'); ?></h3>
            </div>
            <div class="modal-body form">
                <?php echo form_open('', array('id' => 'form', 'class' => 'form-horizontal')) ?>
                <input type="hidden" name="id" value="0">
                <div class="box-body">
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Email <?php showRequiredField(); ?></label>
                            <input name="username" placeholder="Tài khoản" class="form-control" type="text"/>
                        </div>
                        <div class="col-md-6">
                            <label>Họ tên</label>
                            <input name="phone" class="form-control">
                        </div>
                    </div>
                    <div class="form-group" id="div-password">

                        <div class="col-xs-6">
                            <label><?php echo lang('form_password'); ?><?= showRequiredField() ?></label>
                            <div class="input-group">
                                <input name="password" id="pwd" placeholder="Mật khẩu" class="form-control"
                                       type="text"/>
                                <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" onclick="generatePwd('#pwd')">Tạo mật khẩu</button>
                                    </span>
                            </div>
                        </div>
                        <div class="col-md-3 style-gender" style="margin-top: 30px">
                            <label>Giới tính</label>
                            <label><input type="radio" value="1" name="gender" checked> Nam</label>
                            <label><input type="radio" value="2" name="gender"> Nữ</label>
                        </div>
                        <div class="col-md-3 style-gender" style="margin-top: 30px">
                            <label><input name="sendMail" type="checkbox" checked/> Gửi thông tin đến email</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Số điện thoại</label>
                            <input name="phone" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Ngày sinh <?php showRequiredField(); ?></label>
                            <input readonly type="text" name="birthday" class="form-control datepicker"
                                   placeholder="Ngày sinh"
                                   autocomplete="off">
                        </div>

                        <div class="col-md-6">
                            <label>Trạng thái</label>
                            <select class="form-control" name="active">
                                <option value="0">Ngừng hoạt động</option>
                                <option value="1" selected="">Đang hoạt động</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php if (!isset($this->session->school_id)) : ?>
                            <div class="col-md-6">
                                <label>Thế loại</label>
                                <select class="form-control" name="type">
                                    <option value="0" selected="">Cá nhân</option>
                                    <option value="1">Nhà trường</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Trường học</label>
                                <select class="form-control select2" style="width: 100%;" name="schools_id"></select>
                            </div>
                        <?php else: ?>
                            <input type="hidden" name="schools_id" value="<?= $this->session->school_id ?>">
                            <input type="hidden" name="type" value="1">
                        <?php endif; ?>


                    </div>

                </div>
                <?php echo form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()"
                        class="btn btn-primary pull-left"><?php echo lang('btn_save'); ?></button>
                <button type="button" class="btn btn-danger"
                        data-dismiss="modal"><?php echo lang('btn_cancel'); ?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
<script>
    var url_ajax_load_schools = '<?php echo site_url("admin/schools/ajax_load");?>';
    var url_ajax_reset_account = '<?php echo site_url("admin/account/ajax_reset_account");?>';
    var url_ajax_update_payment = '<?php echo site_url("admin/account/ajax_update_payment");?>';
</script>
