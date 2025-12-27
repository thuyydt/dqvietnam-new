<?php
$data_contact = [
  ['key' => 1, 'title' => 'Chung'],
  ['key' => 2, 'title' => 'Hợp Tác'],
  ['key' => 3, 'title' => 'Tư vẫn'],
];

$list_field_normal = [
  ['name' => 'name', 'title' => 'Tên', 'type' => 'input_text'],
  ['name' => 'address', 'title' => 'Địa chỉ', 'type' => 'input_text'],
  ['name' => 'phone', 'title' => 'Số điện thoại', 'type' => 'input_text'],
  ['name' => 'email', 'title' => 'Email', 'type' => 'input_text']
];
?>

<div class="tab-pane row " id="<?= $target ?>">
  <ul class="nav nav-pills nav-stacked col-md-3">
    <?php foreach ($data_contact as $field) { ?>
      <li role="presentation" class="<?= $field['key'] == 1 ? 'active' : '' ?>">
        <a style="text-transform: uppercase" href="#contact_<?= $field['key'] ?>"
          data-toggle="tab"><?= $field['title'] ?></a>
      </li>
    <?php } ?>
  </ul>
  <div class="tab-content col-md-9">
    <?php foreach ($data_contact as $field) { ?>
      <div class="tab-pane <?= $field['key'] == 1 ? 'active' : '' ?>" id="contact_<?= $field['key'] ?>">
        <fieldset class="form-group album-contain">
          <legend>Liên Hệ <?= $field['title'] ?></legend>
          <?php if (!empty($list_field_normal)) foreach ($list_field_normal as $key => $item) {
            $item['name'] = $item['name'] . '_contact_' . $field['key'];
            $item['value'] = !empty(${$item['name']}) ? ${$item['name']} : '';
            $this->load->view($this->template_path . 'setting/items/' . $item['type'], $item);
          } ?>
        </fieldset>
      </div>
    <?php } ?>
  </div>
</div>