<?php
$list_field_normal = [
  ['name' => 'logo', 'id' => 'logo', 'title' => 'Logo', 'type' => 'input_media'],
  ['name' => 'favicon', 'id' => 'favicon', 'title' => 'Favicon', 'type' => 'input_media'],
  ['name' => 'image_share_default', 'id' => 'image_share_default', 'title' => 'Hình ảnh chia sẽ mặc định', 'type' => 'input_media'],
  ['name' => 'meta_name', 'title' => 'Tên website', 'type' => 'input_text'],
  ['name' => 'meta_title', 'title' => 'Tiêu đề SEO', 'type' => 'input_text'],
  ['name' => 'meta_meta_desc', 'title' => 'Mô tả SEO', 'type' => 'input_textarea'],
  ['name' => 'meta_keyword', 'title' => 'Từ khoá (tách các từ bằng dấu phấy ",")', 'type' => 'input_textarea'],
];
?>
<div class="tab-pane active" id="<?= $target ?>">
  <div class="box-body">
    <?php if (!empty($list_field_normal)) foreach ($list_field_normal as $key => $item) {
      $item['value'] = !empty(${$item['name']}) ? ${$item['name']} : '';
      $this->load->view($this->template_path . 'setting/items/' . $item['type'], $item);
    } ?>
  </div>
</div>