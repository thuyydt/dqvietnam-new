$(function () {
    checkRotate();
    window.addEventListener('orientationchange', checkRotate, false);
    window.addEventListener("resize", checkRotate, false);

    $(document).on("click", "a, button", function () {
        const actionSound = playAudio(base_url + 'public/guide/audio/click.mp3');
        actionSound.volume = localStorage.getItem('sound') ?? 0.2;
    })

    POPUP.init();
    $('.lazy').Lazy();


    // $('.slider-thebai .game-04').slick({
    //     infinite: false,
    //     slidesToShow: 4,
    //     // slidesToScroll: 1,
    //     arrows: true,
    //     pauseOnHover: false,
    //     swipeToSlide: true,
    //     dots: false
    // });

    var ctx = document.getElementById("barChart").getContext("2d");

    let dataChartPoint = [0, 0, 0, 0, 0, 0, 0, 0];
    dataPoint = JSON.parse(dataPoint);
    Object.keys(dataPoint).map((e, i) => {
        dataChartPoint[e - 1] = dataPoint[e];
    });

    var options = {
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

    new Chart(ctx, options);

    $('#resetAccount').on("click", function () {
        const secret = getCookie('account_secret');

        new Ajax()
            .call(base_url + "api/account/reset?token=" + secret, [])
            .then((data) => {
                location.reload();
            });
    });
})

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


const POPUP = {
    init: function () {
        this.toggle('points');
        this.toggle('cards', () => {
            $('.slider-thebai .game-04').slick('slickGoTo', 0);
        });
    },
    showBg: function (isShow) {
        let app = $('.app');
        if (isShow) {
            app.css('filter', 'brightness(40%)');
        } else {
            app.css('filter', 'none');
        }
    },
    toggle: function (item, callback) {
        let block = $('.info-user.' + item);
        let app = $('.app');

        $('.btn-menu.' + item).on("click", function () {
            block.slideDown("slow");
            app.css('filter', 'brightness(40%)')
            if (typeof callback !== "undefined") {
                callback();
            }
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

function checkRotate() {
    if (screen.width < screen.height) {
        switch (window.orientation) {
            case -90:
            case 90:

                setTimeout(() => {
                    scaleWhenResize()
                }, 1000)

                break;
        }
    } else {
        setTimeout(() => {
            scaleWhenResize()
        }, 1000)
    }
}

function scaleWhenResize() {

    let width = $(document).width();
    let height = $(document).height();

    let widthBlock = height * 1.7;

    let scale = ((width / widthBlock) * 100) / 100;

    if (scale > 1) {
        $('body').css({"overflow-x": "auto"})

        $('.app').css({
            "width": "100%",
            "overflow": "hidden",
            "-webkit-transform": `unset`,
            "transform": `unset`
        });

        return;
    }

    $('body').css({"overflow-x": "hidden"})

    $('.app').css({
        "width": "auto",
        "overflow": "initial",
        "-webkit-transform": `scale(${scale - 0.04})`,
        "transform": `scale(${scale - 0.04})`
    });
}

function playAudio(url, isLoop = false) {
    let audio = new Audio(url);
    //audio.play();

// when the sound has been loaded, execute your code
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

    //audio.volume = localStorage.getItem('sound') ?? 0.2;
    if (isLoop) {
        audio.addEventListener('ended', function () {
            this.currentTime = 0;
            this.play();
        }, false);
    }
    return audio;
}


function initCardSlide() {

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

