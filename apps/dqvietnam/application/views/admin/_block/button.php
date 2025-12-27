<?php

defined('BASEPATH') or exit('No direct script access allowed');
$display_button = !empty($display_button) ? $display_button : [];
$controller = $this->router->fetch_class();
?>
<div class="col-sm-5 col-xs-12 text-right">
  <?php button_admin($display_button) ?>
  <?php if (in_array('copy', $display_button)): ?>

    <button class="btn btn-info" type="button" type="button" onclick="copy_multiple()">
      <i class="fa fa-fw fa-copy"></i> <?php echo lang('btn_copy'); ?>
    </button>
  <?php endif; ?>
  <button class="btn btn-default" type="button" type="button" onclick="reload_table()">
    <i class="glyphicon glyphicon-refresh"></i> <?php echo lang('btn_reload'); ?>
  </button>
</div>