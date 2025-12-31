<div class="info-user points" style="display: none">
  <div class="info-user__wrapper v2">

    <div class="left">
      <h2 class="heading">ĐIỂM TRUNG BÌNH DQ</h2>

      <div class="bieu-do">
        <div class="armorial" style="position: absolute; width: 100%; height: 100%">
          <div class="list" style="position: relative; width: 100%; height: 100%">
            <img class="item s1" src="public/game/list/images/armorial/1.webp" alt="" loading="lazy" decoding="async" />
            <img class="item s2" src="public/game/list/images/armorial/2.webp" alt="" loading="lazy" decoding="async" />
            <img class="item s3" src="public/game/list/images/armorial/3.webp" alt="" loading="lazy" decoding="async" />
            <img class="item s4" src="public/game/list/images/armorial/4.webp" alt="" loading="lazy" decoding="async" />
            <img class="item s5" src="public/game/list/images/armorial/5.webp" alt="" loading="lazy" decoding="async" />
            <img class="item s6" src="public/game/list/images/armorial/6.webp" alt="" loading="lazy" decoding="async" />
            <img class="item s7" src="public/game/list/images/armorial/7.webp" alt="" loading="lazy" decoding="async" />
            <img class="item s8" src="public/game/list/images/armorial/8.webp" alt="" loading="lazy" decoding="async" />
          </div>
        </div>
        <?php if ($turn >= 80) { ?>
          <div class="info">
            <div class="number"><?= $point['medium'] ?? 0 ?><br> Điểm</div>
          </div>
        <?php } ?>

        <canvas id="barChart" width="600" height="600"></canvas>


      </div>
    </div>

    <div class="right">
      <h2 class="heading">ĐIỂM 8 NĂNG LỰC DQ</h2>

      <div class="group-item-01">
        <div class="item">
          <div class="item-wrapper">
            <img src="public/game/list/images/1.webp" class="icon" alt="Quản lý thời gian tiếp xúc màn hình" loading="lazy" decoding="async" />
            <div class="number"><?= $point['list'][1] ?? 0 ?></div>
          </div>
        </div>
        <div class="item">
          <div class="item-wrapper">
            <img src="public/game/list/images/5.webp" class="icon" alt="Quản lý quyền riêng tư" loading="lazy" decoding="async" />
            <div class="number"><?= $point['list'][5] ?? 0 ?></div>
          </div>
        </div>
        <div class="item">
          <div class="item-wrapper">
            <img src="public/game/list/images/2.webp" class="icon" alt="Quản lý an ninh mạng" loading="lazy" decoding="async" />
            <div class="number"><?= $point['list'][2] ?? 0 ?></div>
          </div>
        </div>
        <div class="item">
          <div class="item-wrapper">
            <img src="public/game/list/images/6.webp" class="icon" alt="Tư duy phản biện" loading="lazy" decoding="async" />
            <div class="number"><?= $point['list'][6] ?? 0 ?></div>
          </div>
        </div>
        <div class="item">
          <div class="item-wrapper">
            <img src="public/game/list/images/3.webp" class="icon" alt="Quản lý bắt nạt trên mạng" loading="lazy" decoding="async" />
            <div class="number"><?= $point['list'][3] ?? 0 ?></div>
          </div>
        </div>
        <div class="item">
          <div class="item-wrapper">
            <img src="public/game/list/images/7.webp" class="icon" alt="Danh tính công dân kỹ thuật số" loading="lazy" decoding="async" />
            <div class="number"><?= $point['list'][7] ?? 0 ?></div>
          </div>
        </div>
        <div class="item">
          <div class="item-wrapper">
            <img src="public/game/list/images/4.webp" class="icon" alt="Quản lý dấu chân kỹ thuật số" loading="lazy" decoding="async" />
            <div class="number"><?= $point['list'][4] ?? 0 ?></div>
          </div>
        </div>
        <div class="item">
          <div class="item-wrapper">
            <img src="public/game/list/images/8.webp" class="icon" alt="Cảm thông kỹ thuật số" loading="lazy" decoding="async" />
            <div class="number"><?= $point['list'][8] ?? 0 ?></div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
  let dataPoint = '<?= json_encode($point['list']) ?>';
</script>