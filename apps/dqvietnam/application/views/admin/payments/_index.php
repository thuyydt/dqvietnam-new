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
              <form action="<?php echo site_url('admin/payments/export') ?>" method="get">
                <div class="col-sm-4">
                  <div class="form-group">
                    <input type="month" name="month" class="form-control"
                      placeholder="Chọn tháng" value="<?= date('Y-m') ?>">
                  </div>
                </div>
                <div class="col-sm-4">
                  <button class="btn btn-success"> Xuất Excel</button>
                </div>
              </form>
            </div>
            <div class="col-sm-5 col-xs-12 text-right">
              <button class="btn btn-default" type="button" type="button" onclick="reload_table()">
                <i class="glyphicon glyphicon-refresh"></i> <?php echo lang('btn_reload'); ?>
              </button>
            </div>
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
            <input type="hidden" value="0" name="msg" />
            <table id="data-table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="60">
                    <input type="checkbox" name="select_all" value="1" id="data-table-select-all">
                  </th>
                  <th width="60">ID</th>
                  <th>Mã thanh toán</th>
                  <th>Tài khoản</th>
                  <th>Thời gian thanh toán</th>
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
        <!-- Custom Tabs -->
        <div class="box-body">
          <div class="form-group">
            <div class="col-xs-12">
              <label>Mã thanh toán <?php showRequiredField() ?></label>
              <input name="payment_code" placeholder="" class="form-control" type="text" />
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-6">
              <label>Khoá học</label>
              <select class="form-control select2" style="width: 100%;" name="package_id"></select>
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
            <div class="col-md-6">
              <label>Tài khoản</label>
              <select class="form-control select2" style="width: 100%;" name="account_id"></select>
            </div>
            <div class="col-xs-6">
              <label>Trường học</label>
              <input type="hidden" name="school_id">
              <input readonly name="schools_name" placeholder="" class="form-control" type="text" />
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-6">
              <label>Thời gian thanh toán</label>
              <input readonly type="text" name="time_payment" class="form-control datetimepicker" autocomplete="off">
            </div>

            <div class="col-xs-6">
              <label>Số tiền (VND) : <span class="price_demo"></span></label>
              <input name="price" type="number" class="form-control price" min="0">
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-12">
              <label>Nội dung</label>
              <textarea name="content" class="form-control" autocomplete="off"></textarea>
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
  var url_ajax_load_account = '<?= site_url('admin/account/ajax_load') ?>';
  var url_ajax_load_package = '<?= site_url('admin/packages/ajax_load') ?>';
  var url_ajax_load_schools = '<?= site_url('admin/schools/ajax_get_by_account_id') ?>';
</script>