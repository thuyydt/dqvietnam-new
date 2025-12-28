const loadingIcon = `<div class="loadingio-spinner-ellipsis-mnaqrvpphi8">
    <div class="ldio-wdfcbcdcozs">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>`;

const API_URL = '/v2';
const Server = axios.create({
    baseURL: API_URL,
    headers: {
        'Content-Type': 'application/json',
    },
});
const setLoadPage = (show = false) => {
    if (show) {
        $("#loading").css('display', 'inline-block');
        //$("body").addClass('is-loading')
    } else {
        $("#loading").css('display', 'none');
        //$("body").removeClass('is-loading')
    }
}

const CLIENT_V2 = {
    AUTH: {
        PING: async () => {
            if (!AUTH_KEY) {
                return;
            }
            await Server.post('/auth/ping', {user_id: AUTH_KEY});
        },
        REGISTER: async (data, element = '') => {
            try {
                setLoadPage(true);
                $(element).attr('disabled', 'disabled');
                const res = await Server.post('/auth/register', data);
                if (res.data.success) {
                    Message.show('Đăng kí tài khoản thành công!', false);
                    const login = await (new Ajax().call(LOGIN.url, data));
                    Helper.setCookie('account_secret', login.data.access_token);
                    window.location.href = login.data.url_redirect ?? '/login?status=register_success'
                }
                if (res.data.message) {
                    const messages = Object.values(res.data.message);
                    messages.some(value => Message.show(value.shift(), true));
                }
            } catch (e) {
                // Handle API error response
                if (e.response && e.response.data) {
                    const errorData = e.response.data;
                    if (errorData.message) {
                        // If message is an object (validation errors)
                        if (typeof errorData.message === 'object') {
                            const messages = Object.values(errorData.message);
                            messages.forEach(msg => Message.show(msg, true));
                        } else {
                            // If message is a string
                            Message.show(errorData.message, true);
                        }
                    } else {
                        Message.show(e.message, true);
                    }
                } else {
                    Message.show(e.message, true);
                }
            } finally {
                setLoadPage(false);
                $(element).removeAttr('disabled')
            }
        },
        RESET_PWD: async (data, element) => {
            try {
                $(element).attr('disabled', 'disabled');
                const res = await Server.post('/account/password', data);
                if (res.data.success) {
                    Message.show(res.data.success, false);
                }
            } catch (e) {
                Message.show(e.response.data.error, true);
            } finally {
                $(element).removeAttr('disabled')
            }
        },
        LOGIN: async (data) => {
            try {
                const res = await Server.post('/auth/login', data);
                console.log("RES", res);
            } catch (e) {
                Message.show(_data.message, true);
            }
        }
    }
}

function pingpong() {
    CLIENT_V2.AUTH.PING();
}
