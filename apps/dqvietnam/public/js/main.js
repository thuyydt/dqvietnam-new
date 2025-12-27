// slideout
const slideout = $('.c-slideout');
if (slideout) {
  const body = $('body');
  const btn = $('.btn-toogle');
  const ACTIVE_CLASS = 'slideout-active';
  btn.on('click', function () {
    body.toggleClass(ACTIVE_CLASS);
  });
}

function playAudio(url) {
  new Audio(url).play();
}

$(function () {
  $(document).on("click", "a, button", function () {
    playAudio(base_url + 'public/guide/audio/click.mp3');
  })
})
