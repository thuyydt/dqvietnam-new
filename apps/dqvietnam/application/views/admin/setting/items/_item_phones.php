<?php
$item = !empty($item) ? (array)$item : null;
if (isset($_GET['id'])) $id = $_GET['id'];
if (isset($_GET['meta_key'])) $meta_key = $_GET['meta_key'];
?>
<fieldset>
    <div class="row">
        <div class="col-md-3">
            <?= form_input($meta_key . "[" . $meta_key . $id . "][name]",
                !empty($item['name']) ? $item['name'] : ''
                , ['class' => 'form-control', 'placeholder' => 'Tên dải số']) ?>
        </div>
        <div class="col-md-3">
            <?= form_input($meta_key . "[" . $meta_key . $id . "][first_number]",
                !empty($item['first_number']) ? $item['first_number'] : ''
                , ['class' => 'form-control', 'placeholder' => 'Đầu số']) ?>
        </div>
        <div class="col-md-2">
            <?= form_input($meta_key . "[" . $meta_key . $id . "][table]",
                !empty($item['table']) ? $item['table'] : ''
                , ['class' => 'form-control', 'placeholder' => 'Tên bảng']) ?>
        </div>
        <div class="col-md-2">
            <select name="<?= $meta_key . '[' . $meta_key . $id . '][provider]' ?>"
                    class="form-control select-provider" style="width: 100%">
                <?php
                if (!empty($item['provider'])) {
                    echo "<option value='" . $item['provider'] . "' selected>" . $item['provider'] . "</option>";
                }
                ?>

            </select>
        </div>
        <div class="col-md-1">
            <?= form_input($meta_key . "[" . $meta_key . $id . "][min]",
                !empty($item['min']) ? $item['min'] : 0
                , ['class' => 'form-control', 'placeholder' => 'Min dải số']) ?>
        </div>
        <div class="col-md-1">
            <?= form_input($meta_key . "[" . $meta_key . $id . "][max]",
                !empty($item['max']) ? $item['max'] : 999999
                , ['class' => 'form-control', 'placeholder' => 'Max dải số']) ?>
        </div>
    </div>
    <i class="glyphicon glyphicon-trash removeInput" onclick="removeInputImage(this)"></i>
</fieldset>