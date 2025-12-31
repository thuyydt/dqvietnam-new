<?php
defined('BASEPATH') or exit('No direct script access allowed');
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
      "url": "<?= base_url() ?>",
      "name": "DQ Vietnam"
    }
  </script>

  <?php if ($type_lib == 'play') { ?>
    <link rel="stylesheet" href="<?= $this->templates_assets . 'css/app.css?v=' . ASSET_VERSION ?>">
    <link rel="stylesheet" href="<?= $this->templates_assets . 'css/main.min.css?v=' . ASSET_VERSION ?>">
  <?php } else { ?>
    <link rel="stylesheet" href="<?= $this->templates_assets . 'css/app.css?v=' . ASSET_VERSION ?>">
    <link rel="stylesheet" href="<?= $this->templates_assets . 'css/main.min.css?v=' . ASSET_VERSION ?>">
    <link rel="stylesheet" href="<?= $this->templates_assets . 'css/custom.css?v=' . ASSET_VERSION ?>">
  <?php } ?>
  <link rel="preload" as="image" href="public/game/images/bg-01.webp">
  <link rel="stylesheet" href="<?= '/public/game/css/optimize.css?v=' . ASSET_VERSION ?>">
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

  <script defer src="/public/vendor/jquery-3.3.1.min.js"></script>
  <script defer src="/public/vendor/toastr/toastr.js"></script>
  <script defer src="/public/vendor/slick.min.js"></script>
  <script defer src="/public/game/list/js/chart.js"></script>
  <script defer src="/public/js/utils.js"></script>
  <script defer src="/public/game/list/js/main.js?v=<?= ASSET_VERSION ?>"></script>
  <script defer src="/public/js/common.js?v=<?php echo ASSET_VERSION ?>"></script>
  <?php if ($type_lib == 'play') { ?>
    <script defer src="<?= $this->templates_assets . 'js/vue.js?v=' . ASSET_VERSION ?>"></script>
  <?php } ?>
  <script defer src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script defer src="/public/auth/js/version2.js?v=<?= ASSET_VERSION ?>"></script>
  <script>
    const onResetPwd = async (element) => {
      const formData = $('#form-update-password').serializeArray();
      const data = formData.reduce((obj, item) => ({
        ...obj,
        [item.name]: item.value
      }), {});
      await CLIENT_V2.AUTH.RESET_PWD(data, element);
    }
    let heartbeatInterval = null;
    document.addEventListener('DOMContentLoaded', function() {
      heartbeatInterval = setInterval(CLIENT_V2.AUTH.PING, 15000);
    })
    window.addEventListener('beforeunload', function(event) {
      clearInterval(heartbeatInterval);
    });
    window.addEventListener('unload', function(event) {
      clearInterval(heartbeatInterval);
    });
  </script>
  <div id="notify-rotate">
    <img src="public/images/rotatedevice.webp" alt="Vui lòng xoay thiết bị" loading="lazy" decoding="async" />
  </div>
</body>

</html>