<div class="app" role="main" style="background-color: #fff;">
  <div class="tong-ket">
    <div class="container-tk">

      <h1 class="heading" style="text-transform: uppercase">Báo cáo cấp độ rủi ro trong<br>không gian mạng</h1>

      <div class="left" style="position: relative">
        <div class="bieu-do">
          <div class="duong-tron" style="width: 35vw; height: 100%; position: relative">
            <canvas id="barChart"></canvas>
          </div>
          <div class="info">
            <div style="font-size: 20px;" class="number"><?= $point['medium'] ?? 0 ?><br> Điểm</div>
          </div>
        </div>
      </div>

      <div class="right">

        <ul class="list">

          <li class="item">
            <div class="info">
              <div class="lv">Cấp độ 1</div>
              <div class="number" style="background-color: #477ce6;"> Tốt<br> (80 - 100 điểm)</div>
            </div>
            <div class="content">
              Nắm bắt thành thạo các kỹ năng của một công dân kỹ thuật số. Biết cách sử dụng
              công nghệ và các
              phương tiện truyền thông kỹ thuật số trách nhiệm, đạo đức, an toàn trên không gian mạng
            </div>
          </li>
          <li class="item">
            <div class="info">
              <div class="lv">Cấp độ 2</div>
              <div class="number" style="background-color: #f7d155;">Cơ bản<br> (60 - <80 điểm)</div>
              </div>
              <div class="content">
                Có kiến thức sử dụng các thiết bị công nghệ và phương tiện truyền thông kỹ thuật
                số ở mức cơ bản. Tuy nhiên,
                học sinh cần thực hành các bài học nhiều hơn để cái thiện các kỹ năng dưới 86 điểm.
              </div>
          </li>
          <li class="item">
            <div class="info">
              <div class="lv">Cấp độ 3</div>
              <div class="number" style="background-color: #f2783d;">Trung bình<br> (40 - <60 điểm)</div>
              </div>
              <div class="content">
                Chưa nắm được các kỹ năng cần thiết để trở thành công nhân kỹ thuật số có trách
                nhiệm và an toàn trên không gian mạng.
                Ở ngưỡng điểm này, trẻ không được khuyến khích sử dụng mạng xã hội vì có nguy cơ gặp phải
                rủi ro trong không gian mang.
                Cha mẹ và người giám hộ được khuyến khích dành thời gian trò chuyện và hỗ trợ thêm cho trẻ
              </div>
          </li>
          <li class="item">
            <div class="info">
              <div class="lv">Cấp độ 4</div>
              <div class="number" style="background-color: #ee4646;"> Báo động<br> (<40 điểm)</div>
              </div>
              <div class="content">
                Có nguy cơ cao gặp phải rủi ro trong không gian mạng hoặc các vấn đề nằm ngoài khá
                năng tự kiểm soát của trẻ.
                Cha mẹ và người giảm hộ cần nói chuyện, chia sẽ và hỗ trợ trẻ nhiều hơn. Trẻ cần thực hành
                các bài học nhiều hơn để cải thiện các kỹ năng
                DQ của mình
              </div>
          </li>

        </ul>

      </div>

      <div class="info-tk" style="font-size: 24px; font-weight: bold">
        Theo Báo cáo cấp độ rủi ro trong không gian mạng,<br /> trẻ đạt

        <b style="color: <?= $color ?>"><?= $medium ?? 0 ?></b> điểm và ở

        <?php if ($medium >= 80) : ?>
          <b style="color: <?= $color ?>">Cấp độ 1 - Tốt</b>
        <?php elseif ($medium > 60) : ?>
          <b style="color: <?= $color ?>">Cấp độ 2 - Cơ bản</b>
        <?php elseif ($medium > 40) : ?>
          <b style="color: <?= $color ?>">Cấp độ 3 - Trung bình</b>
        <?php else : ?>
          <b style="color: <?= $color ?>">Cấp độ 4 - Báo động</b>
          <?php endif; ?>.
          <?= $this->settings['report'][0]['lv' . $level]['content'] ?>
      </div>
    </div>
  </div>
</div>

<script>
  let dataPoint = '<?= json_encode($point['chart']) ?>';
</script>