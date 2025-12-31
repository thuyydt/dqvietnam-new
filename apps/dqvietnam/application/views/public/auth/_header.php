<header class="c-header">
  <div class="block">
    <a class="navbar-brand" href="<?= urlRoute() ?>" aria-label="Trang chủ">
      <img src="<?= $this->templates_assets ?>/images/logo-01.webp" alt="DQ Vietnam Logo" fetchpriority="high" />
    </a>
    <div class="account">
      <a href="<?= urlRoute('register') ?>" class="btn-header" aria-label="Đăng Ký" rel="nofollow">Đăng Ký</a>
      <a href="<?= urlRoute('login') ?>" class="btn-header" aria-label="Đăng Nhập" rel="nofollow">Đăng Nhập</a>
    </div>
  </div>
</header>
<style>
  .btn-header {
    padding: 11px 26px;
    font-size: 18px;
    font-weight: 900;
    color: #fe3b35;
    border: 1px solid #fe3b35;
    background-color: #fff;
    min-width: 78px;
    border-radius: 10px;
    margin: 0 12px;
    text-decoration: none;
    cursor: pointer;
    text-shadow: 2px 2px 2px rgba(110, 110, 159, 0.1);
    box-shadow: 2px 2px 2px rgba(110, 110, 159, 0.1);
    transition: all 0.5s ease;
    z-index: 1000;
  }

  .btn-header:hover,
  .btn-header:active {
    color: #fff;
    background-color: #fe3b35;
  }
</style>
<!-- End header -->