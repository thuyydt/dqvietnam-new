<div class="box-body">
    <?php if (!empty($list_field_normal)) foreach ($list_field_normal as $key => $item):
        $item['value'] = !empty(${$item['name']}) ? ${$item['name']} : '';
        $this->load->view($this->template_path . 'setting/items/' . $item['type'], $item);
        ?>
    <?php endforeach ?>
</div>
<?php
if (!empty($list_field_langs)):
    ?>
    <div class="box-body">
        <ul class="nav nav-tabs">
            <?php foreach ($this->config->item('cms_language') as $lang_code => $lang_name) { ?>
                <li<?php echo ($lang_code == 'vi') ? ' class="active"' : ''; ?>>
                    <a href="#<?= $target ?>_<?php echo $lang_code; ?>" data-toggle="tab">
                        <img
                                src="<?php echo $this->templates_assets; ?>/flag/<?php echo $lang_code ?>.png"> <?php echo $lang_name; ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <div class="tab-content">
            <?php foreach ($this->config->item('cms_language') as $lang_code => $lang_name): ?>
                <div class="tab-pane <?php echo ($lang_code == 'vi') ? 'active' : ''; ?>">
                    <?php foreach ($list_field_langs as $key => $item): ?>
                        <div class="form-group">
                            <label><?= $item['title'] ?></label>
                            <?php
                            $field_name = $item['name'];
                            $name = "{$field_name}[{$lang_code}]";
                            $value = !empty(${$field_name}[$lang_code]) ? ${$field_name}[$lang_code] : '';
                            switch ($item['type']) {
                                case 'form_textarea':
                                    echo form_textarea($name, $value, ['class' => 'form-control', 'placeholder' => $item['title']]);
                                    break;
                                default:
                                    echo form_input($name, $value, ['class' => 'form-control', 'placeholder' => $item['title']]);
                                    break;
                            }

                            ?>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
