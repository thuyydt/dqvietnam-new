
$(function () {
  $(document).on("click", "a", function () {
    playAudio(base_url + 'public/guide/audio/click.mp3');
  })
})

function playAudio(url) {
  new Audio(url).play();
}
