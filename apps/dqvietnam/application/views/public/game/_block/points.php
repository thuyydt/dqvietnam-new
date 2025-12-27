<div class="info-user points" style="display: none">
    <div class="info-user__wrapper v2">

        <div class="left">
            <div class="heading">ĐIỂM TRUNG BÌNH DQ</div>

            <div class="bieu-do">
                <!--                <div class="duong-tron">-->
                <!--                    <div class="circle circle-01"></div>-->
                <!--                    <div class="circle circle-02"></div>-->
                <!--                    <div class="circle circle-03"></div>-->
                <!--                    <div class="circle circle-04"></div>-->
                <!--                    <div class="line line-01"></div>-->
                <!--                    <div class="line line-02"></div>-->
                <!--                    <div class="line line-03"></div>-->
                <!--                    <div class="line line-04"></div>-->
                <div class="armorial" style="position: absolute; width: 100%; height: 100%">
                    <div class="list" style="position: relative; width: 100%; height: 100%">
                        <img class="item s1" src="public/game/list/images/armorial/1.png" alt="">
                        <img class="item s2" src="public/game/list/images/armorial/2.png" alt="">
                        <img class="item s3" src="public/game/list/images/armorial/3.png" alt="">
                        <img class="item s4" src="public/game/list/images/armorial/4.png" alt="">
                        <img class="item s5" src="public/game/list/images/armorial/5.png" alt="">
                        <img class="item s6" src="public/game/list/images/armorial/6.png" alt="">
                        <img class="item s7" src="public/game/list/images/armorial/7.png" alt="">
                        <img class="item s8" src="public/game/list/images/armorial/8.png" alt="">
                    </div>
                </div>
                <?php if ($turn >= 80) { ?>
                    <div class="info">
                        <div class="number"><?= $point['medium'] ?? 0 ?><br> Điểm</div>
                    </div>
                <?php } ?>
                <!--                </div>-->

                <canvas id="barChart" width="600" height="600"></canvas>


            </div>
        </div>

        <div class="right">
            <div class="heading">ĐIỂM 8 NĂNG LỰC DQ</div>

            <div class="group-item-01">
                <div class="item">
                    <div class="item-wrapper">
                        <img src="public/game/list/images/1.png" class="icon">
                        <div class="number"><?= $point['list'][1] ?? 0 ?></div>
                    </div>
                </div>
                <div class="item">
                    <div class="item-wrapper">
                        <img src="public/game/list/images/5.png" class="icon">
                        <div class="number"><?= $point['list'][5] ?? 0 ?></div>
                    </div>
                </div>
                <div class="item">
                    <div class="item-wrapper">
                        <img src="public/game/list/images/2.png" class="icon">
                        <div class="number"><?= $point['list'][2] ?? 0 ?></div>
                    </div>
                </div>
                <div class="item">
                    <div class="item-wrapper">
                        <img src="public/game/list/images/6.png" class="icon">
                        <div class="number"><?= $point['list'][6] ?? 0 ?></div>
                    </div>
                </div>
                <div class="item">
                    <div class="item-wrapper">
                        <img src="public/game/list/images/3.png" class="icon">
                        <div class="number"><?= $point['list'][3] ?? 0 ?></div>
                    </div>
                </div>
                <div class="item">
                    <div class="item-wrapper">
                        <img src="public/game/list/images/7.png" class="icon">
                        <div class="number"><?= $point['list'][7] ?? 0 ?></div>
                    </div>
                </div>
                <div class="item">
                    <div class="item-wrapper">
                        <img src="public/game/list/images/4.png" class="icon">
                        <div class="number"><?= $point['list'][4] ?? 0 ?></div>
                    </div>
                </div>
                <div class="item">
                    <div class="item-wrapper">
                        <img src="public/game/list/images/8.png" class="icon">
                        <div class="number"><?= $point['list'][8] ?? 0 ?></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    let dataPoint = '<?= json_encode($point['list']) ?>';
</script>
