<div class="info-user confirm_reset" style="display: none">
  <?php if (!empty($this->auth)) : ?>
    <div class="info-user__wrapper v1" style="height: 100%;">
      <div class="heading">Khi bạn xác nhận điều này, dữ liệu lịch sử chơi và điểm số của bạn sẽ bị mất</div>
      <div style="display: block; width: 100%;">
        <a href="javascipt:;" id="resetAccount" class="btn btn-login-info">Xác nhận</a>
      </div>
    </div>
  <?php else: ?>
    <div class="info-user__wrapper v1" style="height: 100%;">
      <div class="heading">BẠN HÃY ĐĂNG NHẬP ĐỄ TIẾP TỤC!</div>
      <div style="display: block; width: 100%;">
        <a href="<?= urlRoute('login?redirect=' . current_url()) ?>" class="btn btn-login-info">Đi đến trang
          Đăng Nhập</a>
      </div>
    </div>
  <?php endif; ?>
</div>