<main class="c-main" id="page-forget-password">
    <div class="account-box">
        <div class="wrapper">
            <button class="btn-exit"></button>
            <div class="col left">

                <div class="img"><img src="<?= $this->templates_assets ?>images/element-05.png" loading="lazy"></div>

            </div>
            <div class="col right">

                <div class="form-block">
                    <h1 class="heading">Quên Mật Khẩu</h1>

                    <form class="form" id="form-forget-password">
                        <div class="form-group">
                            <input name="email" type="text" class="form-control input-account" placeholder="Email">
                            <!-- <div class="form-text">Thông báo lỗi</div> -->
                        </div>
                        <button type="submit" class="btn">GỬI</button>
                        <div class="what">Bạn đã nhớ tài khoản :D. Hãy? <a href="<?= urlRoute('login') ?>">Đăng nhập</a></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- end Main -->