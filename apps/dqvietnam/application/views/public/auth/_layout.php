<?php
defined('BASEPATH') or exit('No direct script access allowed');
$version = time();
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
  <link rel="stylesheet" href="<?= $this->templates_assets . 'css/app.css?v=' . time() ?>">
  <link rel="stylesheet" href="<?= $this->templates_assets . 'css/main.min.css?v=' . time() ?>">
  <link rel="stylesheet" href="<?= $this->templates_assets . 'css/home.css?v=' . time() ?>">
  <script>
    var current_url = '<?= current_url() ?>',
      base_url = '<?= BASE_URL ?>',
      media_url = '<?= MEDIA_URL . '/'; ?>',
      controller = '<?= $this->_controller ?>',
      album = []
  </script>
  <?= !empty($this->settings['script_head']) ? $this->settings['script_head'] : '' ?>

  <style>
    @keyframes ldio-wdfcbcdcozs {
      0% {
        transform: translate(6px, 40px) scale(0);
      }

      25% {
        transform: translate(6px, 40px) scale(0);
      }

      50% {
        transform: translate(6px, 40px) scale(1);
      }

      75% {
        transform: translate(40px, 40px) scale(1);
      }

      100% {
        transform: translate(74px, 40px) scale(1);
      }
    }

    @keyframes ldio-wdfcbcdcozs-r {
      0% {
        transform: translate(74px, 40px) scale(1);
      }

      100% {
        transform: translate(74px, 40px) scale(0);
      }
    }

    @keyframes ldio-wdfcbcdcozs-c {
      0% {
        background: #e15b64
      }

      25% {
        background: #abbd81
      }

      50% {
        background: #f8b26a
      }

      75% {
        background: #f47e60
      }

      100% {
        background: #e15b64
      }
    }

    .ldio-wdfcbcdcozs div {
      position: absolute;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      transform: translate(40px, 40px) scale(1);
      background: #e15b64;
      animation: ldio-wdfcbcdcozs 1s infinite cubic-bezier(0, 0.5, 0.5, 1);
    }

    .ldio-wdfcbcdcozs div:nth-child(1) {
      background: #f47e60;
      transform: translate(74px, 40px) scale(1);
      animation: ldio-wdfcbcdcozs-r 0.25s infinite cubic-bezier(0, 0.5, 0.5, 1), ldio-wdfcbcdcozs-c 1s infinite step-start;
    }

    .ldio-wdfcbcdcozs div:nth-child(2) {
      animation-delay: -0.25s;
      background: #e15b64;
    }

    .ldio-wdfcbcdcozs div:nth-child(3) {
      animation-delay: -0.5s;
      background: #f47e60;
    }

    .ldio-wdfcbcdcozs div:nth-child(4) {
      animation-delay: -0.75s;
      background: #f8b26a;
    }

    .ldio-wdfcbcdcozs div:nth-child(5) {
      animation-delay: -1s;
      background: #abbd81;
    }

    .loadingio-spinner-ellipsis-mnaqrvpphi8 {
      width: 100px;
      height: 100px;
      display: none;
      overflow: hidden;
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      right: 0;
      margin: auto;
      z-index: 99;
    }

    .ldio-wdfcbcdcozs {
      width: 100%;
      height: 100%;
      position: relative;
      transform: translateZ(0) scale(1);
      backface-visibility: hidden;
      transform-origin: 0 0;
      /* see note above */
    }

    .ldio-wdfcbcdcozs div {
      box-sizing: content-box;
    }

    body.is-loading {
      position: relative;
      transition: 0.5s all;
    }

    body.is-loading:before {
      width: 100%;
      height: 100%;
      position: absolute;
      z-index: 10;
      content: '';
      top: 0;
      left: 0;
      background: rgba(0, 0, 0, 0.5);
    }
  </style>
</head>

<body>
  <div id="loading" class="loadingio-spinner-ellipsis-mnaqrvpphi8">
    <div class="ldio-wdfcbcdcozs">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>
  <div class="app">
    <?php
    $this->load->view($this->template_path . '_header');
    echo !empty($main_content) ? $main_content : '';
    $this->load->view($this->template_path . '_footer');
    ?>
  </div>

  <div id="notify-rotate">
    <img src="public/images/rotatedevice.jpg" alt="" loading="lazy" />
  </div>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="<?= $this->templates_assets . 'js/app.js?v=' . $version ?>"></script>
  <script src="<?= $this->templates_assets . 'js/version2.js?v=' . $version ?>"></script>
  <script src="<?= $this->templates_assets . 'js/custom.js?v=' . $version ?>"></script>
  <?= !empty($this->settings['embeb_js']) ? $this->settings['embeb_js'] : '' ?>
</body>

</html>