<?php

defined('BASEPATH') OR exit('No direct script access allowed');
$controller = $this->router->fetch_class();
$method = $this->router->fetch_method();
?>
<div class="col-sm-7 col-xs-12">
  <?php
  if (in_array($controller, ['category'])):
      switch ($controller){
          case 'career':
              $place='Chọn ngành nghề';
              break;
          default:
              $place='Chọn danh mục';
              break;
      }
    ?>
		<div class="form-group">
		  <div class="input-group">
			<span class="input-group-addon"><i class="fa fa-filter"></i></span>
			<select class="form-control select2 filter_category" data-place="<?=$place?>" title="filter_category_id" name=""
					style="max-width: 100%;" tabindex="-1" aria-hidden="true">
			  <option value="0"><?php echo $place; ?></option>
			</select>
		  </div>
		</div>
  <?php endif; ?>
</div>
