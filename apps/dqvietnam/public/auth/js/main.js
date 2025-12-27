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

// accordion
const accordion = $('.js-tabs');
if (accordion) {
  let accordionButtons = $('.tab-btn');
  let accordionBodys = $('.tab-box');
  const ACTIVE_CLASS = 'active';

  for (let i = 0; i < accordionButtons.length; i++) {
    const accordionButton = accordionButtons[i];
    const accordionBody = accordionBodys[i];
    $(accordionButton).on('click', function () {
      $(this).addClass(ACTIVE_CLASS).siblings().removeClass(ACTIVE_CLASS);
      $(accordionBody).addClass(ACTIVE_CLASS).siblings().removeClass(ACTIVE_CLASS);
    });
  }
}

// countdown
function countdown(
  containerDays,
  containerHours,
  containerMinutes,
  containerSeconds,
  numberDay
) {
  function format(v) {
    return (v.toString().length == 1) ? '0' + v : v;
  }

  const now = new Date();

  let currentDate = Date.now();
  now.setTime(now.getTime() + (86400000 * numberDay)); //1 day = 86400000s
  const endDateString = now.toISOString();
  const endDateTime = Date.parse(endDateString);
  const endDate = new Date(endDateTime);

  const $days = $(containerDays);
  const $hours = $(containerHours);
  const $mins = $(containerMinutes);
  const $secs = $(containerSeconds);
  console.log($days)

  setInterval(function () {

    currentDate = Date.now();
    if (currentDate < endDate) {

      const time = endDate - currentDate;

      const seconds = Math.floor((time / 1000) % 60);
      const minutes = Math.floor((time / 60000) % 60);
      const hours = Math.floor((time / 3600000) % 24);
      const days = Math.floor((time / 86400000));

      $secs.text(format(seconds));
      $mins.text(format(minutes));
      $hours.text(format(hours));
      $days.text(days);

    }

  }, 100);
}

$(`
  <button type="button" class="quantity-button quantity-up">+</button>
  <button type="button" class="quantity-button quantity-down">-</button>
`).insertAfter('.quantity input');
$('.quantity').each(function () {
  var spinner = $(this),
    input = spinner.find('input[type="number"]'),
    btnUp = spinner.find('.quantity-up'),
    btnDown = spinner.find('.quantity-down'),
    min = input.attr('min'),
    max = input.attr('max');

  btnUp.click(function () {
    var oldValue = parseFloat(input.val());
    if (oldValue >= max) {
      var newVal = oldValue;
    } else {
      var newVal = oldValue + 1;
    }
    spinner.find("input").val(newVal);
    spinner.find("input").trigger("change");
  });

  btnDown.click(function () {
    var oldValue = parseFloat(input.val());
    if (oldValue <= min) {
      var newVal = oldValue;
    } else {
      var newVal = oldValue - 1;
    }
    spinner.find("input").val(newVal);
    spinner.find("input").trigger("change");
  });

});

$('.slider-item').slick({
  infinite: false,
  speed: 300,
  slidesToShow: 3,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 2
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 1
      }
    }
  ]
});
