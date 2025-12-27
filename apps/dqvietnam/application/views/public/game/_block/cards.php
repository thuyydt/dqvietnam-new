<div class="info-user cards" style="display: none">
  <div class="info-user__wrapper v4">
    <div class="heading">THU THẬP THẺ</div>
    <div class="slider-thebai">
      <div class="game-04">
        <?php if (!empty($cards)) foreach ($cards as $card) : ?>
          <div class="item">
            <div class="wrapper">
              <img class="statu-1" src="<?= getImageThumb($card, 228, 340) ?>" loading="lazy" />
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>