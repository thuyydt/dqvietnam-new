<div class="tong-ket" style="position: unset; margin: 0 auto">
  <div class="container-tk">
    <div class="tab-content">
      <a href="/report" class="btn btn-primary">Trở về trước</a>
      <div class="container">
        <?php
        $this->load->view(
          $this->template_path . "/detail/tab" . $type,
          [
            'title' => $title,
            'pointType' => $point_type[$type] ?? 0,
            'keyAnswer' => $answers[$type] ?? '',
            'colorPoint' => $colorPoint
          ]
        )
        ?>
      </div>
    </div>
  </div>