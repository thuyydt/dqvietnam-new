const generatePassword = () => {
    return Math.random().toString(36).slice(-8);
}
const CONSTANTS = {
    NO_IMAGE: '/public/admin/img/no-photo.webp'
}
const toDate = (key, row) => {
    if (!key) {
        return '---';
    }
    return moment(key).format('DD/MM/YYYY HH:mm')
}
const stripHtml = (html) => {
    if (!html) return "";
    let tmp = document.createElement("DIV");
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || "";
}
const API_URL = '/v2';
//const API_URL = 'http://dqvietnam.local/hook/api';
const Server = axios.create({
    baseURL: API_URL,
    headers: {
        'Content-Type': 'application/json',
    },
});
const toList = (response) => {
    const pagination = {
        total: response.data.total,
        current: response.data.current_page,
        pageSize: response.data.per_page
    }
    return {dataSource: response.data.data, pagination};
}
const API_V2 = {
    ACTIVE_CODE: {
        GET: async (params = {}) => {
            try {
                const res = await Server.get('/activation', {params});
                return toList(res);
            } catch (e) {
                message.error(e.message);
            }
        },
        CREATE: async (data = []) => {
            try {
                return await Server.post('/activation', data);
            } catch (e) {
                message.error(e.response.data.message);
            }
        },
        DELETE: async (id) => {
            try {
                return await Server.delete(`/activation/${id}`);
            } catch (e) {
                message.error(e.message);
            }
        },
    },
    ACTIVITIES: {
        GET: async (params = {}) => {
            try {
                const res = await Server.get('/auth/activities', {params});
                return toList(res);

            } catch (e) {
                message.error(e.message);
            }
        },
    },
    SETTING: {
        GET: async (params = {}) => {
            try {
                return await Server.get('/setting', {params});
            } catch (e) {
                message.error(e.message);
            }
        },
        CREATE: async (data = []) => {
            try {
                return await Server.post('/setting', data);
            } catch (e) {
                message.error(e.message);
            }
        }
    },
    USER: {
        GET: async (params = {}) => {
            const res = await Server.get('/user', {params});
            return toList(res);
        },
        GET_ROLE: async (params = {}) => {
            const res = await Server.get('/user/roles', {params});
            return res.data;
        },
        CHANGE_STT: async (accountId) => {
            try {
                await Server.put(`/user/payment/${accountId}`);
                message.success("Cập nhật trạng thái thành công!")
            } catch (e) {
                message.error(stripHtml(e.response?.data?.message || e.message));
            }
        },
        CREATE: async (data) => {
            try {
                await Server.post('/user', data);
                message.success("Thêm tài khoản thành công!")
            } catch (e) {
                message.error(stripHtml(e.response?.data?.message || e.message));
            }
        },
        UPDATE: async (accountId, data) => {
            try {
                await Server.put(`/user/${accountId}`, data);
                message.success("Cập nhật tài khoản thành công!")
            } catch (e) {
                message.error(stripHtml(e.response?.data?.message || e.message));
            }
        },
        DEL: async (accountId) => {
            try {
                await Server.delete(`/user/${accountId}`);
                message.success("Xóa tài khoản thành công!")
            } catch (e) {
                message.error(stripHtml(e.response?.data?.message || e.message));
            }
        }
    },
    ACCOUNT: {
        GET: async (params = {}) => {
            const res = await Server.get('/account', {params});
            return toList(res);
        },
        CHANGE_STT: async (accountId) => {
            try {
                await Server.put(`/account/payment/${accountId}`);
                message.success("Cập nhật trạng thái thành công!")
            } catch (e) {
                message.error(stripHtml(e.response?.data?.message || e.message));
            }
        },
        CREATE: async (data) => {
            try {
                await Server.post('/account', data);
                message.success("Thêm tài khoản thành công!")
            } catch (e) {
                message.error(stripHtml(e.response?.data?.message || e.message));
            }
        },
        UPDATE: async (accountId, data) => {
            try {
                await Server.put(`/account/${accountId}`, data);
                message.success("Cập nhật tài khoản thành công!")
            } catch (e) {
                message.error(stripHtml(e.response?.data?.message || e.message));
            }
        },
        DEL: async (accountId) => {
            try {
                await Server.delete(`/account/${accountId}`);
                message.success("Xóa tài khoản thành công!")
            } catch (e) {
                message.error(stripHtml(e.response?.data?.message || e.message));
            }
        }
    },
    SCHOOL: {
        GET: async (params = {}) => {
            const res = await Server.get('/school', {params});
            return toList(res);
        },
    },
    PAYMENT: {
        GET: async (params = {}) => {
            const res = await Server.get('/payment', {params});
            return toList(res);
        },
    }
}

