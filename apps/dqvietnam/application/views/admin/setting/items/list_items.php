<fieldset class="form-group album-contain">
    <legend for=""><?= $title ?></legend>
        <?php
        $total = 0;
        if (!empty(${$name})) {
        $module = ${$name};
        $total = getNumberics($module);
        ?>
        <div data-id="<?= $total ?>" id="<?= $name ?>">
            <?php

            foreach ($module as $key => $item) :
                $this->load->view($this->template_path . 'setting/items/_item_' . $file, ['item' => $item, 'meta_key' => $name, 'id' => preg_replace('/[^0-9]/', '', $key)]);
            endforeach;
            }else{
            ?>
            <div data-id="0" id="<?= $name ?>">
                <?php
                }
                ?>
            </div>
            <button type="button" class="btn btn-primary btnAddMore"
                    onclick='addInputElementSettings("<?= $name ?>",document.getElementById("<?= $name ?>").getAttribute("data-id"),"","<?= $file ?>",false)'>
                <i class="fa fa-plus"> Thêm</i></button>
</fieldset>
<?php
$total = 0;
$module = '';
?>