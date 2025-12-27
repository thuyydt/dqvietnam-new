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
                                <th>Giá (VND)</th>
                                <th>Giới hạn tài khoản</th>
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
    <div class="modal-dialog" style="width: 60%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="title-form"><?= lang('heading_title_add'); ?></h3>
            </div>
            <div class="modal-body form">
                <?= form_open('', ['id' => 'form', 'class' => '']) ?>
                <input type="hidden" name="id" value="0">
                <!-- Custom Tabs -->
                <div class="box-body">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label>Tiêu đề <?php showRequiredField() ?></label>
                            <input name="name" placeholder=""
                                   class="form-control" type="text"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <label>Giới hạn tài khoản</label>
                            <input name="limit_account" type="number" class="form-control" value="1" min="1">
                        </div>

                        <div class="col-xs-6">
                            <label>Trạng thái <?php showRequiredField() ?></label>
                            <select name="status" id="" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <input name="is_contact" id="is_contact" type="checkbox" min="0">
                            <label for="is_contact">Liên hệ để thương lượng giá?</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6" id="price_new">
                            <label>Giá (VND) : <span class="price_demo"></span></label>
                            <input name="price" type="number" class="form-control price" min="0">
                        </div>

                        <div class="col-xs-6" id="price_old">
                            <label>Giá cũ (VND) : <span class="price_demo"></span></label>
                            <input name="price_old" type="number" class="form-control price" min="0">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label>Nội dung chi tiết</label>
                            <textarea name="detail" class="tinymce form-control" id="detail"></textarea>
                        </div>
                    </div>
                </div>
                <!-- nav-tabs-custom -->
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
    var url_ajax_load_category = '<?= site_url('admin/category/ajax_load/post') ?>';
    var url_ajax_load_tag = '<?= site_url('admin/tag/ajax_load') ?>';
    var url_ajax_load = '<?= site_url('admin/category/ajax_load/post') ?>';
</script>
