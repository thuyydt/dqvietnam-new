<div class="info-user medal" style="display: none">
    <div class="info-user__wrapper v3">

        <div class="heading">THU THẬP HUY HIỆU</div>

        <div class="group-item-02">

            <?php for ($i = 1; $i <= 8; $i++) {
                $k = $i * 10; ?>
                <div class="item">
                    <div class="item-wrapper <?= $turn > $k ? 'active' : '' ?>">
                        <img src="public/game/list/images/ruong.png" class="statu-1" loading="lazy"/>
                        <img src="public/game/list/images/<?= $i ?>.png" class="statu-2" loading="lazy"/>
                    </div>
                </div>
            <?php } ?>

        </div>

    </div>
</div>
