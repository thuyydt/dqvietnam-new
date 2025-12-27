
Helper.csrfAjaxLoad();

$(function () {
    LOAD.init();
})


var LOAD = {
    init: function () {
        this.load_active_menu(".s-nav", 1);
    },

    load_active_menu: function (element, activeALlParent, url) {
        if (url === undefined) {
            url = current_url.split("/#")[0];
        }
        let page_detail = $(".detail-page");
        if (page_detail.length) {
            url = page_detail.data("url");
        }
        const menuElementMain = $(element + ' a[href="' + url + '"]');
        if (activeALlParent === 1) {
            menuElementMain.addClass("active");
        } else {
            menuElementMain
                .addClass("active")
                .parents("ul")
                .css("display", "block");
        }
    }
};