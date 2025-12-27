<?php

if (!$keyAnswer) {
  $isAnswerTrue = false;
} else {
  $isAnswerTrue = $keyAnswer ? str_contains(mb_strtolower($keyAnswer['title']), 'A') : false;
}

?>
<div class="task-detail">
  <div class="row">
    <div class="col-md-12">
      <h1 class="text-uppercase text-center txt-orange">BÁO CÁO KỸ NĂNG <br /><?= $title ?></h1>
    </div>
  </div>

  <div class="row align-items-center mt-5">
    <div class="col-md-3">
      <div class="point  <?= $colorPoint ?? 'red' ?>">
        <div class="content">
          <h4><?= $pointType ?></h4>
          <span>Điểm</span>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <?php $this->load->view($this->template_path . 'detail/point-level') ?>
    </div>
    <div class="clearfix mt-5"></div>

    <div class="col-md-8">
      <?php if ($isAnswerTrue): ?>
        <p class="txt">
          Khi thấy các đường link lạ, trẻ có xu hướng nhấn vào, điều này có thể khiến trẻ gặp phải các rủi ro
          liên quan đến mã độc, vi rút và lừa đảo trên mạng. Trẻ cần rèn luyên thêm kiến thức kỹ thuật số về
          năng lực Quản lý an ninh mạng để nắm bắt các kiến thức cần thiết giúp bảo vệ trẻ khỏi các rủi ro
          liên quan đến mã độc, vi rút và lừa đảo.
        </p>
      <?php else: ?>
        <p class="txt">
          Khi thấy các đường link lạ, trẻ không có xu hướng nhấn vào các đường link đó, điều này giúp trẻ
          tránh được các rủi ro liên quan đến mã độc, vi rút và lừa đảo trên mạng.
        </p>
      <?php endif; ?>
    </div>
    <div class="col-md-4">
    </div>
    <div class="clearfix mt-5"></div>
    <div class="col-md-12">
      <p class="title text-bold orange mb-4">khuyến nghị</p>

      <p class="txt">
        <strong>Để tránh bị lừa đảo qua mạng, cha mẹ cần thường xuyên nhắc nhỏ trẻ về việc:</strong>
      </p>
      <ul class="txt">
        <li>Không truy cập vào các đường link gắn kèm trong nội dung tin nhắn/email lạ.
        </li>
        <li>
          Không nhấn vào các thông báo, quảng cáo tự động trên mạng.
        </li>
        <li>
          Giữ bí mật, không đăng các thông tin cá nhân của chính mình và người thân
        </li>
        <li>
          Không thực hiện theo các yêu cầu từ số máy lạ gọi đến vì kẻ lừa đảo có thể giả danh là bất cứ ai để
          thực hiện hành vi lừa đảo.
        </li>
      </ul>
    </div>

  </div>
</div>