<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>
<!-- Main content -->
<section class="content">
    <div class="row">

        <?php $list_total_field = [
            ['title' => 'Số lượng tài khoản học sinh', 'id' => 'total_account', 'icon' => 'fa fa-user', 'src' => site_url('admin/user')],
            ['title' => 'Số lượng học sinh đang tham gia', 'id' => 'total_account_doing', 'icon' => 'fa fa-newspaper-o', 'src' => site_url('admin/post')],
            ['title' => 'Số lượng học sinh đã hoàn thành', 'id' => 'total_account_done', 'icon' => 'fa fa-archive', 'src' => site_url('admin/product')],
            ['title' => 'Điểm trung bình / Số học sinh đã hoàn thành', 'id' => 'total_medium', 'icon' => 'fa fa-building', 'src' => site_url('admin/project')],
        ]; ?>

        <?php foreach ($list_total_field as $value) { ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3 id="<?= $value['id'] ?>"><i class="fa fa-refresh fa-spin"></i></h3>
                        <p><?= $value['title'] ?></p>
                    </div>
                    <div class="icon">
                        <i class="<?= $value['icon'] ?>"></i>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
    <div class="row">
        <div class="col-xs-9">
            <!-- AREA CHART -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Danh sách những học sinh có cấp độ báo động</h3>
                </div>
                <div class="box-body chart-responsive">
                    <form action="" id="form-table" method="post">
                        <input type="hidden" value="0" name="msg"/>
                        <table id="data-table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="60">
                                    <input type="checkbox" name="select_all" value="1" id="data-table-select-all">
                                </th>
                                <th class="no-sort" width="60">ID</th>
                                <th class="no-sort">Tài khoản</th>
                                <th class="no-sort">Điểm Trung Bình DQ</th>

                                <?php showColumnAction(); ?>
                            </tr>
                            </thead>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xs-3">
            <!-- AREA CHART -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Phần trăm học sinh tham gia</h3>
                </div>
                <div class="box-body chart-responsive">

                    <div class="info-box bg-aqua" id="percent_1">
                        <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Cấp độ 1 : Tốt</span>
                            <span class="info-box-number">5,200</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description"><strong class="percent">0%</strong> trên tổng số học sinh</span>
                        </div>
                    </div>

                    <div class="info-box bg-yellow" style="background-color: #ffcd3b !important;" id="percent_2">
                        <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Cấp độ 2 : Khá</span>
                            <span class="info-box-number">5,200</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description"><strong class="percent">0%</strong> trên tổng số học sinh</span>
                        </div>
                    </div>

                    <div class="info-box bg-yellow" style="background-color: #f57d18 !important;" id="percent_3">
                        <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Cấp độ 3 : Trung bình</span>
                            <span class="info-box-number">5,200</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description"><strong class="percent">0%</strong> trên tổng số học sinh</span>
                        </div>
                    </div>

                    <div class="info-box bg-red" id="percent_4">
                        <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Cấp độ 4 : Báo động</span>
                            <span class="info-box-number">5,200</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description"><strong class="percent">0%</strong> trên tổng số học sinh</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_view_detail" role="dialog">
    <div class="modal-dialog" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="title-form">Thông tin tài khoản học viên</h3>
            </div>
            <div class="modal-body form">
                <div class="row">
                    <div class="col-md-12" style="padding: 20px">
                        <dl class="dl-horizontal">
                            <dt>Họ và tên</dt>
                            <dd id="full_name"></dd>

                            <dt>Email</dt>
                            <dd id="username"></dd>
                        </dl>
                        <br>
                        <table class="table table-bordered">
                            <tbody><tr>
                                <th style="width: 10px">#</th>
                                <th>Kỹ năng</th>
                                <th style="width: 40px">Điểm</th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Quản lý thời gian tiếp xúc màn hình</td>
                                <td><span class="badge bg-aqua" id="point-type-1">0</span></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Quản lý bắt nạt trên mạng</td>
                                <td><span class="badge bg-aqua" id="point-type-2">0</span></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Quản lý quyền riêng tư</td>
                                <td><span class="badge bg-aqua" id="point-type-3">0</span></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Danh tính công dân kỹ thuật số</td>
                                <td><span class="badge bg-aqua" id="point-type-4">0</span></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Quản lý an ninh mạng</td>
                                <td><span class="badge bg-aqua" id="point-type-5">0</span></td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Quản lý dấu chân kỹ thuật số</td>
                                <td><span class="badge bg-aqua" id="point-type-6">0</span></td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Tư duy phản biện</td>
                                <td><span class="badge bg-aqua" id="point-type-7">0</span></td>
                            </tr>

                            <tr>
                                <td>8</td>
                                <td>Cảm thông kỹ thuật số</td>
                                <td><span class="badge bg-aqua" id="point-type-8">0</span></td>
                            </tr>

                            <tr>
                                <td>9</td>
                                <td><b>Diểm Trung Bình</b></td>
                                <td><b><span class="badge bg-green" id="point-medium">0</span></b></td>
                            </tr>

                            </tbody></table>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    var url_ajax_parameters_report = '<?= site_url('admin/report/ajax_parameters_report') ?>';
    var url_ajax_percent_of_levels = '<?= site_url('admin/report/ajax_percent_of_levels') ?>';
    var url_ajax_view_detail = '<?= site_url('admin/account/ajax_view_detail') ?>';
</script>

<style>
    #data-table_filter {
        display: none;
    }
</style>
