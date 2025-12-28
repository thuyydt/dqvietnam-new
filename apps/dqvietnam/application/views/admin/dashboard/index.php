<script>
    var url_ajax_total = '<?= site_url('admin/dashboard/ajax_total') ?>';
    var url_ajax_general_data = '<?= site_url('admin/dashboard/ajax_general_data') ?>';
    var url_ajax_top_visited = '<?= site_url('admin/dashboard/ajax_top_visited') ?>';
    var url_ajax_top_browser = '<?= site_url('admin/dashboard/ajax_top_browser') ?>';
    var url_ajax_top_referrers = '<?= site_url('admin/dashboard/ajax_top_referrers') ?>';
</script>

<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3 id="total_users">0</h3>
                    <p>Thành viên</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
                <a href="<?= site_url('admin/users') ?>" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3 id="total_posts">0</h3>
                    <p>Bài viết</p>
                </div>
                <div class="icon">
                    <i class="ion ion-document-text"></i>
                </div>
                <a href="#" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3 id="total_orders">0</h3>
                    <p>Đơn hàng</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3 id="total_contacts">0</h3>
                    <p>Liên hệ</p>
                </div>
                <div class="icon">
                    <i class="ion ion-email"></i>
                </div>
                <a href="#" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thống kê truy cập</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-default btn-sm" id="date-range-btn">
                            <span>
                                <i class="fa fa-calendar"></i> Hôm nay
                            </span>
                            <i class="fa fa-caret-down"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body" id="general_data">
                    <!-- Chart or Table will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Top Trình duyệt</h3>
                </div>
                <div class="box-body" id="top_browser">
                    <!-- Content -->
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Top Nguồn truy cập</h3>
                </div>
                <div class="box-body" id="top_referrers">
                    <!-- Content -->
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Top Trang xem nhiều</h3>
                </div>
                <div class="box-body" id="top_visited_data">
                    <!-- Content -->
                </div>
            </div>
        </div>
    </div>
</section>
