<?php
$isAnswerTrue = $keyAnswer ? str_contains(mb_strtolower($keyAnswer['title']), 'A') : false;
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
                    Khi nhìn thấy bài đăng trên mạng, trẻ có xu hướng làm theo những gì các thông tin trên mạng nói mà
                    không kiểm chứng hay nói với người lớn. Điều này rất nguy hiểm vì trên mạng có rất nhiều tin giả,
                    sai sự thật có thể gây ra rủi ro cho chính mình và người khác nếu làm theo. Trẻ cần rèn luyện nhiều
                    hơn để phát triển tư duy phản biện của mình.
                </p>
            <?php else: ?>
                <p class="txt">
                    Khi nhìn thấy bài đăng trên mạng, trẻ không vội vã tin những gì bài đăng đó nói vì đó là thông tin
                    chưa được kiểm chứng và nó có thể là tin giả. Trẻ đã dần hình thành tư duy phản biện cho mình mà
                    không dễ dàng tin vào những thông tin trên mạng
                </p>
            <?php endif; ?>
        </div>
        <div class="col-md-4">
        </div>
        <div class="clearfix mt-5"></div>
        <div class="col-md-6">
            <p class="title text-bold orange mb-4">khuyến nghị</p>

            <p class="txt">
                Có rất nhiều thông tin trên mạng là tin giả, cha mẹ cần cần khuyến khích trẻ thực hành và ghi nhớ các
                kiến thức về tư duy phản biện để trẻ tránh được các rủi ro liên quan đến tin giả trên mạng.
            </p>
            <p class="txt">
                Để xác định một thông tin trên mạng là thật hay giả, cha mẹ cần giúp trẻ cần hình thành cho mình một số
                phản xạ sau.
            </p>
            <ul class="txt noStyle">
                <li>
                    Xem xét nguồn tin để biết thông tin đó đến từ đâu, có phải đến từ các trang web uy tín của chính
                    phủ, trường học, tổ chức có thẩm quyền…hay không
                </li>
                <li>
                    Xem xét xem ai là tác giả bài viết, đó có phải là một người có chuyên môn về lĩnh vực đó hay không
                </li>
                <li>
                    Để ý hình thức bài viết, những tin giả thường được viết theo phông chữ lạ và sai chính tả
                </li>
                <li>
                    Hỏi ý kiến cha mẹ, thầy cô hoặc những người có chuyên môn
                </li>
            </ul>
        </div>
        <div class="col-md-6">

        </div>
    </div>
</div>
