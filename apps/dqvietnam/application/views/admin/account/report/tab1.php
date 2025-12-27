<?php
$isAnswerTrue = false;
if(isset($keyAnswer['title']) && !empty($keyAnswer['title'])){
    $isAnswerTrue = str_contains(mb_strtolower($keyAnswer['title']), 'dưới 2 giờ');
}
?>
<div class="task-detail">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-uppercase text-center txt-orange"><?= $title ?></h1>
        </div>
    </div>

    <div class="row align-items-center mt-5">
        <div class="col-md-3">
            <div class="point  <?= $colorPoint ?? 'red' ?>">
                <div class="content">
                    <h4><?= $pointType ?></h4>
                    <span>Điểm</span>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <?php $this->load->view($this->template_path . 'account/report/point-level') ?>
        </div>
        <div class="clearfix mt-5"></div>
        <div class="col-md-12">
            <p class="title text-bold mb-4">Thời gian sử dụng màn hình điện tử của trẻ là: <?= $keyAnswer['title'] ?? '....' ?></p>
        </div>
        <div class="col-md-8">
            <?php if ($isAnswerTrue): ?>
                <p class="txt">
                    Thời gian tiếp xúc màn hình của trẻ là <?= strtolower($keyAnswer['title']) ?? '....' ?>. Trẻ đã biết cách kiểm soát thời
                    gian
                    khi tiếp
                    xúc màn hình. Tuy nhiên, để bảo vệ sức khoẻ thể chất và tinh thần, trẻ vẫn cần áp dụng những quy tắc
                    an
                    toàn
                    khi tiếp xúc màn hình. Quy tắc đó bao gồm:
                </p>
                <ul class="txt">
                    <li> Giữ khoảng cách <b>40 - 60cm</b> khi tiếp xúc màn hình</li>
                    <li> Không tiếp xúc màn hình trong điều kiện thiếu ánh sáng</li>
                    <li> Không tiếp xúc màn hình khi đang đi vệ sinh</li>

                </ul>
            <?php else: ?>
                <p class="txt">Thời gian tiếp xúc màn hình của trẻ là trên 2 giờ mỗi ngày. Với thời lượng tiếp xúc màn hình trên 2
                    giờ mỗi ngày có thể ảnh hưởng đến sức khỏe tinh thần, thể chất của trẻ và dễ khiến trẻ nghiện các
                    thiết bị điện tử, mạng xã hội. </p>
            <?php endif; ?>
        </div>
        <div class="col-md-4">
        </div>
        <div class="clearfix mt-5"></div>
        <div class="col-md-6">
            <p class="title text-bold orange mb-4">khuyến nghị</p>

            <p class="txt">
                Những tác động tới thể chất và tinh thần của trẻ khi tiếp xúc với màn hình quá nhiều:
            </p>
            <ul class="txt">
                <li> Dễ cáu giận với những người xung quanh</li>
                <li>Giảm thị lực</li>
                <li> Mất ngủ</li>
                <li>Ghi nhớ kém</li>
                <li> Khả năng tập trung kém</li>
                <li>Dễ rối loạn lo âu, trầm cảm</li>
            </ul>
            <p class="txt"> Trẻ được khuyến khích duy trì thời gian tiếp xúc màn hình dưới 2 giờ mỗi ngày, không tiếp
                xúc màn hình
                dưới điều kiện thiếu sáng hay khi đang đi vệ sinh, tăng cường các hoạt động thể thao ngoài trời, vui
                chơi cùng bạn bè và người thân.
            </p>
        </div>
        <div class="col-md-6"></div>
    </div>
</div>
