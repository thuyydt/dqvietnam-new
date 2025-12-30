<?php
defined('BASEPATH') or exit('No direct script access allowed');
$version = "3.9";
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
  <link rel="stylesheet" href="<?= $this->templates_assets . 'css/app.css?v=' . $version ?>">
  <link rel="stylesheet" href="<?= $this->templates_assets . 'css/custom.css?v=' . $version ?>">
  <link rel="stylesheet" href="<?= $this->templates_assets . 'css/report.css?v=' . $version ?>">
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


  <div id="notify-rotate"><img src="public/images/rotatedevice.webp" alt="" loading="lazy" /></div>

  <script src="http://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
  <script src="/public/vendor/jquery-3.3.1.min.js"></script>
  <script src="/public/game/list/js/chart.js"></script>
  <script src="/public/game/list/js/chart-label.js"></script>
  <script src="/public/report/js/custom.js?v=1.3"></script>
  <script src="/public/js/common.js"></script>
</body>

</html>