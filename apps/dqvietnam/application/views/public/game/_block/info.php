<div class="info-user info" style="display: none">
    <?php if (!empty($this->auth)) : ?>
        <form id="form-update-account" class="info-user__wrapper v1" action="" enctype="multipart/form-data">
            <div class="left">
                <div class="heading">THÔNG TIN HỌC VIÊN</div>
                <div class="form">

                    <div class="form-group">
                        <label for="full_name">Họ và tên</label>
                        <input name="full_name" id="full_name" value="<?= $account->full_name ?? '' ?>" type="text"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Giới tính</label>
                        <div class="group-input">
                            <div class="form-check">
                                <input <?= $account->gender == 1 ? 'checked' : '' ?>
                                        class="form-check-input" type="radio" name="gender" id="gender1" value="1">
                                <label class="form-check-label" for="gender1"> Nam </label>
                            </div>
                            <div class="form-check">
                                <input <?= $account->gender == 2 ? 'checked' : '' ?>
                                        class="form-check-input" type="radio" name="gender" id="gender2" value="2">
                                <label class="form-check-label" for="gender2"> Nữ </label>
                            </div>
                            <div class="form-check">
                                <input <?= $account->gender == 3 ? 'checked' : '' ?>
                                        class="form-check-input" type="radio" name="gender" id="gender3" value="3">
                                <label class="form-check-label" for="gender3"> Khác </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select-day">Ngày sinh</label>
                        <div class="group-input">
                            <?php $birthday = strtotime($account->birthday); ?>
                            <select id="select-day" name="dob"
                                    data-value="<?= !empty($birthday) ? date('d', $birthday) : date('d') ?>"
                                    class="form-control form-control-date form-control-day"></select>
                            <select id="select-month" name="mob"
                                    data-value="<?= !empty($birthday) ? date('m', $birthday) : date('m') ?>"
                                    class="form-control form-control-date form-control-month"></select>
                            <select id="select-year" name="yob"
                                    data-value="<?= !empty($birthday) ? date('Y', $birthday) : date('Y') ?>"
                                    class="form-control form-control-date form-control-year"></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="school">Trường</label>
                        <input type="text" name="school" id="school" class="form-control"
                               value="<?= $account->school ?? '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="email_parent">Email (cha/mẹ)</label>
                        <input type="text" name="email_parent" id="email_parent" class="form-control"
                               value="<?= $account->email_parent ?? '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone_parent">Điện thoại (cha/mẹ)</label>
                        <input type="text" name="phone_parent" id="phone_parent" class="form-control"
                               value="<?= $account->phone_parent ?? '' ?>">
                    </div>
                </div>
            </div>

            <div class="right">
                <div class="avatar-info">
                    <div class="image-avatar"><img
                                src="<?= empty($account->avatar) ? 'public/game/images/avatar.png' : getImageThumb($account->avatar) ?>"
                                alt="image-avatar"></div>
                    <label for="avatar" class="btn add-avatar">
                        <svg width="34" height="34" viewBox="0 0 34 34" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M29.376 7.20703H4.65796V27.369H29.376V7.20703Z" fill="white"/>
                            <path
                                    d="M9.51997 2.7207C5.77997 2.7207 2.71997 5.7807 2.71997 9.5207V24.4807C2.71997 28.2207 5.77997 31.2807 9.51997 31.2807H24.48C28.22 31.2807 31.28 28.2207 31.28 24.4807V9.5207C31.28 5.7807 28.22 2.7207 24.48 2.7207H9.51997ZM14.382 8.8407H19.652C20.23 8.8407 20.808 9.1467 21.114 9.6567L22.372 11.7307C22.542 12.0367 22.882 12.2407 23.256 12.2407H26.86C27.438 12.2407 27.88 12.6827 27.88 13.2607V24.1407C27.88 24.7187 27.438 25.1607 26.86 25.1607H7.13997C6.56197 25.1607 6.11997 24.7187 6.11997 24.1407V13.2607C6.11997 12.6827 6.56197 12.2407 7.13997 12.2407H10.778C11.118 12.2407 11.458 12.0367 11.662 11.7307L12.92 9.6567C13.226 9.1467 13.77 8.8407 14.382 8.8407ZM8.15997 9.5207H9.51997C9.89397 9.5207 10.2 9.8267 10.2 10.2007V10.8807H7.47997V10.2007C7.47997 9.8267 7.78597 9.5207 8.15997 9.5207ZM23.12 13.2607C22.746 13.2607 22.44 13.5667 22.44 13.9407C22.44 14.3147 22.746 14.6207 23.12 14.6207C23.494 14.6207 23.8 14.3147 23.8 13.9407C23.8 13.5667 23.494 13.2607 23.12 13.2607ZM17 13.6007C14.178 13.6007 11.9 15.8787 11.9 18.7007C11.9 21.5227 14.178 23.8007 17 23.8007C19.822 23.8007 22.1 21.5227 22.1 18.7007C22.1 15.8787 19.822 13.6007 17 13.6007ZM17 14.9607C19.074 14.9607 20.74 16.6267 20.74 18.7007C20.74 20.7747 19.074 22.4407 17 22.4407C14.926 22.4407 13.26 20.7747 13.26 18.7007C13.26 16.6267 14.926 14.9607 17 14.9607Z"
                                    fill="black"/>
                        </svg>
                    </label>
                    <input id="avatar" accept="image/*" type="file" name="avatar" value="<?= $account->avatar ?? '' ?>">
                </div>
                <div class="name"><?= $account->username ?? '' ?></div>
                <a href="javascript:;" class="link btn-menu password">Đổi mật khẩu</a>
            </div>

            <div class="btn-group">
                <button type="button" class="btn close-info-user">Hủy</button>
                <button type="submit" class="btn">Lưu</button>
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
