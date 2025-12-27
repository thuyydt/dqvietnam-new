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
                  <th>Email</th>
                  <th>Số điện thoại</th>
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