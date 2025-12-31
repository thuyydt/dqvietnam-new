<div class="img-bg" aria-hidden="true">
  <img src="<?= $this->templates_assets ?>images/element-03.webp" alt="" loading="lazy" decoding="async" />
</div>
<footer class="footer">
  <div class="container">
    <div class="row inner-footer">
      <div class="col-12 col-lg-4">
        <img src="<?= $this->templates_assets ?>images/logo-01.webp" alt="DQ Vietnam Logo" loading="lazy" decoding="async" class="logo" />
        <div class="info" itemscope itemtype="http://schema.org/Organization">
          <p class="strong" itemprop="name">
            <?= $this->info->get('company[name]') ?>
          </p>
          <p itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
            <span class="strong">Địa chỉ:</span><span itemprop="streetAddress"><?= $this->info->get('company[address]') ?></span>
          </p>
          <p>
            <span class="strong">Tel: </span> <span itemprop="telephone"><?= $this->info->get('company[phone]') ?></span>
          </p>
          <p>
            <span class="strong">Email: </span> <span itemprop="email"><?= $this->info->get('company[email]') ?></span>
          </p>
        </div>
      </div>
      <div class="col-12 col-lg-8 right-footer-menu">
        <div class="row">
          <div class="col-12 col-xl-4 col-lg-4 col-md-6">
            <h3>
              <a href="<?= base_url() ?>" title="Trang Chủ" aria-label="Trang Chủ">Trang Chủ</a>
            </h3>
            <ul class="footer-list">
              <li class="footer-item">
                <a href="/dq-la-gi" title="DQ là gì?" aria-label="DQ là gì?">DQ là gì?</a>
              <li class="footer-item">
                <a href="/nguoi-hung-dq" title="Người Hùng DQ" aria-label="Người Hùng DQ">Người Hùng DQ</a>
              </li>
              <li class="footer-item">
                <a href="/nguoi-hung-dq" title="Người Hùng DQ" aria-label="Người Hùng DQ">Người Hùng DQ</a>
              </li>
              <li class="footer-item">
                <a href="/nha-truong" title="Nhà Trường" aria-label="Nhà Trường">Nhà Trường</a>
              </li>
              <li class="footer-item">
                <a href="/cha-me" title="Cha Mẹ" aria-label="Cha Mẹ">Cha Mẹ</a>
              </li>
            </ul>
          </div>
          <div class="col-12 col-xl-4 col-lg-4 col-md-6">
            <h3>Liên hệ hợp tác</h3>
            <ul class="footer-list">
              <li class="footer-item"><?= $this->info->get('founder[name]') ?></li>
              <li class="footer-item">
                <a href="tel: <?= $this->info->get('founder[phone]') ?>" class="nav-link" title="Tel: <?= $this->info->get('founder[phone]') ?>" aria-label="Tel: <?= $this->info->get('founder[phone]') ?>">
                  Tel: <?= $this->info->get('founder[phone]') ?> </a>
              </li>
              <li class="footer-item">
                <a href="mailto: <?= $this->info->get('founder[email]') ?>" class="nav-link" title="Email: <?= $this->info->get('founder[email]') ?>" aria-label="Email: <?= $this->info->get('founder[email]') ?>">
                  Email: <?= $this->info->get('founder[email]') ?>
                </a>
              </li>
            </ul>
          </div>
          <div class="col-12 col-xl-4 col-lg-4 col-md-12">
            <h3>
              <a href="/ho-tro" title="Hỗ trợ" aria-label="Hỗ trợ">Hỗ trợ</a>
            </h3>
            <ul class="footer-list">
              <li class="footer-item">
                <a href="/ho-tro#study" title="Hướng dẫn học" aria-label="Hướng dẫn học">Hướng dẫn học</a>
              </li>
              <li class="footer-item">
                <a href="/ho-tro#faq" title="Câu hỏi thường gặp" aria-label="Câu hỏi thường gặp">Câu hỏi thường gặp</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="row footer-bottom">
      <div class="col-12 col-lg-2">
        <a href="/dieu-khoan-su-dung" target="_blank" rel="noopener noreferrer" title="Điều khoản sử dụng" aria-label="Điều khoản sử dụng">
          <span class="">Điều khoản sử dụng</span>
        </a>
      </div>
      <div class="col-12 col-lg-2">
        <a href="/chinh-sach-bao-mat" target="_blank" rel="noopener noreferrer" title="Chính sách bảo mật" aria-label="Chính sách bảo mật">
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
          <a href="<?= $this->info->get('social[facebook]') ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
            <img src="<?= $this->templates_assets ?>images/iconfacebook.webp" alt="Facebook" loading="lazy" decoding="async" />
          </a>
          <a href="<?= $this->info->get('social[youtube]') ?>" target="_blank" rel="noopener noreferrer" aria-label="Youtube">
            <img src="<?= $this->templates_assets ?>images/iconyoutube.webp" alt="Youtube" loading="lazy" decoding="async" />
          </a>
          <a href="<?= $this->info->get('social[instagram]') ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
            <img src="<?= $this->templates_assets ?>images/iconinsta.webp" alt="Instagram" loading="lazy" decoding="async" />
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
      <a href="<?= urlRoute('register') ?>" class="btn btn-01 inversion" title="Đăng ký tài khoản" aria-label="Đăng ký tài khoản">Đăng Ký</a>
      <a href="<?= urlRoute('login') ?>" class="btn btn-01 inversion" title="Đăng nhập tài khoản" aria-label="Đăng nhập tài khoản">Đăng Nhập</a>
    </div>
  </div>
</div>
<!-- slide out -->

<button class="onTop" id="onTop">
  <img id="onTop" src="<?= $this->templates_assets ?>img/backtotop.svg" loading="lazy" alt="Back to top" />
</button>

<div class="socials">
  <a href="<?= $this->info->get('social[facebook]') ?>" target="_blank">
    <img width="42" src="<?= $this->templates_assets ?>img/mes.svg" loading="lazy" alt="Facebook" />
  </a>
  <a href="<?= $this->info->get('social[zalo]') ?>" target="_blank">
    <img width="48" src="<?= $this->templates_assets ?>img/zalo.svg" loading="lazy" alt="Zalo" />
  </a>
  <a href="<?= $this->info->get('social[youtube]') ?>" target="_blank">
    <img src="<?= $this->templates_assets ?>img/youtube.svg" loading="lazy" alt="YouTube" />
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