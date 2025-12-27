<div class="tab-pane " id="<?= $target ?>">
    <?php
    $this->load->view($this->template_path . 'setting/items/list_items',
        ['title' => "Danh sách thiết bị", 'name' => 'devices', 'file' => 'device']
    );
    ?>
</div>
