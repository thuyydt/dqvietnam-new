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
    <link rel="stylesheet" href="<?= $this->templates_assets . 'css/app.css?v=' . time() ?>">
    <link rel="stylesheet" href="<?= $this->templates_assets . 'css/main.min.css?v=' . time() ?>">
    <link rel="stylesheet" href="<?= $this->templates_assets . 'css/optimize.css?v=' . time() ?>">
    <link rel="stylesheet" href="<?= $this->templates_assets . 'css/home.css?v=' . time() ?>">
    <link rel="stylesheet" href="<?= $this->templates_assets . 'css/responsive.css?v=' . time() ?>">
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

<script defer src="<?= $this->templates_assets . 'js/app.js?v=' . time() ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script defer type="text/javascript"
        src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
<script defer type="text/javascript"
        src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>

<?= !empty($this->settings['embeb_js']) ? $this->settings['embeb_js'] : '' ?>

</body>
<script>
    $(function () {
        $('.lazy').Lazy();
    });
</script>
</html>
