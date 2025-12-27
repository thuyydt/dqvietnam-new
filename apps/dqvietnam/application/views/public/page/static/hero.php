<?php
$hero_banner = $this->info->get('hero_banner');
?>


<main class="hero-page">
    <section class="banner">
        <?php if ($hero_banner) { ?>
            <img src="<?php echo $hero_banner ?>" alt="" srcset="" loading="lazy" />
        <?php } else { ?>
            <img src="../../../../public/images/dqlagi/banner.jpg" alt="" srcset="" loading="lazy" />
        <?php } ?>
    </section>
    <section class="section what">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="title color-red">
                        Gần 70% trẻ em Việt Nam gặp rủi ro trong không gian mạng
                    </div>
                    <div class="desc">
                        Theo báo cáo Tác động DQ (DQ Impact Report 2018), có 68% trẻ em
                        Việt Nam độ tuổi từ 8 đến 12 đang đối mặt với một hoặc nhiều hơn
                        rủi ro không gian mạng như bắt nạt, nghiện game online, lừa đảo,
                        thực hiện hành vi tình dục online khi sử dụng các nền tảng trực
                        tuyến.
                    </div>
                    <div class="desc">
                        Năm 2018, Việt Nam có hơn <strong> 706.000 </strong> báo cáo
                        hình ảnh xâm hại trẻ em, chỉ đứng sau Indonesia trong khu vực.
                        Chỉ số An toàn trực tuyến của trẻ em Việt Nam là
                        <strong>12.7/100 </strong> – Mức báo động rủi ro.
                    </div>
                    <div class="desc">
                        <strong> Các rủi ro trẻ có thể gặp phải: </strong>
                    </div>
                    <ul>
                        <li class="list-item">Bắt nạt trên mạng</li>
                        <li class="list-item">Nghiện game, mạng xã hội</li>
                        <li class="list-item">Xâm hại tình dục qua mạng</li>
                        <li class="list-item">Lừa đảo, tin tức giả</li>
                        <li class="list-item">Nội dung bạo lực, khiêu dâm</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <img src="../../../../public/images/dqlagi/1.jpg" alt="minhhoa" srcset="" loading="lazy" />
                </div>
                <div class="row padding-top-24">
                    <div class="col-lg-6">
                        <img src="../../../../public/images/dqlagi/ipad.jpg" alt="minhhoa" srcset="" loading="lazy" />
                    </div>
                    <div class="col-lg-6">
                        <div class="title color-red">Người Hùng DQ là gì?</div>
                        <div class="desc">
                            Chương trình kỹ năng số “Người Hùng DQ”, hưởng ứng phong trào “Bình Dân Học Vụ Số” theo Nghị
                            quyết 57-NQ/TW ngày 22/12/2024 của Bộ Chính trị, nhằm trang bị các kiến thức cần thiết để
                            trẻ em trở thành các công dân kỹ thuật số có trách nhiệm, đạo đức trên mạng, tránh được các
                            rủi ro khi tham gia trực tuyến và tối đa hoá các cơ hội từ cuộc sống số.
                        </div>
                        <div class="content-wrap">
                            <div class="title color-red">Cách thức học</div>
                            <div class="desc">
                                <div>
                                    1. Đăng ký tài khoản tại
                                    <a href="http://dqvietnam.edu.vn"> dqvietnam.edu.vn</a>
                                </div>
                                <div>2. Kích hoạt tài khoản học</div>
                                <div>3. Đăng nhập vào hệ thống</div>
                                <div>4. Học 8 năng lực DQ</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section learn-content">
        <div class="container">
            <div class="title color-white">Nội dung học</div>
            <div class="sub-title color-white">
                Trang bị 8 năng lực Công dân kỹ thuật số cần thiết cho trẻ
            </div>
            <div class="row skills-8">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="box">
                        <div class="inner-box">
                            <div class="icon">
                                <img src="../../../../public/images/dqlagi/learn/1.png" loading="lazy"/>
                            </div>
                            <div class="txt">
                                <p class="item-title color-1">
                                    Quản lý thời gian tiếp xúc màn hình
                                </p>
                                <p class="item-desc">
                                    Khả năng quản lý và tự chủ thời gian tiếp xúc, tham gia các
                                    hoạt động trực tuyến.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="box">
                        <div class="inner-box">
                            <div class="icon">
                                <img src="../../../../public/images/dqlagi/learn/2.png" loading="lazy"/>
                            </div>
                            <div class="txt">
                                <p class="item-title color-2">
                                    Quản lý an ninh mạng
                                </p>
                                <p class="item-desc">
                                    Khả năng bảo vệ dữ liệu cá nhân bằng cách đặt mật khẩu mạnh và kiểm soát các cuộc
                                    tấn công, lừa đảo
                                    trên mạng.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="box">
                        <div class="inner-box">
                            <div class="icon">
                                <img src="../../../../public/images/dqlagi/learn/3.png" loading="lazy"/>
                            </div>
                            <div class="txt">
                                <p class="item-title color-3">
                                    Quản lý bắt nạt trên mạng
                                </p>
                                <p class="item-desc">
                                    Khả năng phát hiện và giải quyết thông minh những tình huống khủng bố trên mạng.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="box">
                        <div class="inner-box">
                            <div class="icon">
                                <img src="../../../../public/images/dqlagi/learn/4.png" loading="lazy"/>
                            </div>
                            <div class="txt">
                                <p class="item-title color-4">
                                    Quản lý dấu chân kỹ thuật số
                                </p>
                                <p class="item-desc">
                                    Khả năng hiểu được bản chất, hậu quả thực tế và biết cách quản lý lịch sử kỹ thuật
                                    số.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="box">
                        <div class="inner-box">
                            <div class="icon">
                                <img src="../../../../public/images/dqlagi/learn/5.png" loading="lazy"/>
                            </div>
                            <div class="txt">
                                <p class="item-title color-5">
                                    Quản lý quyền riêng tư
                                </p>
                                <p class="item-desc">
                                    Khả năng xử lý thận trọng thông tin cá nhân được chia sẻ trực tuyến để bảo vệ tính
                                    riêng tư cho cá
                                    nhân và người khác.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="box">
                        <div class="inner-box">
                            <div class="icon">
                                <img src="../../../../public/images/dqlagi/learn/6.png" loading="lazy"/>
                            </div>
                            <div class="txt">
                                <p class="item-title color-6">
                                    Tư duy phản biện
                                </p>
                                <p class="item-desc">
                                    Khả năng phân biệt đánh giá thông tin hoặc nội dung đúng hay sau, tốt hay độc hại,
                                    thông tin đáng tin
                                    cậy hay đáng nghi.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="box">
                        <div class="inner-box">
                            <div class="icon">
                                <img src="../../../../public/images/dqlagi/learn/7.png" loading="lazy"/>
                            </div>
                            <div class="txt">
                                <p class="item-title color-7">
                                    Danh tính công dân kỹ thuật số
                                </p>
                                <p class="item-desc">
                                    Khả năng xây dựng và quản lý danh tính trực tuyến, ngoại tuyến lành mạnh, toàn vẹn.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="box">
                        <div class="inner-box">
                            <div class="icon">
                                <img src="../../../../public/images/dqlagi/learn/8.png" loading="lazy"/>
                            </div>
                            <div class="txt">
                                <p class="item-title color-8">
                                    Cảm thông kỹ thuật số
                                </p>
                                <p class="item-desc">
                                    Khả năng đồng cảm và cảm thông với nhu cầu và cảm xúc trực tuyến của bản thân và
                                    người khác.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <section class="section method-learn">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="title color-red">Phương Pháp Học Trò Chơi Hoá</div>
                    <div class="sub-title">
                        Chương trình Người hùng DQ được xây dựng theo phương pháp Trò
                        chơi hoá – Học mà chơi, chơi mà học giúp trẻ dễ dàng tiếp thu
                        kiến thức, ghi nhớ và hứng thú học tập.
                    </div>
                    <a href="<?= urlRoute('guide?type=try_game') ?>" class="btn btn-02">TRẢI NGHIỆM</a>
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-4 img-wrap">
                            <img class="pp-img" src="../../../../public/images/dqlagi/pp1.png" alt="" srcset="" loading="lazy"/>
                            <div class="img-desc">
                                • Series hoạt hình sinh động với đồ họa đặc sắc
                            </div>
                        </div>
                        <div class="col-lg-4 img-wrap">
                            <img class="pp-img" src="../../../../public/images/dqlagi/pp2.png" alt="" srcset="" loading="lazy"/>
                            <div class="img-desc">• Trò chơi tương tác hấp dẫn</div>
                        </div>
                        <div class="col-lg-4 img-wrap">
                            <img class="pp-img" src="../../../../public/images/dqlagi/pp3.png" alt="" srcset="" loading="lazy"/>
                            <div class="img-desc">• Trắc nghiệm tình huống đa dạng</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mohinh">
                <div class="title color-red text-center w-70">
                    Mô hình <br/>
                    lớp học đảo ngược
                </div>
                <div class="sub-title text-center w-80 margin-bot-56">
                    Dựa trên mô hình lớp học đảo ngược – Flipped learning, chương
                    trình Người hùng DQ lấy học sinh làm trung tâm, định hướng các em
                    học sinh học tập và tích luỹ kiến thức thông qua các hoạt động tự
                    trải nghiệm trên nền tảng trực tuyến (E-Learning). Sau khi thực
                    hành các bài học trên nền tảng trực tuyến, giáo viên sẽ hỗ trợ học
                    sinh ôn tập, tìm hiểu sâu kiến thức lại thông qua các giờ thảo
                    luận.
                </div>
                <div class="row">
                    <div class="col-lg-4 item-step">
                        <img src="../../../../public/images/dqlagi/pp4.png" alt="" srcset="" loading="lazy"/>
                        <div class="img-desc">Bước 1: Học trước trên E-Learning</div>
                        <div class="img-content">
                            Xem các video hoạt hình tình huống, trả lời câu hỏi trắc
                            nghiệm tương tác, làm câu đố, giải trò chơi trí tuệ trên nền
                            tảng trực tuyến dqvietnam.edu.vn
                        </div>
                    </div>
                    <div class="col-lg-4 item-step">
                        <img src="../../../../public/images/dqlagi/pp5.png" alt="" srcset="" loading="lazy"/>
                        <div class="img-desc">Bước 2: Thảo luận</div>
                        <div class="img-content">
                            Trẻ thảo luận các tình huống với giáo viên hoặc cha mẹ, đặt
                            câu hỏi làm rõ nội dung, ứng dụng các kiến thức
                        </div>
                    </div>
                    <div class="col-lg-4 item-step">
                        <img src="../../../../public/images/dqlagi/pp6.png" alt="" srcset="" loading="lazy"/>
                        <div class="img-desc">
                            Bước 3: Hoàn tất môn học
                        </div>
                        <div class="img-content">
                            Tiếp tục xem các video, làm bài tập, thảo luận và nhận báo cáo
                            của chương trình học
                        </div>
                    </div>
                </div>


                <div class="card-group">
                    <div class="wrap-card">
                        <div class="card-content shadow-card">
                            <div class="title color-red">Công Cụ Học Tập</div>
                            <div class="desc">
                                <ul>
                                    <li class="item-list">
                                        • Tài khoản học trực tuyến với các bài học trực quan,
                                        sinh động, mang đến một trải nghiệm học tập mởi mẻ, thú
                                        vị.
                                    </li>
                                    <li class="item-list">
                                        • Bộ học liệu 8 cuốn sách năng lực kỹ thuật số DQ giúp
                                        các em ôn tập, mở rộng lý thuyết và thực hành với các
                                        câu hỏi bài tập đa dạng.
                                    </li>
                                    <li class="item-list">
                                        • Báo cáo kết quả tổng quan và chi tiết 8 năng lực kỹ
                                        thuật số.
                                    </li>
                                    <li class="item-list">
                                        • Giấy chứng nhận Công dân kỹ thuật số
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content">
                            <img src="../../../../public/images/dqlagi/card.png" alt="" loading="lazy"/>
                        </div>
                    </div>
                    <div class="wrap-card">
                        <div class="card-content shadow-card">
                            <div class="title color-red">
                                Tầm soát rủi ro trong không gian mạng
                            </div>
                            <div class="desc">
                                Với hệ thống phân tích thông minh, chương trình Người hùng
                                DQ không chỉ trang bị các kỹ năng kỹ thuật số cần thiết cho
                                trẻ mà còn chỉ ra các rủi ro mà trẻ đã hoặc đang gặp phải
                                trên mạng cho phụ huynh và nhà trường qua các Báo cáo DQ.
                            </div>
                        </div>

                        <div class="card-content">
                            <img src="../../../../public/images/dqlagi/card2.png" alt="" srcset="" loading="lazy"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section give">
        <div class="container">
            <div class="title color-red text-center">
                Người Hùng DQ Mang Đến Cho Trẻ Và Cha Mẹ Những Kiến Thức Bổ Ích Gì?
            </div>
            <div class="row">
                <div class="col-lg-4 give-item">
                    <img class="img-loiich" src="../../../../public/images/dqlagi/loiich1.png" alt="" loading="lazy"/>
                    <ul class="give-item-content shadow-card-blur">
                        <li class="item-list">
                            <img class="icon-check" src="../../../../public/images/dqlagi/icon-check.png" alt="" srcset="" loading="lazy"/>
                            <span>Có thái độ, hành vi an toàn và trách nhiệm khi tham gia
                trực tuyến.
              </span>
                        </li>
                        <li class="item-list">
                            <img class="icon-check" src="../../../../public/images/dqlagi/icon-check.png" alt="" srcset="" loading="lazy"/>
                            <span>
                Biết cân bằng thời gian tiếp xúc màn hình các thiết bị điện
                tử, mạng xã hội.
              </span>
                        </li>
                        <li class="item-list">
                            <img class="icon-check" src="../../../../public/images/dqlagi/icon-check.png" alt="" srcset="" loading="lazy"/>
                            <span>
                Hiểu rõ hơn về sự hiện diện trực tuyến, quyền riêng tư và
                bảo vệ dữ liệu tránh sự xâm nhập của mã độc, tin tặc…
              </span>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-4 give-item">
                    <img class="img-loiich" src="../../../../public/images/dqlagi/loiich2.png" alt="" loading="lazy"/>
                    <ul class="give-item-content shadow-card-blur">
                        <li class="item-list">
                            <img class="icon-check" src="../../../../public/images/dqlagi/icon-check.png" alt=""
                                 srcset="" loading="lazy"/>
                            <span>Phát triển tư duy phản biện, tỉnh táo trước những thông tin
                trên mạng.
              </span>
                        </li>
                        <li class="item-list">
                            <img class="icon-check" src="../../../../public/images/dqlagi/icon-check.png" alt=""
                                 srcset="" loading="lazy"/>
                            <span> Biết đồng cảm với những cảm xúc của người khác. </span>
                        </li>
                        <li class="item-list">
                            <img class="icon-check" src="../../../../public/images/dqlagi/icon-check.png" alt=""
                                 srcset="" loading="lazy"/>
                            <span>Giảm thiểu các rủi ro khi trực tuyến và tận dụng các cơ hội
                từ thế giới kỹ thuật số mang lại.
              </span>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-4 give-item">
                    <img class="img-loiich" src="../../../../public/images/dqlagi/loiich3.png" alt="" loading="lazy"/>
                    <ul class="give-item-content shadow-card-blur">
                        <li class="item-list">
                            <img class="icon-check" src="../../../../public/images/dqlagi/icon-check.png" alt=""
                                 srcset="" loading="lazy"/>
                            <span>Các hướng dẫn sẽ giúp cho cha mẹ, người chăm sóc hay giáo
                viên có thể học và chơi cùng với trẻ và hỗ trợ chúng trong
                việc phát triển sự hiểu biết về thế giới kỹ thuật số và khả
                năng an toàn.
              </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="section countdown">
        <div class="container flex-top-center">
            <div class="wrap-countdown text-center">
                <a style="margin-top: 200px" href="https://docs.google.com/forms/d/e/1FAIpQLSdb79Q6Sm9ASZq8_RptQDsrhJlqMlgHU2MumLST3CfeRMt1Sw/viewform" class="btn-register">ĐĂNG KÝ HỌC</a>
            </div>
        </div>
    </section>
</main>
<script>
    (function () {
        const second = 1000;
        const minute = second * 60;
        const hour = minute * 60;
        const day = hour * 24;

        const bayngay = 1000 * 60 * 60 * 24 * 7

        let countDown = new Date("Nov 15, 2022 16:18:00").getTime();
        const x = setInterval(function () {
            const now = new Date().getTime();
            const distance = countDown - now;
            //do something later when date is reached
            if (distance > 0) {

                // (document.getElementById("days").innerText = Math.floor(
                //     distance / day
                // )),
                //     (document.getElementById("hours").innerText = Math.floor(
                //         (distance % day) / hour
                //     )),
                //     (document.getElementById("minutes").innerText = Math.floor(
                //         (distance % hour) / minute
                //     )),
                //     (document.getElementById("seconds").innerText = Math.floor(
                //         (distance % minute) / second
                //     ));
            } else {
                countDown = now + bayngay
            }
            //seconds
        }, 1000);
    })();
</script>
