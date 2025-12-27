$(document).ready(function () {
    Helper.csrfAjaxLoad();
    CHECK_STATUS.init();
    POPUP.init();
    SELECT_DATE.init();
    FORM_INFO.init();


    // Chart initialization moved to initRadarChart()

    let turn = $('.app').data('turn');

    function scrollTo() {
        if ($('.lv-' + turn).length <= 0) return;
        $('.lv-' + turn)[0].scrollIntoView({
            behavior: "smooth",
            block: "center"
        });
    }

    scrollTo();
    window.addEventListener('orientationchange', scrollTo, false);
    window.addEventListener("resize", scrollTo, false);

    setTimeout(() => {
        if (!$(document).scrollTop()) scrollTo();
    }, 2000);

    let audio_bg = new Audio(base_url + 'public/game/audio/bg_game.mp3');
    if (window.location.href.includes('hocbai/nhiemvu')) {
        audio_bg.pause();
        return;
    }
    audio_bg.addEventListener('ended', function () {
        this.currentTime = 0;
        this.play();
    }, false);

    if ($('.menu')) {

        let isAutoPlay = getCookie('dq_play_audio_background');
        if (!isAutoPlay) {
            var promise = audio_bg.play();
            if (promise !== undefined) {
                promise.catch(error => {
                    $('.menu .btn-menu.music').addClass('active');
                });
            }
        } else {
            $('.menu .btn-menu.music').addClass('active');
        }

        $('.menu .btn-menu.music').on('click', function () {
            $(this).toggleClass('active');
            setTimeout(() => {
                if ($(this).attr("class").split(/\s+/).includes('active')) {
                    setCookie('dq_play_audio_background', 1);
                    audio_bg.pause();
                } else {
                    setCookie('dq_play_audio_background', 0);
                    audio_bg.play();
                }
            }, 100)
        })
    }

    $(document).on("click", "a, button", function () {
        playAudio(base_url + 'public/guide/audio/click.mp3');
    })

    // $('.slider-thebai .game-04').slick({
    //     infinite: false,
    //     slidesToShow: 4,
    //     // slidesToScroll: 1,
    //     arrows: true,
    //     pauseOnHover: false,
    //     swipeToSlide: true,
    //     dots: false
    // });
    $('#resetAccount').on("click", function () {
        const secret = getCookie('account_secret');

        new Ajax()
            .call(base_url + "api/account/reset?token=" + secret, [])
            .then((data) => {
                location.reload();
            });
    });

});

function playAudio(url, isLoop = false) {
    let audio = new Audio(url);
    if (url.includes('bg_game.mp3') && window.location.href.includes('hocbai/nhiemvu')) {
        audio.pause();
        return;
    }
    audio.oncanplaythrough = (event) => {
        var playedPromise = audio.play();
        if (playedPromise) {
            playedPromise.catch((e) => {
                console.log(e)
                if (e.name === 'NotAllowedError' || e.name === 'NotSupportedError') {
                    console.log(e.name);
                }
            }).then(() => {
                // console.log("playing sound !!!");
            });
        }
    }

    if (isLoop) {
        audio.addEventListener('ended', function () {
            this.currentTime = 0;
            this.play();
        }, false);
    }
    return audio;
}

function setCookie(name, value, days = 360) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

const CHECK_STATUS = {
    init: function () {
        let url = new URL(window.location.href);
        switch (url.searchParams.get("status")) {
            case 'error':
                CHECK_STATUS.error();
                break;
        }
    },

    error: function () {
        setTimeout(() => {
            Message.show('Có lỗi xãy ra, vui lòng thứ lại', true);
        }, 300)
    }
}

const POPUP = {
    init: function () {
        this.toggle('info');
        this.toggle('password');
        this.toggle('medal');
        this.toggle('points', () => {
            if (!window.myRadarChart) {
                initRadarChart();
            }
        });
        this.toggle('settings');
        this.toggle('confirm_reset');
        this.toggle('cards', () => {
            if ($('.slider-thebai .game-04').hasClass('slick-initialized')) {
                $('.slider-thebai .game-04').slick('setPosition');
                $('.slider-thebai .game-04').slick('refresh');
                $('.slider-thebai .game-04').slick('slickGoTo', 0);
            } else {
                $('.slider-thebai .game-04').slick({
                    infinite: false,
                    slidesToShow: 4,
                    // slidesToScroll: 1,
                    arrows: true,
                    pauseOnHover: false,
                    swipeToSlide: true,
                    dots: false
                });
            }
        });
    },

    toggle: function (item, callback) {
        let block = $('.info-user.' + item);
        let app = $('.app');

        $('.btn-menu.' + item).on("click", function () {
            app.css('filter', 'brightness(40%)');
            block.slideDown("slow", function () {
                if (typeof callback !== "undefined") {
                    callback();
                }
            });
        });

        $('.close-info-user').on("click", function () {
            app.css('filter', 'unset');
            block.slideUp("slow");
        });

        $(document).mouseup(function (e) {
            var isVisible = block.css('display') == "block";
            if (!block.is(e.target) && block.has(e.target).length === 0 && isVisible) {
                block.slideUp("slow");
                app.css('filter', 'unset');
            }
        });
    }
}

