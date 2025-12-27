<!DOCTYPE html>
<html lang="<?= $this->lang_code ?>">

<head>
    <base href="<?= BASE_URL ?>">
    <?php $this->load->view($this->template_path . '_meta') ?>
    <script type="application/ld+json">
        {
            "@context": "http:\/\/schema.org",
            "@type": "WebSite",
            "@id": "#website",
            "url": "https:\/\/web.vn\/",
            "name": "web.vn"
        }
    </script>
    <link rel="stylesheet" href="<?= $this->templates_assets . 'css/app.css?v=' . ASSET_VERSION ?>">
    <link rel="stylesheet" href="<?= $this->templates_assets . 'css/main.min.css?v=' . ASSET_VERSION ?>">
    <link rel="stylesheet" href="<?= $this->templates_assets . 'css/optimize.css?v=' . ASSET_VERSION ?>">
    <link rel="stylesheet" href="<?= $this->templates_assets . 'css/home.css?v=' . ASSET_VERSION ?>">
    <link rel="stylesheet" href="<?= $this->templates_assets . 'css/responsive.css?v=' . ASSET_VERSION ?>">
    <script>
        var current_url = '<?= current_url() ?>',
            base_url = '<?= BASE_URL ?>',
            media_url = '<?= MEDIA_URL . '/'; ?>',
            controller = '<?= $this->_controller ?>',
            album = []
    </script>
    <?= !empty($this->settings['script_head']) ? $this->settings['script_head'] : '' ?>
</head>

<body>

<div class="app">
    <?php
    $this->load->view($this->template_path . '_header');
    echo !empty($main_content) ? $main_content : '';
    $this->load->view($this->template_path . '_footer');
    ?>
</div>

<div id="fb-root"></div>

<script src="<?= $this->templates_assets . 'js/app.js?v=' . ASSET_VERSION ?>"></script>

<?= !empty($this->settings['embeb_js']) ? $this->settings['embeb_js'] : '' ?>

</body>
</html>
