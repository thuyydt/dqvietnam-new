<?php
$home_banner = $this->info->get('home_banner');
?>
<style>
    @media (max-width: 575px) {
        .c-section__home-01 .hero{
                height: auto;
        }
        .c-section__home-01 .hero .btn{
            font-size: 3vw;
            top: 80%;
        }
        .c-section__home-01 .hero .element.element-01 {
            display: flex;
            object-fit: contain;
            position: relative;
            height: auto;
            width: 100%;
        }
    }
</style>
<main>
    <base href="<?= base_url() ?>"/>
    <section class="c-section__home-01">
        <div class="hero">
            <?php if ($home_banner) { ?>
                <img src="<?php echo $home_banner ?>" loading="lazy" class="element element-01">
            <?php } else { ?>
                <img src="public/images/element-24.jfif" loading="lazy" class="element element-01">
                <img src="public/images/element-21.png" loading="lazy" class="element element-02">
                <img src="public/images/element-22.png" loading="lazy" class="element element-03">
                <img src="public/images/element-23.png" loading="lazy" class="element element-04">
                <img src="public/images/logo-02.png" loading="lazy" class="element element-05">
            <?php } ?>
            <a style="left: 30%" href="https://docs.google.com/forms/d/e/1FAIpQLSdb79Q6Sm9ASZq8_RptQDsrhJlqMlgHU2MumLST3CfeRMt1Sw/viewform?usp=header" class="btn btn-02">ĐĂNG KÍ PHONG TRÀO</a>
        </div>

        <div class="runtext-container">
            <div class="main-runtext">
                <marquee direction="" onmouseover="this.stop();" onmouseout="this.start();">
                    <div class="holder">
                        <div class="text-container">
                            <a data-fancybox-group="gallery" class="fancybox text-uppercase" href="#">Làm chủ công nghệ
                                với 8 năng lực
                                kỹ thuật số DQ</a>
                        </div>
                        <div class="text-container">
                            <a data-fancybox-group="gallery" class="fancybox text-uppercase" href="#">HƯỞNG ỨNG PHONG
                                TRÀO “BÌNH DÂN HỌC VỤ SỐ”</a>
                        </div>
                        <div class="text-container">
                            <a data-fancybox-group="gallery" class="fancybox text-uppercase" href="#">Làm chủ công nghệ
                                với 8 năng lực
                                kỹ thuật số DQ</a>
                        </div>
                        <div class="text-container">
                            <a data-fancybox-group="gallery" class="fancybox text-uppercase" href="#">HƯỞNG ỨNG PHONG
                                TRÀO “BÌNH DÂN HỌC VỤ SỐ”</a>
                        </div>
                        <div class="text-container">
                            <a data-fancybox-group="gallery" class="fancybox text-uppercase" href="#">Làm chủ công nghệ
                                với 8 năng lực
                                kỹ thuật số DQ</a>
                        </div>
                        <div class="text-container">
                            <a data-fancybox-group="gallery" class="fancybox text-uppercase" href="#">HƯỞNG ỨNG PHONG
                                TRÀO “BÌNH DÂN HỌC VỤ SỐ”</a>
                        </div>
                    </div>
                </marquee>
            </div>
        </div>
    </section>
    <!-- section 01 -->

    <section class="c-section__home-02">
        <img src="public/images/element-02.jpeg" class="bg">
        <div class="container">
            <h1>Tổng quan<span>Khóa học</span></h1>
            <p>Chương trình kỹ năng số “Người Hùng DQ”, hưởng ứng phong trào “Bình Dân Học Vụ Số” theo Nghị quyết
                57-NQ/TW ngày 22/12/2024 của Bộ Chính trị, là chương trình học trực tuyến giúp trẻ em từ 8-14 tuổi phát
                triển kiến thức và kỹ năng cần thiết để điều hướng thế giới trực tuyến một cách an toàn.</p>
            <!-- <?php if (!empty($pages['hero'])) : ?>
      <a href="<?= getUrlPage($pages['hero']) ?>" data-fancybox="gallery-0" class="btn btn-02">Tìm hiểu thêm</a>
      <?php endif; ?> -->
            <a href="<?= urlRoute('nguoi-hung-dq') ?>" class="btn btn-02">Tìm hiểu thêm</a>

        </div>
        <?php if (!empty($this->settings['video_tutorial'])) : ?>
            <a href="https://dqvietnam.edu.vn/public/videos/dq_pr.mp4" class="play" data-fancybox="gallery-0"><img
                        src="./public/images/element-06.png"></a>
        <?php endif; ?>
        </div>
    </section>
    <!-- section 02 -->

    <section class="c-section__home-03">
        <div class="container">
            <div class="inner">
                <div class="box">
                    <h2>Học thử<br>miễn phí</h2>
                    <a href="<?= urlRoute('guide?type=try_game') ?>" class="btn btn-02">Tham gia ngay</a>
                </div>
                <img src="public/images/element-07.png" loading="lazy" style="width:60%" class="bg">
            </div>
        </div>
    </section>
    <!-- section 03 -->

    <section class="c-section__home-04">
        <div class="container">
            <div class="title text-center">
                8 KỸ NĂNG SỐ <br/>CẦN THIẾT CHO TRẺ EM
            </div>
            <div class="row group">
                <div class="col-12 col-sm-6 col-md-4 item">
                    <a href="javascript:;" class="wrapper">
                        <div class="inner">
                            <img src="../../../../public/images/1.jpg" loading="lazy"/>
                            <div class="info">
                                <h3 class="title-card">
                                    Quản lý thời gian tiếp xúc màn hình
                                </h3>
                                <div class="description">
                                    Khả năng quản lý và tự chủ thời gian tiếp xúc, tham gia các
                                    hoạt động trực tuyến
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- / item -->
                <div class="col-12 col-sm-6 col-md-4 item">
                    <a href="javascript:;" class="wrapper">
                        <div class="inner">
                            <img src="../../../../public/images/2.jpeg" loading="lazy"/>
                            <div class="info">
                                <h3 class="title-card">Quản lý bắt nạt trên mạng</h3>
                                <div class="description">
                                    Khả năng phát hiện và giải quyết thông minh những tình huống
                                    bắt nạt trên mạng
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- / item -->
                <div class="col-12 col-sm-6 col-md-4 item">
                    <a href="javascript:;" class="wrapper">
                        <div class="inner">
                            <img src="../../../../public/images/3.jpeg" loading="lazy"/>
                            <div class="info">
                                <h3 class="title-card">Quản lý quyền riêng tư</h3>
                                <div class="description">
                                    Khả năng xử lý thận trọng thông tin cá nhân được chia sẻ
                                    trực tuyến để bảo vệ quyền riêng tư cho cá nhân và người
                                    khác
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- / item -->
                <div class="col-12 col-sm-6 col-md-4 item">
                    <a href="javascript:;" class="wrapper">
                        <div class="inner">
                            <img src="../../../../public/images/4.jpeg" loading="lazy"/>
                            <div class="info">
                                <h3 class="title-card">Danh tính công dân kỹ thuật số</h3>
                                <div class="description">
                                    Khả năng xây dựng và quản lý danh tính trực tuyến, ngoại
                                    tuyến lành mạnh, toàn vẹn
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- / item -->
                <div class="col-12 col-sm-6 col-md-4 item">
                    <a href="javascript:;" class="wrapper">
                        <div class="inner">
                            <img src="../../../../public/images/5.jpeg" loading="lazy"/>
                            <div class="info">
                                <h3 class="title-card">Quản lý an ninh mạng</h3>
                                <div class="description">
                                    Khả năng bảo vệ dữ liệu cá nhân bằng cách đặt mật khẩu mạnh
                                    và kiểm soát các cuộc tấn công, lừa đảo trên mạng
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- / item -->
                <div class="col-12 col-sm-6 col-md-4 item">
                    <a href="javascript:;" class="wrapper">
                        <div class="inner">
                            <img src="../../../../public/images/6.jpeg" loading="lazy"/>
                            <div class="info">
                                <h3 class="title-card">Quản lý dấu chân kỹ thuật số</h3>
                                <div class="description">
                                    Khả năng hiểu được bản chất, hậu quả thực tế và biết cách
                                    quản lý lịch sử kỹ thuật số
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- / item -->
                <div class="col-12 col-sm-6 col-md-4 item">
                    <a href="javascript:;" class="wrapper">
                        <div class="inner">
                            <img src="../../../../public/images/7.jpeg" loading="lazy"/>
                            <div class="info">
                                <h3 class="title-card">Tư duy phản biện</h3>
                                <div class="description">
                                    Khả năng phân biệt đánh giá thông tin hoặc nội dung đúng hay
                                    sau, tốt hay độc hại, thông tin đáng tin cậy hay đáng nghi
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- / item -->
                <div class="col-12 col-sm-6 col-md-4 item disabled">
                    <div class="wrapper"></div>
                </div>
                <!-- / item -->
                <div class="col-12 col-sm-6 col-md-4 item">
                    <a href="javascript:;" class="wrapper">
                        <div class="inner">
                            <img src="../../../../public/images/8.jpeg" loading="lazy"/>
                            <div class="info">
                                <h3 class="title-card">Cảm thông kỹ thuật số</h3>
                                <div class="description">
                                    Khả năng đồng cảm và cảm thông với nhu cầu và cảm xúc trực
                                    tuyến của bản thân và người khác
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- / item -->
            </div>
        </div>
    </section>

</main>