const SELECT_DATE = {
    init: function () {
        let qntYears = 20;
        let selectYear = $("#select-year");
        let selectMonth = $("#select-month");
        let selectDay = $("#select-day");
        let currentYear = new Date().getFullYear();

        for (var y = 0; y < qntYears; y++) {
            let date = new Date(currentYear);
            let yearElem = document.createElement("option");
            yearElem.value = currentYear
            yearElem.textContent = currentYear;
            selectYear.append(yearElem);
            currentYear--;
        }

        for (var m = 1; m <= 12; m++) {
            let monthElem = document.createElement("option");
            monthElem.value = m;
            monthElem.textContent = m;
            selectMonth.append(monthElem);
        }

        var d = new Date();
        var month = d.getMonth();
        var year = d.getFullYear();
        var day = d.getDate();

        if (!isNaN(parseInt(selectYear.data('value')))) year = parseInt(selectYear.data('value'));
        if (!isNaN(parseInt(selectMonth.data('value')))) month = parseInt(selectMonth.data('value'));
        if (!isNaN(parseInt(selectDay.data('value')))) day = parseInt(selectDay.data('value'));

        selectYear.val(year);
        selectYear.on("change", AdjustDays);
        selectMonth.val(month);
        selectMonth.on("change", AdjustDays);

        AdjustDays();
        selectDay.val(day)

        function AdjustDays() {
            var year = selectYear.val();
            var month = parseInt(selectMonth.val());
            var day = selectDay.val();
            selectDay.empty();

            //get the last day, so the number of days in that month
            var days = new Date(year, month, 0).getDate();

            //lets create the days of that month
            for (var d = 1; d <= days; d++) {
                var dayElem = document.createElement("option");
                dayElem.value = d;
                dayElem.textContent = d;
                selectDay.append(dayElem);

                if (d === days) {
                    if (parseInt(day) > d) day = 1;
                    selectDay.val(day);
                }
            }
        }
    }
}

const FORM_INFO = {
    init: function () {
        let url = base_url + 'api/account/update?token=' + getCookie('account_secret');
        Form.post('#form-update-account', url, (res, _this) => {
            FORM_INFO.message(res);
        });

        let urlUpdatePassword = base_url + 'api/account/password?token=' + getCookie('account_secret');
        Form.post('#form-update-password', urlUpdatePassword, (res, _this) => {
            FORM_INFO.message(res);
            _this.reset('#form-update-password');
        });
        this.avatar();
    },
    message: function (res) {
        res = JSON.parse(res);
        let isError = parseInt(res.code) !== 200;
        Message.show(res.message, isError);
    },
    avatar: function () {
        $('#avatar').on("input", function () {
            let image = URL.createObjectURL(event.target.files[0]);
            $('.image-avatar img').attr('src', image);
        });
    }
}

function initRadarChart() {
    const ctx = document.getElementById("barChart").getContext("2d");

    let dataChartPoint = [0, 0, 0, 0, 0, 0, 0, 0];

    if (typeof dataPoint === 'string') {
        dataPoint = JSON.parse(dataPoint);
    }
    
    Object.keys(dataPoint).map((e, i) => {
        const number = Number(dataPoint[e]);
        if (number >= 80) {
            dataChartPoint[e - 1] = number + (150 - number) / 2 + 10;
        } else if (number >= 60) {
            dataChartPoint[e - 1] = number + (120 - number) / 2 + 10;
        } else if (number >= 40) {
            dataChartPoint[e - 1] = number + (90 - number) / 2 + 10;
        } else {
            dataChartPoint[e - 1] = number + (40 - number) / 2 + 10;
        }
    });
    
    const options = {
        type: 'radar',
        data: {
            labels: ["", "", "", "", "", "", "", ""],
            datasets: [
                {
                    label: 'point',
                    data: dataChartPoint,
                    backgroundColor: "rgba(255,255,255,0.17)",
                    borderColor: "rgba(255,255,255,0.83)",
                    pointBackgroundColor: "#fff",
                    borderWidth: 1
                },
                {
                    label: 'bg1',
                    "backgroundColor": "#ee4646",
                    "pointRadius": 0,
                    "borderWidth": 0,
                    lineTension: 0.3,
                    "data": [60, 60, 60, 60, 60, 60, 60, 60]
                },
                {
                    label: 'bg2',
                    "backgroundColor": "#f4773e",
                    "pointRadius": 0,
                    "borderWidth": 0,
                    lineTension: 0.3,
                    "data": [90, 90, 90, 90, 90, 90, 90, 90]
                },
                {
                    label: 'bg3',
                    "backgroundColor": "#f7d155",
                    "pointRadius": 0,
                    "borderWidth": 0,
                    lineTension: 0.3,
                    "data": [120, 120, 120, 120, 120, 120, 120, 120]
                },
                {
                    label: 'bg4',
                    "backgroundColor": "#477ce6",
                    "pointRadius": 0,
                    "borderWidth": 0,
                    lineTension: 0.3,
                    "data": [150, 150, 150, 150, 150, 150, 150, 150]
                }
            ]
        },
        options: {
            scales: {
                r: {
                    min: 0,
                    max: 150,
                    stepSize: 25,
                    beginAtZero: true,
                    grid: {
                        circular: true,
                        color: "transparent",
                    },
                    ticks: {
                        display: false,
                        stepSize: 30
                    },
                    textStrokeColor: 'rgb(54, 162, 235)',
                    color: 'rgba(240, 240, 240, 0.5)',
                    backdropColor: 'rgb(47, 56, 62)',
                    angleLines: {
                        backgroundColor: 'rgb(255,255,255)',
                    },
                    pointLabels: {
                        color: ["#ee4646", "#f4773e", "#f7d155", "#477ce6"],
                        font: {
                            size: 18,
                            family: "\"Roboto\", sans-serif",
                            weight: 800
                        }
                    },
                },
            },
            plugins: {
                legend: {
                    display: false
                },
            },
            title: {
                "display": false
            },
        }
    }

    window.myRadarChart = new Chart(ctx, options);
}

