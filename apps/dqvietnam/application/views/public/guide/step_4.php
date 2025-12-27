<div class="app" style="background-image: url(<?= $this->templates_assets ?>images/bg-main.jpg);">

    <img class="bg-content v1" src="<?= $this->templates_assets ?>images/bg-03.jpg">

    <div class="btn-box">
        <a href="<?= urlRoute('guide/step-') . ($step-1)?>" class="btn">TRỞ LẠI</a>
        <a href="<?= urlRoute('guide/step-') . ($step+1)?>" class="btn">TIẾP TỤC</a>
    </div>

</div>