<?php
defined('BASEPATH') or exit('No direct script access allowed');
$version = "3.8";
?>
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
    <link rel="stylesheet" href="<?= $this->templates_assets . 'css/main.min.css?v=' . time() ?>">
    <link rel="stylesheet" href="<?= $this->templates_assets . 'css/app.css?v=' . time() ?>">
    <script>
        var current_url = '<?= current_url() ?>',
            base_url = '<?= BASE_URL ?>',
            media_url = '<?= MEDIA_URL . '/'; ?>',
            controller = '<?= $this->_controller ?>',
            account_secret = '',
            AUTH_KEY = '<?php echo $this->auth->user_id ?>'
    </script>
    <?= !empty($this->settings['script_head']) ? $this->settings['script_head'] : '' ?>
</head>

<body>

<?php echo !empty($main_content) ? $main_content : ''; ?>

<div id="notify-rotate"><img src="public/images/rotatedevice.jpg" alt=""></div>

<script src="<?= $this->templates_assets . 'js/app.js?v=' . time() ?>"></script>
<script src="<?= $this->templates_assets . 'js/vue.js?v=' . time() ?>"></script>
<?= !empty($this->settings['embeb_js']) ? $this->settings['embeb_js'] : '' ?>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.1.3/axios.min.js"
        integrity="sha512-0qU9M9jfqPw6FKkPafM3gy2CBAvUWnYVOfNPDYKVuRTel1PrciTj+a9P3loJB+j0QmN2Y0JYQmkBBS8W+mbezg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script defer src="/public/auth/js/version2.js?v=<?= time() ?>"></script>
<script>
    let heartbeatInterval = null;
    document.addEventListener('DOMContentLoaded', function () {
        heartbeatInterval = setInterval(CLIENT_V2.AUTH.PING, 15000);
    })
    window.addEventListener('beforeunload', function (event) {
        clearInterval(heartbeatInterval);
    });
    window.addEventListener('unload', function (event) {
        clearInterval(heartbeatInterval);
    });
</script>
</body>

</html>
