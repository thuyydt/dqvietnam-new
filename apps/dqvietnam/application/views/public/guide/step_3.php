<div class="app" style="background-image: url(<?= $this->templates_assets ?>images/bg-main.webp);">
  <img class="bg-content" src="<?= $this->templates_assets ?>images/bg-02.webp" alt="Hướng dẫn bước 3" fetchpriority="high" />
  <div class="btn-box">
    <a href="<?= urlRoute('guide/step-') . ($step - 1) ?>" class="btn" title="Trở lại" aria-label="Trở lại">TRỞ LẠI</a>
    <a href="<?= urlRoute('guide/step-') . ($step + 1) ?>" class="btn" title="Tiếp tục" aria-label="Tiếp tục">TIẾP TỤC</a>
  </div>

</div>