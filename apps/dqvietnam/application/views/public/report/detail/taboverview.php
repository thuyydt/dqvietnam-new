<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="text-center">
        <div class="total-point" style="min-width: 350px; margin: auto; height: 250px">
          <h2 class="text-white">Điểm DQ</h2>
          <span><?= round($point / 8) ?? 0 ?></span>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8 offset-2">
      <canvas id="rada" width="300" height="auto"></canvas>
    </div>
  </div>
  <div class="info-level">
    <div class="row mb-5">
      <div class="col-md-4">
        <div class="level">
          <p>Cấp độ 1</p>
          <div class="badge blue">
            <span>Tốt</span>
            <span>(80 - 100 điểm)</span>
          </div>
        </div>
      </div>
      <div class="col-md-8 text">
        <strong>Cấp độ 1 – Tốt</strong>: Học sinh có nhận thức rõ ràng và hiểu biết tốt về thế giới kỹ thuật số,
        có
        khả năng sử dụng
        thiết bị điện tử và mạng xã hội có trách nhiệm và đạo đức. Khi đạt cấp độ này, trẻ trở thành một
        <strong>Công
          dân kỹ thuật số</strong> sẵn sàng để bước sang mức độ tiếp theo của việc sử dụng kỹ thuật số là
        <strong>Sáng
          tạo kỹ thuật số.</strong>
      </div>
    </div>
    <div class="row mb-5 mt-5">
      <div class="col-md-4">
        <div class="level ">
          <p>Cấp độ 2</p>
          <div class="badge yellow">
            <span>Cơ bản</span>
            <span>(60 - <80 điểm)</span>
          </div>
        </div>
      </div>
      <div class="col-md-8 text">
        <strong>Cấp độ 2 – Khá</strong>:
        Cấp độ 2 – Khá: Học sinh có hiểu biết cơ bản về thế giới kỹ thuật số, có khả năng sử dụng thiết bị điện
        tử
        và mạng xã hội có trách nhiệm và đạo đức ở các năng lực điểm DQ của học sinh trên trung bình.
      </div>
    </div>
    <div class="row mb-5">
      <div class="col-md-4">
        <div class="level">
          <p>Cấp độ 3</p>
          <div class="badge orange">
            <span>Trung bình</span>
            <span>(40 - <60 điểm)</span>
          </div>
        </div>
      </div>
      <div class="col-md-8 text">
        <strong>Cấp độ 3 – Trung bình</strong>:
        Ở cấp độ này học sinh chưa nắm chắc được các kiến thức cần thiết khi tham gia vào môi trường kỹ thuật
        số,
        học sinh cần rèn luyện nhiều hơn để cải thiện các năng lực kỹ thuật số DQ của mình. Cha mẹ, thầy cô cần
        chia
        sẻ và hỗ trợ thêm cho trẻ về các vấn đề trẻ đang gặp phải.
      </div>
    </div>
    <div class="row mb-5">
      <div class="col-md-4">
        <div class="level">
          <p>Cấp độ 4</p>
          <div class="badge red">
            <span>Báo động</span>
            <span>(<40 điểm)</span>
          </div>
        </div>
      </div>
      <div class="col-md-8 text">
        <strong>Cấp độ 4 – Báo động:</strong> Cha mẹ và thầy cô được khuyến khích mạnh mẽ trong việc dành thời
        gian
        chia sẻ và trò
        chuyện với học sinh về cách sử dụng công nghệ số và mạng xã hội, đồng thời chỉ cho học sinh những rủi ro
        mà
        các em có thể gặp phải khi tham gia vào môi trường mạng. Học sinh cần dành thời gian thực hành và rèn
        luyện
        để nâng cao các năng lực kỹ thuật số của mình.
      </div>

    </div>
  </div>
</div>