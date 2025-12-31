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
      "@context": "https:\/\/schema.org",
      "@type": "WebSite",
      "@id": "#website",
      "url": "<?= base_url() ?>",
      "name": "DQ Vietnam"
    }
  </script>
  <link rel="preconnect" href="https://cdn.jsdelivr.net">
  <link rel="preconnect" href="https://cdnjs.cloudflare.com">
  <link rel="preconnect" href="https://html2canvas.hertzen.com">
  <link rel="stylesheet" href="<?= $this->templates_assets . 'css/app.css?v=' . ASSET_VERSION ?>">
  <link rel="stylesheet" href="<?= $this->templates_assets . 'css/custom.css?v=' . ASSET_VERSION ?>">
  <link rel="stylesheet" href="<?= $this->templates_assets . 'css/report.css?v=' . ASSET_VERSION ?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script>
    var current_url = '<?= current_url() ?>',
      base_url = '<?= BASE_URL ?>',
      media_url = '<?= MEDIA_URL . '/'; ?>',
      controller = '<?= $this->_controller ?>',
      album = []
  </script>
</head>

<body>

  <button id="download_report" class="btn-fixed btn btn-01">Tải xuống báo cáo</button>
  <div id="content">
    <?= !empty($main_content) ? $main_content : ''; ?>
  </div>


  <div id="notify-rotate"><img src="public/images/rotatedevice.webp" alt="Rotate device" width="150" height="150" loading="lazy" /></div>

  <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js" defer></script>
  <script src="/public/vendor/jquery-3.3.1.min.js" defer></script>
  <script src="/public/game/list/js/chart.js" defer></script>
  <script src="/public/game/list/js/chart-label.js" defer></script>
  <script src="/public/report/js/custom.js?v=1.3" defer></script>
  <script src="/public/js/common.js" defer></script>
</body>

</html>