<?php
$isAnswerTrue = $keyAnswer ? str_contains(mb_strtolower($keyAnswer['title']), 'đã từng') : false;
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
          Trẻ đã từng công khai các thông tin cá nhân lên mạng xã hội. Điều này có thể gây ra những rủi ro vì
          kẻ xấu có thể thu thập và sử dụng chúng. Cha mẹ cần nói với trẻ không nên đăng những thông tin cá
          nhân như ngày sinh, địa chỉ nhà, số điện thoại, mật khẩu…. lên mạng hoặc trong trường hợp trẻ đã
          đăng rồi thì cần gỡ bỏ chúng ngay lập tức.
        </p>
      <?php else: ?>
        <p class="txt">
          Trẻ không công khai các thông tin cá nhân quan trọng của mình lên mạng xã hội. Điều này rất tốt vì
          trẻ đã biết quản lý các thông tin cá nhân của mình, những kẻ xấu sẽ không thể thu thập các thông tin
          cá nhân của trẻ để thực hiện hành vi xấu.
        </p>
      <?php endif; ?>
    </div>
    <div class="col-md-4">
    </div>
    <div class="clearfix mt-5"></div>
    <div class="col-12">
      <h3 class="title text-bold orange mb-4">khuyến nghị</h3>

    </div>
    <div class="col-md-6">
      <p class="txt">
        Cha mẹ cần thường xuyên trò chuyện với trẻ về các hoạt động khi trực tuyến, nhắc nhở trẻ về việc bảo mật
        thông tin cá nhân của bản thân cũng như của các thành viên trong gia đình khi tham gia trực tuyến để
        tránh kẻ xấu lợi dụng, thu thập và rao bán thông tin cá nhân của trẻ
      </p>
    </div>
    <div class="col-md-6">
      <p class="txt">
        <strong>Các thông tin cần tránh tiết lộ trên mạng bao gồm</strong>: <br />
        Đia chỉ nhà – Địa chỉ trường – Ngày sinh - Số điện thoại – Số căn cước công dân (của cha mẹ) – Số tài
        khoản ngân hàng (của cha mẹ) – Mật khẩu – Email – Nghề nghiệp, chức danh (của cha mẹ)
      </p>
    </div>
  </div>
</div>