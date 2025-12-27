<?php
$list_field_normal = [
  ['title' => 'Video Hướng Dẫn Học', 'name' => 'video_tutorial', 'type' => 'input_video']
];
?>

<div class="tab-pane row " id="<?= $target ?>">
  <div class="tab-content col-md-12">
    <fieldset class="form-group album-contain">
      <legend>Thiết lập trang chủ</legend>
      <?php if (!empty($list_field_normal)) foreach ($list_field_normal as $key => $item) {
        $item['value'] = !empty(${$item['name']}) ? ${$item['name']} : '';
        $this->load->view($this->template_path . 'setting/items/' . $item['type'], $item);
      } ?>
    </fieldset>
  </div>
</div>