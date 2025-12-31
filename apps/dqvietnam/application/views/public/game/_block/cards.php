<div class="info-user cards" style="display: none">
  <div class="info-user__wrapper v4">
    <h2 class="heading">THU THẬP THẺ</h2>
    <div class="slider-thebai">
      <div class="game-04">
        <?php if (!empty($cards)) foreach ($cards as $card) : ?>
          <div class="item">
            <div class="wrapper">
              <img class="statu-1" src="<?= getImageThumb($card, 228, 340) ?>" alt="Thẻ bài sưu tập" loading="lazy" decoding="async" />
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>