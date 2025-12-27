Helper.csrfAjaxLoad();

(function ($) {
    $.fn.clickToggle = function (func1, func2) {
        var funcs = [func1, func2];
        this.data('toggleclicked', 0);
        this.click(function () {
            var data = $(this).data();
            var tc = data.toggleclicked;
            $.proxy(funcs[tc], this)();
            data.toggleclicked = (tc + 1) % 2;
        });
        return this;
    };
}(jQuery));

(function ($) {
    $('#btnPayment').click(function () {
        const code = $(this).prev().val();
        const userId = $(this).next().val();
        if (!code) {
            Message.show('Vui lòng nhập mã thanh toán', true);
            return;
        }
        $.ajax({
            type: 'POST',
            url: '/v2/auth/active-payment',
            data: {code, userId},
            success: (response) => {
                Message.show('Kích hoạt tài khoản thành công? trình duyệt sẽ chuyển hươg sau 3s nữa', false);
                setTimeout(() => {
                    window.location.replace('/hocbai')
                }, 3000)
            },
            error: (error) => {
                console.log('Error', error)
                Message.show(error.responseJSON.message, true);
            }
        });
    })
}(jQuery));


$(function () {

    TOGGLE_PASSWORD.init($('#form-login .group-password'))
    TOGGLE_PASSWORD.init($('#form-register-personal .group-password'))
    TOGGLE_PASSWORD.init($('#form-register-personal .group-re-password'))

    CHECK_STATUS.init();
    LOGIN.init();
    FORGOT_PASSWORD.init();
    REGISTER_PERSONAL.init();
    REGISTER_SCHOOL.init();
})

const CHECK_STATUS = {
    init: function () {
        let url = new URL(window.location.href);
        switch (url.searchParams.get("status")) {
            case 'register_success':
                CHECK_STATUS.register_success();
                break;
            case 'login_try_game':
                CHECK_STATUS.login_try_game();
                break;
            case 'have_to_pay':
                CHECK_STATUS.have_to_pay();
                break;
            case 'forgot_password':
                CHECK_STATUS.forgot_password();
                break;
        }
    },

    register_success: function () {
        setTimeout(() => {
            Message.show('Bạn đã đăng ký thành công', false);
        }, 300)
    },

    forgot_password: function () {
        setTimeout(() => {
            Message.show('Bạn đã thay đổi mật khấu thành công, vui lòng đăng nhập', false);
        }, 300)
    },

    login_try_game: function () {
        setTimeout(() => {
            Message.show('Bạn phải đăng nhập để tiếp tục', false);
        }, 300)
    },

    have_to_pay: function () {
        setTimeout(() => {
            Message.show('Bạn phải thanh toán để tiếp tục chơi', true);
        }, 300)
    }
}

const LOGIN = {
    page: $('#page-login'),
    url: '/api/auth/login',
    init: function () {
        if (this.page.length) {
            Form.post('#form-login', this.url, async (_data, _this) => {
                let isError = parseInt(_data.code) !== 200;
                Message.show(_data.message, isError);

                if (_data.code === 200) {
                    // Helper.setCookie('account_secret', _data.data.access_token);
                    await Server.post('/auth/activities', {user_id: _data.data.authKey});
                    var url_string = window.location.href;
                    var url = new URL(url_string);
                    var redirect = url.searchParams.get("redirect");
                    if (isNaN(redirect)) {
                        window.location.href = redirect;
                    } else {
                        window.location.href = _data.data.url_redirect;
                    }
                }
            })
        }
    }
}

const REGISTER_PERSONAL = {
    page: $('#page-register-personal'),
    url: base_url + 'api/auth/register',
    init: async function () {
        if (this.page.length) {
            Form.post('#form-register-personal', this.url, this.callback)
        }
    },
    callback: function (_data, _this) {
        let isError = parseInt(_data.code) !== 200;
        Message.show(_data.message, isError);

        if (parseInt(_data.code) === 200) {
            new Ajax()
                .call(LOGIN.url, _this.getData('#form-register-personal'))
                .then((res) => {
                    // Helper.setCookie('account_secret', res.data.access_token);
                    window.location.href = base_url + 'login?status=register_success'
                })
        }
    }
}

