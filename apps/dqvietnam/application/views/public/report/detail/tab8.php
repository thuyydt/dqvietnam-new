<?php
$isAnswerTrue = $keyAnswer ?  str_contains(mb_strtolower($keyAnswer['title']), 'A') : false;
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
    <div class="col-md-12">
      <p class="title text-bold mb-4">Thời gian sử dụng màn hình điện tử của trẻ là: <?= $answer ?? '....' ?></p>
    </div>
    <div class="col-md-8">
      <?php if ($isAnswerTrue): ?>
        <p class="txt">
          Khi tham gia vào môi trường mạng, trẻ không có thói quen chế giễu hay nói xấu người khác. Thay vào
          đó, trẻ đã biết cách ứng xử phù hợp, suy nghĩ cho cảm xúc của người khác trước khi bình luận về một
          vấn đề. Nhờ vậy, trẻ xây dựng được các mối quan hệ lành mạnh.
        </p>
      <?php else: ?>
        <p class="txt">
          Khi tham gia vào môi trường mạng, trẻ có xu hướng thích chế giễu, nói xấu người khác trên mạng. Điều
          này có thể khiến trẻ vướng vào các cuộc tranh chấp, ẩu đả không đáng có.
        </p>
      <?php endif; ?>
    </div>
    <div class="col-md-4">
    </div>
    <div class="clearfix mt-5"></div>
    <div class="col-md-6">
      <h3 class="title text-bold orange mb-4">khuyến nghị</h3>

      <p class="txt">
        Cha mẹ cần thường xuyên trò chuyện với trẻ, khuyến khích trẻ thực hành các kiến thức về cảm thông kỹ
        thuật số để trẻ biết cách chia sẻ cảm xúc và ứng xử phù hợp khi trên mạng.
      </p>
    </div>
    <div class="col-md-6">

    </div>
  </div>
</div>