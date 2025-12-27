<header class="c-header">
  <div class="container">
    <?= menus_main() ?>
    <div class="account">
      <a href="<?= urlRoute('register') ?>" class="btn-header" aria-label="Đăng Ký">Đăng Ký</a>
      <a href="<?= urlRoute('login') ?>" class="btn-header" aria-label="Đăng Nhập">Đăng Nhập</a>
    </div>
    <button class="btn btn-toogle btn-mobile" type="button" aria-label="Toggle navigation">
      <span class="toogle-line"></span>
      <span class="toogle-line"></span>
      <span class="toogle-line"></span>
    </button>
  </div>
</header>