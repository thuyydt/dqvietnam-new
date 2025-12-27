<?php
$isAnswerTrue = $keyAnswer ? str_contains(mb_strtolower($keyAnswer['title']), 'A'): false;
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

        <div class="col-md-8">
            <?php if ($isAnswerTrue): ?>
                <p class="txt">
                    Trẻ biết cách kiểm soát các hoạt động trên mạng của mình tránh để lại các dấu vết có thể ảnh hưởng
                    đến hình ảnh ngoài đời thật.
                </p>
            <?php else: ?>
                <p class="txt">
                    Khi thực hiện một hoạt động trên mạng như chia sẻ thông tin, đăng ảnh, bình luận trên mạng, trẻ
                    thường không suy nghĩ cẩn thận khi đăng chúng lên, điều này có thể khiến trẻ gặp phải một số rủi ro
                    liên quan đến dấu chân kỹ thuật số.
                </p>
            <?php endif; ?>
        </div>
        <div class="col-md-4">
        </div>
        <div class="clearfix mt-5"></div>
        <div class="col-md-6">
            <p class="title text-bold orange mb-4">khuyến nghị</p>

            <p class="txt">
                Mọi hoạt động chúng ta làm trên mạng như nhắn tin, đăng ảnh hay chia sẻ thông tin hãy chỉ một nút “like”
                thô cũng đều để lại dấu vết gọi là dấu chân kỹ thuật số, nó rất khó xoá bỏ và có thể ảnh hưởng đến hình
                ảnh của chúng ta ngoài đời thật, gây ra những rủi ro không lường trước được. Cha mẹ cần khuyến khích trẻ
                thực hành và ghi nhớ các kiến thức quản lý dấu chân kỹ thuật số.
            </p>
        </div>
        <div class="col-md-6">

        </div>
    </div>
</div>
