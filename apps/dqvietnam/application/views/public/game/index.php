<nav class="menu">
    <div class="inner">
        <a href="javascript:;" class="btn-menu info">
            <div class="avatar-menu">
                <img class="lazy" src="<?= empty($account->avatar) ? 'public/game/images/avatar.png' : getImageThumb($account->avatar) ?>" loading="lazy"/>
            </div>
        </a>
        <button type="button" class="btn-menu music">
            <img class="statu-1 lazy" src="public/game/list/images/btn-02.png" loading="lazy"/>
            <img class="statu-2 lazy" src="public/game/list/images/btn-02-h.png" loading="lazy"/>
        </button>
        <a href="javascript:;" class="btn-menu points"><img class="lazy" src="public/game/list/images/btn-03.png" loading="lazy"/></a>
        <a href="javascript:;" class="btn-menu medal"><img  class="lazy" src="public/game/list/images/btn-04.png" loading="lazy"/></a>
        <a href="javascript:;" class="btn-menu cards"><img  class="lazy" src="public/game/list/images/btn-05.png" loading="lazy"/></a>
    </div>
</nav>

<?php if ($turn > 80) : ?>
    <div class="btn-common-game">
        <a href="<?= urlRoute('report') ?>" class="btn btn-01">Xem Báo Cáo</a>
        <a href="javascipt:;" class="btn-menu confirm_reset btn btn-01">Chơi Lại</a>
    </div>
<?php endif; ?>

<div class="app" data-turn="<?= $turn ?>">
    <img src="public/game/list/images/bg-main.jpeg" class="bg-main lazy" id="bg-list-main" loading="lazy"/>

    <?php for ($i = 1; $i <= 19; $i++) { ?>
        <div class="e e-<?= $i <= 9 ? '0' . $i : $i ?>"><img class="lazy" src="public/game/list/images/e-<?= $i ?>.png" loading="lazy"/></div>
    <?php } ?>

    <?php if ($turn > 80) : ?>
        <div class="e e-20"><img class="lazy" src="public/game/list/images/e-20.png" loading="lazy"/></div>
        <div class="e e-21"><img class="lazy" src="public/game/list/images/e-21.png" loading="lazy"/></div>
        <div class="e e-22"><img class="lazy" src="public/game/list/images/e-22.png" loading="lazy"/></div>
    <?php endif; ?>

    <?php
    for ($i = 1; $i <= 80; $i++) { ?>
        <?php if ($i > $turn) : ?>
            <a href="<?= urlRoute('hocbai/nhiemvu/' . $i) ?>" class="lv lv-<?= $i ?> disabled"><?= $i ?></a>
        <?php else : ?>
            <a href="<?= $i == $turn ? urlRoute('hocbai/nhiemvu/' . $i) : urlRoute('hocbai/review/' . $i) ?>"
               class="lv lv-<?= $i ?> <?= $i == $turn ? 'current-space' : '' ?>">
                <?= $i ?>
            </a>
        <?php endif ?>
    <?php } ?>

    <div class="end"></div>

</div>

<?php
$this->load->view($this->template_path . '_block/info.php');
$this->load->view($this->template_path . '_block/cards.php');
$this->load->view($this->template_path . '_block/medal.php');
$this->load->view($this->template_path . '_block/points.php');
$this->load->view($this->template_path . '_block/password.php');
$this->load->view($this->template_path . '_block/confirm_reset.php');
?>
