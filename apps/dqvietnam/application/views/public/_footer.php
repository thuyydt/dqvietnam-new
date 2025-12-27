<div class="img-bg">
  <img src="<?= $this->templates_assets ?>images/element-03.png" loading="lazy" />
</div>
<footer class="footer">
  <div class="container">
    <div class="row inner-footer">
      <div class="col-12 col-lg-4">
        <img src="<?= $this->templates_assets ?>images/logo-01.png" loading="lazy" class="logo" />
        <div class="info">
          <p class="strong">
            <?= $this->info->get('company[name]') ?>
          </p>
          <p>
            <spans class="strong">Địa chỉ:</spans><?= $this->info->get('company[address]') ?>
          </p>
          <p>
            <span class="strong">Tel: </span> <?= $this->info->get('company[phone]') ?>
          </p>
          <p>
            <span class="strong">Email: </span> <?= $this->info->get('company[email]') ?>
          </p>
        </div>
      </div>
      <div class="col-12 col-lg-8 right-footer-menu">
        <div class="row">
          <div class="col-12 col-xl-4 col-lg-4 col-md-6">
            <h2><a href="">Trang Chủ</a></h2>
            <ul class="footer-list">
              <li class="footer-item"><a href="/dq-la-gi">DQ là gì?</a></li>
              <li class="footer-item">
                <a href="/nguoi-hung-dq">Người Hùng DQ</a>
              </li>
              <li class="footer-item">
                <a href="/nha-truong">Nhà Trường</a>
              </li>
              <li class="footer-item"><a href="/cha-me">Cha Mẹ</a></li>
            </ul>
          </div>
          <div class="col-12 col-xl-4 col-lg-4 col-md-6">
            <h2>Liên hệ hợp tác</h2>
            <ul class="footer-list">
              <li class="footer-item"><?= $this->info->get('founder[name]') ?></li>
              <li class="footer-item"><a href="tel: <?= $this->info->get('founder[phone]') ?>"
                  class="nav-link">Tel:
                  <?= $this->info->get('founder[phone]') ?> </a>
              </li>
              <li class="footer-item"><a href="mailto: <?= $this->info->get('founder[email]') ?>"
                  class="nav-link">Email: <?= $this->info->get('founder[email]') ?></a>
              </li>

            </ul>
          </div>
          <div class="col-12 col-xl-4 col-lg-4 col-md-12">
            <h2><a href="">Hỗ trợ</a></h2>
            <ul class="footer-list">
              <li class="footer-item">
                <a href="/ho-tro#study">Hướng dẫn học</a>
              </li>
              <li class="footer-item">
                <a href="/ho-tro#faq">Câu hỏi thường gặp</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="row footer-bottom">
      <div class="col-12 col-lg-2">
        <a href="/dieu-khoan-su-dung" target="_blank">
          <span class="">Điều khoản sử dụng</span>
        </a>
      </div>
      <div class="col-12 col-lg-2">
        <a href="/chinh-sach-bao-mat" target="_blank">
          <span class="">Chính sách bảo mật</span>
        </a>
      </div>

      <div class="col-12 col-lg-6">
        <div class="copyright">
          © Bản quyền của Công ty CP Truyền thông và Giáo dục Cầu Vồng
        </div>
      </div>
      <div class="col-12 col-lg-2">
        <div class="social flex-end">
          <a href="<?= $this->info->get('social[facebook]') ?>" target="_blank">
            <img src="../../../../public/images/iconfacebook.png" alt="" srcset="" loading="lazy" />
          </a>
          <a href="<?= $this->info->get('social[youtube]') ?>" target="_blank">
            <img src="../../../../public/images/iconyoutube.png" alt="" srcset="" loading="lazy" />
          </a>
          <a href="<?= $this->info->get('social[instagram]') ?>"
            target="_blank">
            <img src="../../../../public/images/iconinsta.png" alt="" srcset="" loading="lazy" />
          </a>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- End footer -->

<div class="c-slideout">
  <div class="wrapper">
    <nav class="navbar">
      <?= menus_footer('nav') ?>
    </nav>
    <div class="account">
      <a href="<?= urlRoute('register') ?>" class="btn btn-01 inversion">Đăng Ký</a>
      <a href="<?= urlRoute('login') ?>" class="btn btn-01 inversion">Đăng Nhập</a>
    </div>
  </div>
</div>
<!-- slide out -->

<button class="onTop" id="onTop">
  <img id="onTop" src="<?= $this->templates_assets ?>img/backtotop.svg" loading="lazy" />
</button>

<div class="socials">
  <a href="<?= $this->info->get('social[facebook]') ?>" target="_blank">
    <img width="42" src="<?= $this->templates_assets ?>img/mes.svg" loading="lazy" />
  </a>
  <a href="<?= $this->info->get('social[zalo]') ?>" target="_blank">
    <img width="48" src="<?= $this->templates_assets ?>img/zalo.svg" loading="lazy" />
  </a>
  <a href="<?= $this->info->get('social[youtube]') ?>" target="_blank">
    <img src="<?= $this->templates_assets ?>img/youtube.svg" loading="lazy" />
  </a>
</div>
<script>
  const toTop = document.getElementById('onTop');
  document.addEventListener("scroll", () => {
    if (window.scrollY > 400) {
      toTop.style.visibility = 'visible';
    } else {
      toTop.style.visibility = 'hidden';
    }
  });
  toTop.addEventListener('click', () => {
    window.scrollTo({
      top: 0,
      behavior: "smooth"
    });
  });
</script>