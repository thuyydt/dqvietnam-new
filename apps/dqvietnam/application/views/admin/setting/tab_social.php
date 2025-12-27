<?php

$list_field_normal = [
    ['title' => 'Facebook', 'name' => 'social_facebook', 'type' => 'input_text'],
    ['title' => 'Twitter', 'name' => 'social_twitter', 'type' => 'input_text'],
    ['title' => 'Instagram', 'name' => 'social_instagram', 'type' => 'input_text'],
    ['title' => 'Youtube', 'name' => 'youtube', 'type' => 'input_text'],
    ['title' => 'Zalo', 'name' => 'zalo', 'type' => 'input_text'],
    ['title' => 'Messenger', 'name' => 'messenger', 'type' => 'input_text']
];
?>

<div class="tab-pane row " id="<?= $target ?>">
    <div class="tab-content col-md-12">
        <fieldset class="form-group album-contain">
            <legend>Mạng xã hôi</legend>
            <?php if (!empty($list_field_normal)) foreach ($list_field_normal as $key => $item) {
                $item['value'] = !empty(${$item['name']}) ? ${$item['name']} : '';
                $this->load->view($this->template_path . 'setting/items/' . $item['type'], $item);
            } ?>
        </fieldset>
    </div>
</div>
