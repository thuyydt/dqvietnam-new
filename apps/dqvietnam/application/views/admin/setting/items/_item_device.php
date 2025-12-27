<?php
$item = !empty($item) ? (array)$item : null;
if (isset($_GET['id'])) $id = $_GET['id'];
if (isset($_GET['meta_key'])) $meta_key = $_GET['meta_key'];
?>
<fieldset>
    <div class="row">
        <div class="col-md-4">
            <?= form_input($meta_key . "[" . $meta_key . $id . "][name]",
                !empty($item['name']) ? $item['name'] : ''
                , ['class' => 'form-control', 'placeholder' => 'Tên thiết bị']) ?>
        </div>
        <div class="col-md-8">
            <?= form_input($meta_key . "[" . $meta_key . $id . "][devices]",
                !empty($item['devices']) ? $item['devices'] : ''
                , ['class' => 'form-control', 'placeholder' => 'Danh sách máy']) ?>
        </div>
    </div>
    <i class="glyphicon glyphicon-trash removeInput" onclick="removeInputImage(this)"></i>
</fieldset>