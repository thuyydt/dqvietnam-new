class Ajax {

    constructor(hasFile = false) {
        this.hasFile = hasFile;
    }

    call(url, data, type = 'POST') {
        return new Promise((resolve, reject) => {

            let options = {
                url: url,
                type: type,
                data: data,
                datatype: 'JSON',
                beforeSend: function () {

                },
                success: function (data) {
                    resolve(data);
                },
                error: function (xhr) {
                    reject(xhr);
                },
                complete: function () {

                },
            };

            if (this.hasFile) {
                options = {
                    ...options, ...{
                        cache: false,
                        processData: false,
                        contentType: false,
                    }
                }
            }

            $.ajax(options);
        })
    }
}

class Form {

    static getData(form) {
        return $(form).serializeArray().reduce(function (obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});
    }

    static fill(boxForm, data = {}, optionsSelect2 = {}) {

        return new Promise((resolve => {
            Object.keys(data).map(function (key, index) {

                let boxInput = $(boxForm).find(`[name="${key}"]`);

                switch (boxInput.attr('type')) {
                    case 'checkbox':
                        boxInput[0].checked = data[key];
                        break;
                    default:
                        boxInput.val(data[key]);
                        break;
                }

                $(boxForm).find(`[name="${key}"]`).val(data[key]);

                if (optionsSelect2 && optionsSelect2[key]) {

                    data[key].id = data[key]._id
                    Select.call(optionsSelect2[key], [data[key]]);

                }

            });

            resolve(data);
        }));

    }

    static validate(form, err) {
        // Ren err HTML
        $(form).find('.text-danger').remove();
        let errors = err;

        setTimeout(() => {
            Object.keys(errors).map(function (key, index) {
                let htmlError = `${errors[key]} `
                console.log(htmlError);
                console.log($(form)
                    .find(`[name="${key}"]`)
                    .closest('.form-group'))
                $(form)
                    .find(`[name="${key}"]`)
                    .closest('.form-group')
                    .append(htmlError);
            });
        }, 500)
    }

    static reset(form) {
        $(form)[0].reset();
        $(form).find('.invalid-feedback').html('');
    }

    static post(form, url, callback) {

        let _this = this;

        if (!$(document).find(form).length) return;

        $(document).on('submit', form, function (event) {
            event.preventDefault();

            let data;
            let hasFile = false;
            let _form = $(this);

            _form.find('button[type="submit"]').attr('disabled', 'disabled').addClass('loading');

            if ($(this).attr('enctype') === 'multipart/form-data') {
                data = new FormData(this);
                hasFile = true
            } else {
                data = Form.getData(this);
            }

            new Ajax(hasFile).call(url, data)
                .then((res) => {
                    _form.find('button[type="submit"]').removeAttr('disabled').removeClass('loading');
                    if (typeof callback === 'function') {
                        callback(res, _this);
                    }
                })
                .catch(err => {
                    _form.find('button[type="submit"]').removeAttr('disabled').removeClass('loading');
                    Form.validate(form, err);
                });
        });
    }
}

class Message {

    static init() {
        toastr.clear();

        toastr.options = {
            closeButton: true,
            positionClass: 'toast-bottom-right',
            onclick: null,
            showDuration: 1000,
            hideDuration: 1000,
            timeOut: 10000,
            extendedTimeOut: 1000,
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut'
        };
    }

    static show(message, error = true, type = '') {
        Message.init();

        let messageType = type != '' ? type : (error ? 'error' : 'success');

        toastr[messageType](message);
    }
}

class Helper {
    static buildQueryString(url, parameters) {
        Object.keys(parameters).forEach((key) => {
            (parameters[key] == null || parameters[key].length <= 0) && delete parameters[key]
        });
        let esc = encodeURIComponent;
        let queryString = Object.keys(parameters)
            .map(k => esc(k) + '=' + esc(parameters[k]))
            .join('&');
        if (queryString.length > 0) {
            url = url + "?" + queryString;
        }
        return url;
    }

    static _show_album(id) {
        $(document).on('click', id, function (e) {
            e.preventDefault();
            let id = $(this).data('id');
            console.log(album[id])
            var data = [];
            if (typeof album[id] === "object") {
                album[id].map((e) => {
                    var obj = {
                        src: media_url + e,
                    }
                    data.push(obj);
                });
            } else {
                if (album[id].length > 0) {
                    data.push({
                        src: album[id]
                    })
                }
            }

            $.fancybox.open(data, {
                loop: true,
                thumbs: {autoStart: false},
                height: 600,
                autoSize: false
            });
        })
    }

    static createCookie(name, value, days = 360) {
        var expires;

        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        } else {
            expires = "";
        }
        document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
    }

    static csrfAjaxLoad() {
        var csrfToken = $('meta[name="csrf-token"]');
        var csrfName = csrfToken.attr('data-name');
        var csrfValue = csrfToken.attr('content');
        $(document).ajaxSend(function (elm, xhr, s) {
            if (typeof s.contentType != 'undefined' && s.contentType !== false) {
                if (typeof s != "undefined") {
                    if (typeof s.data != "undefined") {
                        if (s.data !== '') {
                            s.data += '&';
                        }
                        s.data += csrfName + '=' + csrfValue;
                    }
                } else {
                    s[data] = {csrfName: csrfToken};
                }
            }
        });
    }

    static setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    static getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    static eraseCookie(name) {
        document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }
}