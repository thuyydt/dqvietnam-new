<img src="<?= $this->templates_assets ?>/images/element-06.webp" class="element-bg element-bg-01" alt="" loading="lazy" decoding="async" />
<img src="<?= $this->templates_assets ?>/images/element-07.webp" class="element-bg element-bg-02" alt="" loading="lazy" decoding="async" />

<main class="c-main v1" role="main">

  <?php

  $url = [
    urlRoute('register-personal'),
    urlRoute('register-school')
  ];

  if (!empty($packages)) foreach ($packages as $key => $item) { ?>
    <div class="class-account class-account-0<?= $key + 1 ?>">
      <div class="wrapper">
        <div class="heading">
          <h2 class="title"><?= $item->name ?></h2>
          <div class="price">
            <div class="sale"><?= $item->is_contact ? 'Liên hệ' : '' ?></div>
            <?php if (!empty($item->price_old)) { ?> <div class="sell"><?= number_format($item->price_old) ?>đ</div>
            <?php } ?>
          </div>
        </div>
        <div class="info">
          <?= $item->detail ?>
        </div>
        <a href="<?= $url[$key] ?>" class="btn" title="Đăng ký <?= $item->name ?>">Đăng ký</a>
      </div>
    </div>
  <?php } ?>

</main>

<!-- end Main -->