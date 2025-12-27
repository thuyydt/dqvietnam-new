<main class="c-main" id="page-register-personal">
  <div class="account-box">
    <div class="wrapper">
      <a href="<?= base_url() ?>" class="btn-exit"></a>
      <div class="col left">

        <div class="img v1"><img src="<?= $this->templates_assets ?>/images/element-08.png" loading="lazy"/></div>

      </div>
      <div class="col right" style="padding: 69px 73.5px 25px 73.5px;">

        <div class="form-block">
          <h1 class="heading">Đăng Ký Cá Nhân</h1>

          <form class="form" id="form-register-personal" style="margin-top: 40px;">
            <div class="form-group spacing-10">
              <input name="full_name" type="text" class="form-control input-account" placeholder="Họ và tên">
              <!-- <div class="form-text">Thông báo lỗi</div> -->
            </div>
            <div class="form-group spacing-10">
              <input name="username" type="text" class="form-control input-email" placeholder="Email (Cha/Me) ">
              <!-- <div class="form-text">Thông báo lỗi</div> -->
            </div>
              <div class="form-group spacing-10">
                  <input name="phone" type="text" class="form-control input-account" placeholder="Số điện thoại">
                  <!-- <div class="form-text">Thông báo lỗi</div> -->
              </div>
            <div class="form-group spacing-10">
              <input name="birthday" type="date" class="form-control input-date" placeholder="Ngày sinh">
              <!-- <div class="form-text">Thông báo lỗi</div> -->
            </div>
            <div class="form-group spacing-10 group-password">
              <input name="password" type="password" class="form-control input-password" placeholder="Mật khẩu">
              <!-- <div class="form-text">Thông báo lỗi</div> -->
            </div>
            <div class="form-group spacing-10 group-re-password">
              <input name="re_password" type="password" class="form-control input-password"
                placeholder="Nhập lại mật khẩu">
              <!-- <div class="form-text">Thông báo lỗi</div> -->
            </div>
            <button type="button" onclick="onRegister(this)" class="btn">ĐĂNG KÝ</button>
            <div class="what">Bạn đã có tài khoản? <a href="<?= urlRoute('login') ?>">Đăng nhập</a></div>
          </form>

        </div>

      </div>
    </div>
  </div>

</main>
<!-- end Main -->
