<div class="info-user medal" style="display: none">
  <div class="info-user__wrapper v3">

    <h2 class="heading">THU THẬP HUY HIỆU</h2>

    <div class="group-item-02">

      <?php for ($i = 1; $i <= 8; $i++) {
        $k = $i * 10; ?>
        <div class="item">
          <div class="item-wrapper <?= $turn > $k ? 'active' : '' ?>">
            <img src="public/game/list/images/ruong.webp" class="statu-1" alt="Rương kho báu" loading="lazy" decoding="async" />
            <img src="public/game/list/images/<?= $i ?>.webp" class="statu-2" alt="Huy hiệu cấp <?= $i ?>" loading="lazy" decoding="async" />
          </div>
        </div>
      <?php } ?>

    </div>

  </div>
</div>