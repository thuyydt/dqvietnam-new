<div class="app" style="background-image: url(<?= $this->templates_assets ?>images/bg-main.webp);">
  <div class="media">
    <div class="media-wrapper">
      <video controls autoplay muted playsinline controlsList="nodownload" preload="auto">
        <source src="<?= $this->templates_assets ?>videos/video.mp4" type="video/mp4" />
      </video>
    </div>
  </div>
  <div class="btn-box">
    <a href="<?= urlRoute('guide/step') ?>" class="btn" title="Tiếp tục" aria-label="Tiếp tục">TIẾP TỤC</a>
  </div>
</div>