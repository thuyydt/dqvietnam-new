<main class="c-main" id="page-register-schools">
  <div class="account-box">
    <div class="wrapper">
      <a href="<?= base_url() ?>" class="btn-exit"></a>
      <div class="col left">

        <div class="img v1"><img src="<?= $this->templates_assets ?>/images/element-08.png" loading="lazy"/></div>

      </div>
      <div class="col right">

        <div class="form-block">
          <h1 class="heading">Đăng Ký Trường Học</h1>

          <form class="form spacing-25" id="form-register-schools">
            <div class="form-group">
              <input name="name" type="text" class="form-control input-school" placeholder="Tên trường học">
              <!-- <div class="form-text">Thông báo lỗi</div> -->
            </div>
            <div class="form-group spacing-25">
              <input name="email" type="text" class="form-control input-account" placeholder="Email">
              <!-- <div class="form-text">Thông báo lỗi</div> -->
            </div>
            <div class="form-group spacing-25">
              <input name="phone" type="text" class="form-control input-account" placeholder="Số điện thoại">
              <!-- <div class="form-text">Thông báo lỗi</div> -->
            </div>
            <button type="submit" class="btn">ĐĂNG KÝ</button>
            <div class="what">Bạn đã có tài khoản? <a href="<?= urlRoute('login') ?>">Đăng nhập</a></div>
          </form>

        </div>

      </div>
    </div>
  </div>

</main>
<!-- end Main -->
