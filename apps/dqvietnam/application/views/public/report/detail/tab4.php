<?php
$isAnswerTrue = $keyAnswer ? str_contains(mb_strtolower($keyAnswer['title']), 'Có') : false;
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
          Trẻ có xu hướng sống ảo trên mạng xã hội. Điều đó có thể khiến trẻ bỏ quên những hoạt động trong
          cuộc sống thực, lãng phí quá nhiều thời gian vào mạng xã hội và dễ tiếp cận với các thông tin không
          lành mạnh.
        </p>
      <?php else: ?>
        <p class="txt">
          Trẻ đã biết cách kiểm soát bản thân để không mải mê sống ảo trên mạng xã hội. Đó là điều tuyệt vời,
          cha mẹ cần khuyến khích để trẻ tiếp tục thực hiện.
        </p>
      <?php endif; ?>
    </div>
    <div class="col-md-4">
    </div>
    <div class="clearfix mt-5"></div>
    <div class="col-md-12">
      <p class="title text-bold orange mb-4">khuyến nghị</p>

      <p class="txt">
        <strong>Các hoạt động cha mẹ cần làm với trẻ:</strong>
      </p>
      <ul class="txt">
        <li>Thường xuyên trò chuyện, lắng nghe suy nghĩ của trẻ đặc biệt là các hoạt động trẻ thích làm khi lên
          mạng
        </li>
        <li>
          Dành thời gian chơi đùa cùng với trẻ, giúp trẻ hiểu được ý nghĩa của cuộc sống thật và những người
          quan trọng ngoài đời thật
        </li>
        <li>
          Khi trẻ gặp vấn đề trên mạng, cha mẹ đừng vội vã trách móc trẻ mà hãy lắng nghe trẻ và tìm hiểu vấn
          đề để hỗ trợ cho trẻ.
        </li>
      </ul>
    </div>

  </div>
</div>