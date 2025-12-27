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
            <input type="hidden" value="0" name="msg" />
            <table id="data-table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="60">
                    <input type="checkbox" name="select_all" value="1" id="data-table-select-all">
                  </th>
                  <th width="60">ID</th>
                  <th><?php echo lang('text_title'); ?></th>
                  <th class="no-sort">Số điện thoại</th>
                  <th class="no-sort">Email</th>
                  <th class="no-sort">Địa chỉ</th>
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
        <!-- Custom Tabs -->
        <div class="box-body">
          <div class="form-group">
            <div class="col-xs-12">
              <label>Tên trường <?php showRequiredField() ?></label>
              <input name="name" placeholder="" class="form-control" type="text" />
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <label>Số điện thoại <?php showRequiredField() ?></label>
              <input name="phone" placeholder="" class="form-control" type="text" />
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <label>Email <?php showRequiredField() ?></label>
              <input name="email" placeholder="" class="form-control" type="text" />
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <label>Tỉnh / Thành phố</label>
              <select class="form-control select2 city_" name="city_id" style="width: 100%;" tabindex="-1"
                aria-hidden="true"></select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <label>Quận/ Huyện</label>
              <select class="form-control select2 city_" name="district_id" style="width: 100%;"
                tabindex="-1" aria-hidden="true"></select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <label>Phường Xã</label>
              <select class="form-control select2 city_" name="ward_id" style="width: 100%;" tabindex="-1"
                aria-hidden="true"></select>
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
  var url_ajax_city = '<?php echo site_url('admin/location/ajax_load_city') ?>';
  var url_ajax_district = '<?php echo site_url('admin/location/ajax_load_district') ?>';
  var url_ajax_ward = '<?php echo site_url('admin/location/ajax_load_ward') ?>';
</script>