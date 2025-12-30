<?php if (!empty($is_review)) : ?>
  <div class="app" style="background-image: url(public/game/images/bg-01.webp);" id="replay-game"></div>
<?php elseif (!empty($is_training)) : ?>
  <div class="app" style="background-image: url(public/game/images/bg-01.webp);" id="training-game"></div>
<?php else : ?>
  <div class="app" style="background-image: url(public/game/images/bg-01.webp);" id="play-game"></div>
<?php endif; ?>

<?php
$this->load->view($this->template_path . '_block/cards.php');
$this->load->view($this->template_path . '_block/points.php');
?>