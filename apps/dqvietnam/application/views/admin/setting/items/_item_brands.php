<?php
$item = !empty($item) ? (array)$item : null;
if (isset($_GET['id'])) $id = $_GET['id'];
if (isset($_GET['meta_key'])) $meta_key = $_GET['meta_key'];
?>
<fieldset>
  <div class="row row5">
    <div class="col-md-1">
      <?= form_input(
        $meta_key . "[" . $meta_key . $id . "][brand]",
        !empty($item['brand']) ? $item['brand'] : '',
        ['class' => 'form-control', 'placeholder' => 'Brand']
      ) ?>
    </div>
    <div class="col-md-1">
      <?= form_input(
        $meta_key . "[" . $meta_key . $id . "][channel]",
        !empty($item['brand']) ? $item['channel'] : '',
        ['class' => 'form-control', 'placeholder' => 'Channel']
      ) ?>
    </div>
    <div class="col-md-1">
      <select name="<?= $meta_key . '[' . $meta_key . $id . '][type]' ?>" class="form-control">
        <option value="web" <?= show_selected('web', !empty($item['type']) ? $item['type'] : '') ?>>Web</option>
        <option value="mobile" <?= show_selected('mobile', !empty($item['type']) ? $item['type'] : '') ?>>
          Mobile
        </option>
        <option value="mobile_real" <?= show_selected('mobile_real', !empty($item['type']) ? $item['type'] : '') ?>>
          Mobile real
        </option>
      </select>
    </div>
    <div class="col-md-1">
      <select name="<?= $meta_key . '[' . $meta_key . $id . '][status]' ?>" class="form-control">
        <option value="on" <?= show_selected('on', !empty($item['status']) ? $item['status'] : '') ?>>On
        </option>
        <option value="off" <?= show_selected('off', !empty($item['status']) ? $item['status'] : '') ?>>Off
        </option>
      </select>
    </div>
    <div class="col-md-2">
      <select name="<?= $meta_key . '[' . $meta_key . $id . '][allow][]' ?>" class="form-control  select-phone"
        multiple
        style="width: 100% !important;">

        <?php
        if (!empty($item['allow'])) {
          foreach ($item['allow'] as $val) {
            echo "<option value='" . $val . "' selected>" . $val . "</option>";
          }
        }
        ?>
      </select>
    </div>

    <div class="col-md-2">
      <select name="<?= $meta_key . '[' . $meta_key . $id . '][devices][]' ?>" class="form-control select-devices"
        multiple style="width: 100% !important;">
        <?php
        if (!empty($item['devices'])) {
          foreach ($item['devices'] as $val) {
            echo "<option value='" . $val . "' selected>" . $val . "</option>";
          }
        }
        ?>
      </select>
    </div>

    <div class="col-md-1">
      <?= form_input(
        $meta_key . "[" . $meta_key . $id . "][limit]",
        !empty($item['limit']) ? $item['limit'] : 6000,
        ['class' => 'form-control limit-request', 'placeholder' => 'Limit', 'type' => 'number']
      ) ?>
    </div>

    <div class="col-md-1">
      <?= form_input(
        $meta_key . "[" . $meta_key . $id . "][min]",
        !empty($item['min']) ? $item['min'] : '',
        ['class' => 'form-control limit-request', 'placeholder' => 'Min SMS', 'type' => 'number']
      ) ?>
    </div>
    <div class="col-md-1">
      <input type="text" name="<?= $meta_key . '[' . $meta_key . $id . '][order]' ?>" class="form-control"
        value="<?= !empty($item['order']) ? $item['order'] : 0 ?>">
    </div>
    <div class="col-md-1">
      <?php
      $data = [
        'value' => !empty($item['script']) ? $item['script'] : '',
        'name' => $meta_key . '[' . $meta_key . $id . '][script]',
        'id' => $meta_key . '_' . $id . '_script',
      ];
      $this->load->view($this->template_path . 'setting/items/input_file', $data);
      ?>
    </div>
  </div>
  <i class="glyphicon glyphicon-trash removeInput" onclick="removeInputImage(this)"></i>
</fieldset>