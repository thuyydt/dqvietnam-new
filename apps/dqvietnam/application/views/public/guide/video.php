<div class="app" style="background-image: url(<?= $this->templates_assets ?>images/bg-main.webp);">
  <div class="media">
    <div class="media-wrapper">
      <video controls autoplay controlsList="nodownload" loading="lazy">
        <source src="<?= $this->templates_assets ?>videos/video.mp4" type="video/mp4" />
      </video>
    </div>
    <!-- auto play video -->
    <script>
      var allVideos = document.querySelectorAll('video');
      for (var i = 0; i < allVideos.length; i++) {
        allVideos[i].play();
      } {
        once: true
      };
    </script>
  </div>
  <div class="btn-box">
    <a href="<?= urlRoute('guide/step') ?>" class="btn">TIẾP TỤC</a>
  </div>
</div>