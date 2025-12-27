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

    <?php if ($type_lib == 'play') { ?>
        <link rel="stylesheet" href="<?= $this->templates_assets . 'css/app.css?v=' . time() ?>">
        <link rel="stylesheet" href="<?= $this->templates_assets . 'css/main.min.css?v=' . time() ?>">
    <?php } else { ?>
        <link rel="stylesheet" href="<?= $this->templates_assets . 'css/app.css?v=' . time() ?>">
        <link rel="stylesheet" href="<?= $this->templates_assets . 'css/main.min.css?v=' . time() ?>">
        <link rel="stylesheet" href="<?= $this->templates_assets . 'css/custom.css?v=' . time() ?>">
    <?php } ?>
    <link rel="stylesheet" href="<?= '/public/game/css/optimize.css?v=' . time() ?>">

    <script>
        var current_url = '<?= current_url() ?>',
            base_url = '<?= BASE_URL ?>',
            media_url = '<?= MEDIA_URL . '/'; ?>',
            controller = '<?= $this->_controller ?>',
            account_secret = '',
            AUTH_KEY = '<?php echo $this->auth->user_id ?>'
    </script>
</head>

<body>

<?php echo !empty($main_content) ? $main_content : ''; ?>

<!--<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>-->

<script defer src="/public/vendor/jquery-3.3.1.min.js"></script>
<script defer src="/public/vendor/toastr/toastr.js"></script>
<script defer src="/public/vendor/slick.min.js"></script>
<script defer src="/public/game/list/js/chart.js"></script>
<script defer src="/public/js/utils.js"></script>
<script defer src="/public/game/list/js/main.js?v=2.7"></script>
<script defer src="/public/js/common.js?v=<?php echo time() ?>"></script>

<?php if ($type_lib == 'play') { ?>
    <script defer src="<?= $this->templates_assets . 'js/vue.js?v=' . time() ?>"></script>
<?php } ?>

<script defer src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.1.3/axios.min.js"
        integrity="sha512-0qU9M9jfqPw6FKkPafM3gy2CBAvUWnYVOfNPDYKVuRTel1PrciTj+a9P3loJB+j0QmN2Y0JYQmkBBS8W+mbezg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script defer type="text/javascript"
        src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
<script defer type="text/javascript"
        src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>
<script defer src="/public/auth/js/version2.js?v=<?= time() ?>"></script>

<script>
    const onResetPwd = async (element) => {
        const formData = $('#form-update-password').serializeArray();
        const data = formData.reduce((obj, item) => ({...obj, [item.name]: item.value}), {});
        await CLIENT_V2.AUTH.RESET_PWD(data, element);
    }
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
<div id="notify-rotate"><img src="public/images/rotatedevice.jpg" alt="" loading="lazy"/></div>
</body>

</html>
