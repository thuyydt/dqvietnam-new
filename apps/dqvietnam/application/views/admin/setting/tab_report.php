<?php
$data_report = [
    ['key' => 1, 'title' => 'QUẢN LÝ THỜI GIAN TIẾP XÚC MÀN HÌNH'],
    ['key' => 2, 'title' => 'Quản lý bắt nạt trên mạng'],
    ['key' => 3, 'title' => 'Quản lý quyền riêng tư'],
    ['key' => 4, 'title' => 'Danh tính công dân ký thuật số'],
    ['key' => 5, 'title' => 'Quản lý an ninh mạng'],
    ['key' => 6, 'title' => 'Quản lý dấu chân kỹ thuật số'],
    ['key' => 7, 'title' => 'Tư duy phản biện'],
    ['key' => 8, 'title' => 'Cảm thông kỹ thuật số'],
];
?>

<div class="tab-pane row " id="<?= $target ?>">

    <div class="col-md-12" style="padding: 0 20px 20px; background: antiquewhite; margin: 15px">
        <h4>List Key : </h4>
        {{task_2_quest_1}} : Nội dung biển thiên nhiệm vụ 2 câu hỏi 1<br>
        {{task_12_quest_1}} : Nội dung biển thiên nhiệm vụ 12 câu hỏi 1<br>
        {{task_23_quest_1}} : Nội dung biển thiên nhiệm vụ 23 câu hỏi 1<br>
        {{task_33_quest_3}} : Nội dung biển thiên nhiệm vụ 33 câu hỏi 3<br>
        {{task_50_quest_2}} : Nội dung biển thiên nhiệm vụ 50 câu hỏi 2<br>
        {{task_60_quest_2}} : Nội dung biển thiên nhiệm vụ 60 câu hỏi 2<br>
        {{task_70_quest_2}} : Nội dung biển thiên nhiệm vụ 70 câu hỏi 2<br>
        {{task_72_quest_1}} : Nội dung biển thiên nhiệm vụ 72 câu hỏi 1<br>
    </div>

    <ul class="nav nav-pills nav-stacked col-md-3">
        <li role="presentation" class="active"><a href="#report_0" data-toggle="tab">CẤP ĐỘ RỦI RO TRONG KHÔNG GIAN
                MẠNG</a></li>
        <?php foreach ($data_report as $item) { ?>
            <li role="presentation"><a style="text-transform: uppercase" href="#report_<?= $item['key'] ?>"
                                       data-toggle="tab"><?= $item['title'] ?></a>
            </li>
        <?php } ?>
    </ul>
    <div class="tab-content col-md-9">

        <div class="tab-pane active" id="report_0">
            <fieldset class="form-group album-contain">
                <legend for="">Cấp độ 1</legend>
                <div class="form-group">
                    <label for=""> Báo cáo </label>
                    <textarea class="tinymce" name="report[0][lv1][content]" id="" cols="30"
                              rows="10"><?= $report[0]['lv1']['content'] ?></textarea>
                </div>
            </fieldset>
            <fieldset class="form-group album-contain">
                <legend for="">Cấp độ 2</legend>
                <div class="form-group">
                    <label for=""> Báo cáo </label>
                    <textarea class="tinymce" name="report[0][lv2][content]" id="" cols="30"
                              rows="10"><?= $report[0]['lv2']['content'] ?></textarea>
                </div>
            </fieldset>
            <fieldset class="form-group album-contain">
                <legend for="">Cấp độ 3</legend>
                <div class="form-group">
                    <label for=""> Báo cáo </label>
                    <textarea class="tinymce" name="report[0][lv3][content]" id="" cols="30"
                              rows="10"><?= $report[0]['lv3']['content'] ?></textarea>
                </div>
            </fieldset>
            <fieldset class="form-group album-contain">
                <legend for="">Cấp độ 4</legend>
                <div class="form-group">
                    <label for=""> Báo cáo </label>
                    <textarea class="tinymce" name="report[0][lv4][content]" id="" cols="30"
                              rows="10"><?= $report[0]['lv4']['content'] ?></textarea>
                </div>
            </fieldset>
        </div>

        <?php foreach ($data_report as $item) { ?>
            <div class="tab-pane" id="report_<?= $item['key'] ?>">
                <?php foreach ([1, 2, 3, 4] as $lv) { ?>
                    <fieldset class="form-group album-contain">
                        <legend for="">Cấp độ <?= $lv ?></legend>
                        <div class="form-group">
                            <label for=""> Báo cáo </label>
                            <textarea class="tinymce" name="report[<?= $item['key'] ?>][lv<?= $lv ?>][content]"
                                      id="report_<?= $item['key'] ?>_content_lv<?= $lv ?>">
                                <?= $report[$item['key']]['lv' . $lv]['content'] ?>
                            </textarea>
                        </div>

                        <?php
                        $image = ['name' => "report[" . $item['key'] . "][lv" . $lv . "][image]", 'id' => "image_" . $item['key'] . "_report_lv" . $lv, 'title' => 'Hình ảnh', 'type' => 'input_media'];
                        $image['value'] = !empty($report[$item['key']]['lv' . $lv]['image']) ? $report[$item['key']]['lv' . $lv]['image'] : '';
                        $this->load->view($this->template_path . 'setting/items/' . $image['type'], $image);
                        ?>

                        <div class="form-group">
                            <label for=""> Khuyến nghị </label>
                            <textarea class="tinymce" name="report[<?= $item['key'] ?>][lv<?= $lv ?>][recommend]"
                                      id="report_<?= $item['key'] ?>_recommend_lv<?= $lv ?>">
                                <?= $report[$item['key']]['lv' . $lv]['recommend'] ?>
                            </textarea>
                        </div>
                    </fieldset>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