const REGISTER_SCHOOL = {
    page: $('#page-register-schools'),
    url: base_url + 'api/auth/register_schools',
    init: function () {
        if (this.page.length) {
            Form.post('#form-register-schools', this.url, this.callback)
        }
    },
    callback: function (_data, _this) {
        let isError = parseInt(_data.code) !== 200;
        Message.show(_data.message, isError);

        if (parseInt(_data.code) === 200) {
            _this.reset('#form-register-schools');
        }
    }
}

const FORGOT_PASSWORD = {
    page: $('#page-forget-password'),
    url: base_url + 'api/auth/forgotPassword',
    init: function () {
        if (this.page.length) {

            Form.post('#form-forget-password', this.url, (_data, _this) => {
                let isError = parseInt(_data.code) !== 200;
                Message.show(_data.message, isError);

                if (_data.code === 200) {
                    window.location.href = base_url + 'login?status=forgot_password';
                }
            })
        }
    }
}

const TOGGLE_PASSWORD = {
    init(target) {
        target.css("position", "relative");
        target.append(this.tag());

        this.action(target);
    },

    action(target) {
        let password = target.find('input');
        target.find('.eye-password').on("click", function () {
            $(this).clickToggle(
                function () {
                    $(this).addClass('on');
                    password.attr('type', 'text');
                },
                function () {
                    password.attr('type', 'password');
                    $(this).removeClass('on');
                }
            );
        });
    },

    tag() {
        return `<svg class="eye-password" width="24" height="24" xmlns="http://www.w3.org/2000/svg"
                     fill-rule="evenodd" clip-rule="evenodd">
                    <path id="off" d="M8.137 15.147c-.71-.857-1.146-1.947-1.146-3.147 0-2.76 2.241-5 5-5 1.201 0 2.291.435 3.148 1.145l1.897-1.897c-1.441-.738-3.122-1.248-5.035-1.248-6.115 0-10.025 5.355-10.842 6.584.529.834 2.379 3.527 5.113 5.428l1.865-1.865zm6.294-6.294c-.673-.53-1.515-.853-2.44-.853-2.207 0-4 1.792-4 4 0 .923.324 1.765.854 2.439l5.586-5.586zm7.56-6.146l-19.292 19.293-.708-.707 3.548-3.548c-2.298-1.612-4.234-3.885-5.548-6.169 2.418-4.103 6.943-7.576 12.01-7.576 2.065 0 4.021.566 5.782 1.501l3.501-3.501.707.707zm-2.465 3.879l-.734.734c2.236 1.619 3.628 3.604 4.061 4.274-.739 1.303-4.546 7.406-10.852 7.406-1.425 0-2.749-.368-3.951-.938l-.748.748c1.475.742 3.057 1.19 4.699 1.19 5.274 0 9.758-4.006 11.999-8.436-1.087-1.891-2.63-3.637-4.474-4.978zm-3.535 5.414c0-.554-.113-1.082-.317-1.562l.734-.734c.361.69.583 1.464.583 2.296 0 2.759-2.24 5-5 5-.832 0-1.604-.223-2.295-.583l.734-.735c.48.204 1.007.318 1.561.318 2.208 0 4-1.792 4-4z"/>
                    <path id="on" d="M12.01 20c-5.065 0-9.586-4.211-12.01-8.424 2.418-4.103 6.943-7.576 12.01-7.576 5.135 0 9.635 3.453 11.999 7.564-2.241 4.43-6.726 8.436-11.999 8.436zm-10.842-8.416c.843 1.331 5.018 7.416 10.842 7.416 6.305 0 10.112-6.103 10.851-7.405-.772-1.198-4.606-6.595-10.851-6.595-6.116 0-10.025 5.355-10.842 6.584zm10.832-4.584c2.76 0 5 2.24 5 5s-2.24 5-5 5-5-2.24-5-5 2.24-5 5-5zm0 1c2.208 0 4 1.792 4 4s-1.792 4-4 4-4-1.792-4-4 1.792-4 4-4z"/>
                </svg>`
    }
}

const onRegister = async (element) => {
    const formData = $('#form-register-personal').serializeArray();
    const data = formData.reduce((obj, item) => ({...obj, [item.name]: item.value}), {})
    await CLIENT_V2.AUTH.REGISTER(data, element);
}

