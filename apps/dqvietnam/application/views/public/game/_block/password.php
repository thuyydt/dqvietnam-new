<div class="info-user password" style="display: none">
    <?php if (!empty($this->auth)) : ?>
        <form id="form-update-password" class="info-user__wrapper v3" action="">
            <div class="heading">THAY ĐỔI MẬT KHẨU</div>
            <div class="form">
                <input type="hidden" name="key" value="<?= $this->auth->id ?>"/>
                <div class="form-group">
                    <label for="password_old">Mật khẩu cũ</label>
                    <input name="password_old" id="password_old" type="password" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password_new">Mật khẩu mới</label>
                    <input name="password_new" id="password_new" type="password" class="form-control">
                </div>

            </div>
            <div class="btn-group" style="position: unset; float: right">
                <button type="button" class="btn close-info-user">Hủy</button>
                <button type="button" onclick="onResetPwd(this)" class="btn">Lưu</button>
            </div>
        </form>
    <?php else: ?>
        <div class="info-user__wrapper v1" style="height: 100%;">
            <div class="heading">BẠN HÃY ĐĂNG NHẬP ĐỄ TIẾP TỤC!</div>
            <div style="display: block; width: 100%;">
                <a href="<?= urlRoute('login?redirect=' . current_url()) ?>" class="btn btn-login-info">Đi đến trang
                    Đăng Nhập</a>
            </div>
        </div>
    <?php endif; ?>
</div>
