<?php
if (!$keyAnswer) {
    $keyAnswer = ['title' => '...'];
    $isAnswerTrue = false;
} else {
    $isAnswerTrue = str_contains(mb_strtolower($keyAnswer['title']), 'đã từng');
}
?>
<div class="task-detail">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-uppercase text-center txt-orange">BÁO CÁO KỸ NĂNG <br/><?= $title ?></h1>
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
            <?php $this->load->view($this->template_path . 'detail/point-level') ?>
        </div>
        <div class="clearfix mt-5"></div>

        <div class="col-md-8">
            <?php if ($isAnswerTrue): ?>
                <p class="txt">
                    Trẻ <strong><?php echo mb_strtoupper($keyAnswer['title']) ?></strong> bị bắt nạt trên mạng. Cha mẹ
                    cần quan tâm và chia sẻ với trẻ nhiều hơn để trẻ nói ra cảm
                    xúc và suy nghĩ của mình. Khi bị bắt nạt trên mạng, trẻ có thể có những suy nghĩ tiêu cực, thu mình
                    lại, dễ dẫn đến chứng rối loạn lo âu và trầm cảm. Cha mẹ cần đặc biệt quan tâm lắng nghe suy nghĩ
                    của trẻ.
                </p>
            <?php else: ?>
                <p class="txt">Trẻ chưa từng bị bắt nạt trên mạng. Đây là một điều tuyệt vời! Tuy nhiên, cha me vẫn cần
                    thường xuyên lắng nghe và trò chuyện với trẻ về các hoạt động trên mạng của trẻ để kịp thời nắm bắt
                    các vấn đề đang xảy ra với trẻ. </p>
            <?php endif; ?>
        </div>
        <div class="col-md-4">
        </div>
        <div class="clearfix mt-5"></div>
        <div class="col-12  mb-4">
            <p class="title text-bold orange">khuyến nghị</p>
        </div>
        <div class="col-md-6">
            <p class="txt">
                Những dấu hiệu cho thấy trẻ bị bắt nạt trên mạng:
            </p>
            <ul class="txt">
                <li>Lo lắng, sợ hãi việc đi học hoặc đi chơi</li>
                <li>Tách bản thân khỏi gia đình, bạn bè</li>
                <li> Trở nên thiếu tự tin và khép mình</li>
                <li>Mất hứng thú với sở thích</li>
            </ul>
        </div>
        <div class="col-md-6">
            <p class="txt">
                Cha mẹ cần thường xuyên trò chuyện và lắng nghe trẻ. Trong trường hợp trẻ bị bắt nạt trên mạng, cha mẹ
                cần:
            </p>
            <ul class="txt">
                <li>Lắng nghe và cảm thông với những cảm xúc của trẻ</li>
                <li>Nhắc trẻ rằng trẻ không đơn độc, luôn có cha mẹ hoặc người thân bên cạnh</li>
                <li>Tìm hiểu vấn đề khiến trẻ bị bắt nạt trên mạng, nhắc trẻ chặn/xoá các tài khoản bắt nạt trẻ trên
                    mạng
                </li>
                <li>Cùng trẻ làm những điều khiến trẻ cảm thấy vui vẻ và hạnh phúc</li>
            </ul>
        </div>
    </div>
</div>
