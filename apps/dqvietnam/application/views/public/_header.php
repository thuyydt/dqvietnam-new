<header class="c-header" role="banner" itemscope itemtype="http://schema.org/WPHeader">
  <div class="container">
    <?= menus_main() ?>
    <div class="account">
      <a href="<?= urlRoute('register') ?>" class="btn-header" aria-label="Đăng Ký" rel="nofollow">Đăng Ký</a>
      <a href="<?= urlRoute('login') ?>" class="btn-header" aria-label="Đăng Nhập" rel="nofollow">Đăng Nhập</a>
    </div>
    <button class="btn btn-toogle btn-mobile" type="button" aria-label="Toggle navigation" aria-expanded="false">
      <span class="toogle-line"></span>
      <span class="toogle-line"></span>
      <span class="toogle-line"></span>
    </button>
  </div>
</header>