<nav class="navbar navbar-left s-nav" aria-label="Menu trái">
  <ul class="nav">
    <li class="nav-item">
      <a href="<?= BASE_URL ?>" class="nav-link" title="Trang Chủ">Trang Chủ</a>
    </li>
    <?= $right ?>
  </ul>
</nav>
<a class="navbar-brand" href="<?= BASE_URL ?>" aria-label="Trang chủ">
  <img src="public/images/logo-01.webp" alt="DQ Vietnam Logo" decoding="async" fetchpriority="high" />
</a>
<nav class="navbar navbar-right" aria-label="Menu phải">
  <ul class="nav">
    <?= $left ?>
  </ul>
</nav>