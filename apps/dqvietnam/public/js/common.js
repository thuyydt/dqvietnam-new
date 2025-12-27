$(function () {
    if ($('#notify-rotate').length) {
        checkRotateScreen();

        window.addEventListener('orientationchange', checkRotateScreen, false);
        window.addEventListener("resize", checkRotateScreen, false);
    }
});

function checkRotateScreen() {
    const isGame = window.location.pathname.includes('game');
    const isGuide = window.location.pathname.includes('guide');
    if (screen.width < screen.height && (isGame || isGuide)) {
        switch (window.orientation) {
            case -90:
            case 90:
                $('#notify-rotate').hide();
                $('body').css('overflow', 'auto');
                break;
            default:
                $('#notify-rotate').show();
                $('body').css('overflow', 'hidden');
                break;
        }
    } else {
        $('#notify-rotate').hide();
        $('body').css('overflow', 'auto');
    }
}

