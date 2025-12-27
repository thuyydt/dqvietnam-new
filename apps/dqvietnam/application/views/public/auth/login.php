<main class="c-main" id="page-login">
  <div class="account-box">
    <div class="wrapper">
      <a href="<?= base_url() ?>" class="btn-exit"></a>
      <div class="col left">

        <div class="img"><img src="<?= $this->templates_assets ?>images/element-05.png"></div>

      </div>
      <div class="col right">

        <div class="form-block">
          <h1 class="heading">Đăng nhập</h1>

          <form class="form" id="form-login">
            <div class="form-group">
              <input name="username" type="text" class="form-control input-account"
                placeholder="Email hoặc Tên đăng nhập">
              <!-- <div class="form-text">Thông báo lỗi</div> -->
            </div>
            <div class="form-group spacing-25 group-password">
              <input name="password" type="password" class="form-control input-password" placeholder="Mật khẩu">
              <!-- <div class="form-text">Thông báo lỗi</div> -->
            </div>
            <div class="form-group form-check">
              <div class="form-box">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Nhớ mật khẩu</label>
              </div>
              <a href="<?= urlRoute('forgot-password') ?>" class="link">Quên mật khẩu?</a>
            </div>
            <button type="submit" class="btn">ĐĂNG NHẬP</button>
            <div class="what">Bạn không có tài khoản? <a href="<?= urlRoute('register') ?>">Đăng ký</a>
            </div>
          </form>

        </div>

      </div>
    </div>
  </div>

</main>
<!-- end Main -->
