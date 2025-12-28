<!DOCTYPE html>
<html lang="en">
<head>
  <title>Báo cáo</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?= base_url('public/favicon.ico') ?>" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
    integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="/public/admin/css/report.css?v=<?php echo time() ?>" rel="stylesheet">
</head>

<body>
  <?php

  $tabs = [
    [
      'name' => 'Tổng quan',
      'key' => 'overview',
    ],
    [
      'name' => 'Quản lý thời gian tiếp xúc màn hình',
      'key' => '1',
    ],
    [
      'name' => 'Quản lý bắt nạt trên mạng',
      'key' => '2',
    ],
    [
      'name' => 'Quản lý quyền riêng tư',
      'key' => '3',
    ],
    [
      'name' => 'Danh tính công dân kỹ thuật số',
      'key' => '4',
    ],
    [
      'name' => 'Quản lý an ninh mạng',
      'key' => '5',
    ],
    [
      'name' => 'Quản lý dấu chân kỹ thuật số',
      'key' => '6',
    ],
    [
      'name' => 'Cảm thông kỹ thuật số',
      'key' => '7',
    ],
    [
      'name' => 'Tư duy phản biện',
      'key' => '8',
    ],
  ];
  ?>
  <main>
    <header>
      <div class="container">
        <div class="d-flex justify-content-between">
          <div class="info">
            <h2>BÁO CÁO TỔNG QUAN DQ</h2>
            <div class="d-flex mt-2 justify-content-sm-between">
              <p>Họ tên: <?= $info->full_name ?></p>
              <p style="margin-left: 30px">Email: <?= $info->username ?></p>
            </div>
          </div>
          <div class="d-flex flex-column align-items-center">
            <img width="250" src="/public/admin/img/report/logo.png" alt="logo" loading="lazy" />
            <button class="btn mt-3 btn-download btn-default">Tải xuống <i class="fa fa-download"></i></button>
          </div>
        </div>
      </div>
    </header>

    <div class="main" id="app">

      <div class="sidebar">


        <div class="nav tabs nav-tabs" id="nav-tab" role="tablist">
          <?php
          foreach ($tabs as $key => $tab) {
            $keyExists = true; // $answers[$tab['key']] ?? false;
            if ($keyExists || $tab['key'] === 'overview'):
          ?>
              <button class="tab-item btn w-100 <?= $key == 0 ? 'active' : '' ?>"
                id="nav_<?= $tab['key'] ?>"
                data-bs-toggle="tab"
                data-bs-target="#tab_<?= $tab['key'] ?>"
                type="button" role="tab"
                aria-controls="nav-home"
                aria-selected="true">
                <?= $tab['name'] ?>
              </button>
          <?php endif;
          } ?>

        </div>
      </div>

      <div class="tab-content" id="nav-tabContent">
        <?php foreach ($tabs as $key => $tab): ?>
          <div class="tab-pane fade <?= $key == 0 ? 'show active' : '' ?>"
            id="tab_<?= $tab['key'] ?>" role="tabpanel"
            aria-labelledby="nav_<?= $tab['key'] ?>">
            <div class="container">
              <?php $this->load->view(
                $this->template_path . "account/report/tab" . $tab['key'],
                [
                  'title' => $tab['name'],
                  'pointType' => $point_type[$tab['key']] ?? 0,
                  'keyAnswer' => $answers[$tab['key']] ?? ''
                ]
              ) ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    </div>
  </main>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
    integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

  <script>
    var marksCanvas = document.getElementById("rada");

    Chart.defaults.font.family = "Lato";
    Chart.defaults.font.size = 16;
    Chart.defaults.color = "black";
    const marksData = {
      labels: [
        ["Quản lý thời gian", "tiếp xúc màn hình"],
        ["Quản lý bắt nạt", "trên mạng"],
        ["Quản lý quyền", "riêng tư"],
        ["Danh tính công dân", "kỹ thuật số"],
        ["Quản lý an ninh mạng"],
        ["Quản lý dấu chân", "kỹ thuật số"],
        ["Tư duy phản biện"],
        ["Cảm thông kỹ thuật số"],
      ],

      datasets: [{
          label: "Cấp độ DQ của trẻ",
          data: [65, 70, 90, 70, 90, 55, 70, 90],
          fill: true,
          pointBorderColor: "#fff",
          pointHoverBackgroundColor: "#fff",
          pointHoverBorderColor: "rgb(255, 99, 132)",
          backgroundColor: "rgba(255,255,255,0.17)",
          borderColor: "rgba(255,255,255,0.83)",
          pointBackgroundColor: "#fff",
          borderWidth: 3,
          hoverRadius: 4,
        },
        {
          label: "Cảnh báo",
          backgroundColor: "rgba(238, 70, 70, 1)",
          pointRadius: 0,
          borderWidth: 0,
          lineTension: 0.3,
          data: [40, 40, 40, 40, 40, 40, 40, 40],
        },
        {
          label: "Trung bình",
          backgroundColor: "rgba(244, 119, 62, 1)",
          pointRadius: 0,
          borderWidth: 0,
          lineTension: 0.3,
          data: [60, 60, 60, 60, 60, 60, 60, 60],
        },
        {
          label: "Khá",
          backgroundColor: "rgba(247, 209, 85, 1)",
          pointRadius: 0,
          borderWidth: 0,
          lineTension: 0.3,
          data: [80, 80, 80, 80, 80, 80, 80, 80],
        },
        {
          label: "Tốt",
          backgroundColor: "rgba(71, 124, 230, 1)",
          pointRadius: 0,
          borderWidth: 0,
          lineTension: 0.3,
          data: [100, 100, 100, 100, 100, 100, 100, 100],
        },
      ],

    };

    var chartOptions = {
      plugins: {
        title: {
          display: false,
        },
        legend: {
          display: false,
        },
      },
      scales: {
        r: {
          min: 0,
          max: 110,
          stepSize: 25,
          beginAtZero: true,
          grid: {
            display: true,
            circular: true,
            color: "transparent",
          },
          ticks: {
            display: false,
            stepSize: 30,
          },
          textStrokeColor: "rgb(54, 162, 235)",
          color: "rgba(240, 240, 240, 0.5)",
          backdropColor: "rgb(47, 56, 62)",
          angleLines: {
            backgroundColor: "rgb(255,255,255)",
          },
          pointLabels: {
            color: ["#4764af"],
            font: {
              size: 18,
              family: '"Helvetica 65 Medium", sans-serif',
              weight: 300,
            },
          },
        },
      },
    };

    var radarChart = new Chart(marksCanvas, {
      type: "radar",
      data: marksData,
      options: chartOptions,
    });
  </script>
</body>

</html>