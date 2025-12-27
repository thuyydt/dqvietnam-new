<?php

defined('BASEPATH') or exit('No direct script access allowed');
$controller = $this->router->fetch_class();

$method = $this->router->fetch_method();
$session = $this->session->school_id;
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo !empty($heading_title) ? $heading_title : 'CMS' ?> | DQ CMS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="<?= $this->security->get_csrf_hash() ?>" data-name="<?= $this->security->get_csrf_token_name() ?>"
    name="csrf-token">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?= site_url('public/admin/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
  <link rel="stylesheet"
    href="<?= site_url('public/admin/bower_components/font-awesome/css/font-awesome.min.css') ?>">
  <link rel="stylesheet" href="<?= site_url('public/admin/bower_components/Ionicons/css/ionicons.min.css') ?>">
  <link rel="stylesheet"
    href="<?= site_url('public/admin/bower_components/bs-iconpicker/css/bootstrap-iconpicker.min.css') ?>">
  <link rel="stylesheet"
    href="<?= site_url('public/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
  <link rel="stylesheet"
    href="<?= site_url('public/admin/bower_components/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') ?>">
  <link rel="stylesheet"
    href="<?= site_url('public/admin/bower_components/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') ?>">
  <link rel="stylesheet"
    href="<?= site_url('public/admin/bower_components/datatables.net-rowreorder-bs/css/rowReorder.bootstrap.min.css') ?>">
  <link rel="stylesheet"
    href="<?= site_url('public/admin/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') ?>">
  <link rel="stylesheet"
    href="<?= site_url('public/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') ?>">
  <link rel="stylesheet"
    href="<?= site_url('public/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css') ?>">
  <link rel="stylesheet"
    href="<?= site_url('public/admin/bower_components/fancybox/dist/jquery.fancybox.min.css') ?>">
  <link rel="stylesheet" href="<?= site_url('public/admin/bower_components/morris.js/morris.css') ?>">
  <link rel="stylesheet"
    href="<?= site_url('public/admin/bower_components/jquery-jvectormap-2.0.3/jquery-jvectormap-2.0.3.css') ?>">
  <link rel="stylesheet" href="<?= site_url('public/admin/plugins/pace/pace.min.css') ?>">
  <link rel="stylesheet"
    href="<?= site_url('public/admin/bower_components/bootstrap-sweetalert/dist/sweetalert.css') ?>">
  <link rel="stylesheet" href="<?= site_url('public/admin/bower_components/toastr/toastr.min.css') ?>">
  <link rel="stylesheet"
    href="<?= site_url('public/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css') ?>">
  <link rel="stylesheet"
    href="<?= site_url('public/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') ?>">
  <link rel="stylesheet" href="<?= site_url('public/admin/css/bootstrap-datetimepicker.min.css') ?>">
  <link rel="stylesheet" href="<?= site_url('public/admin/bower_components/select2/dist/css/select2.min.css') ?>">
  <link rel="stylesheet"
    href="<?= site_url('public/admin/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') ?>">
  <link rel="stylesheet"
    href="<?= site_url('public/admin/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') ?>">
  <link rel="stylesheet" href="<?= site_url('public/admin/css/fonts/elegantIcon/elegantIcon.css') ?>">
  <link rel="stylesheet" href="<?= site_url('public/admin/css/AdminLTE.min.css') ?>">
  <link rel="stylesheet" href="<?= site_url('public/admin/css/skins/_all-skins.min.css') ?>">
  <link rel="stylesheet" href="<?= site_url('public/admin/css/custom.css') ?>">
  <link rel="stylesheet" href="<?= site_url('public/admin/css/tinhpx.css') ?>">
  <link rel="stylesheet" href="<?= site_url('public/admin/css/report-admin.css') ?>">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/antd/4.23.6/antd.min.css"
    integrity="sha512-sW/jMkhvDkONfSzl8fwaI+LaZhvXKDZ3uMvfhMPEwoqN/ASLEg8t7ZkUworlAYXqgBACEtlpMRoe+SkiyAwruw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  <!-- Google Font -->
  <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">-->
  <style>
    .ant-message {
      z-index: 9999 !important;
    }
  </style>
</head>

<body class="hold-transition skin-blue fixed sidebar-mini">
  <script>
    var base_url = '<?php echo base_url(); ?>',
      current_url = '<?php echo current_url(); ?>',
      path_media = '<?php echo MEDIA_PATH; ?>',
      script_name = '<?php echo BASE_SCRIPT_NAME; ?>', //Tên sub-folder chạy site
      media_name = '<?php echo MEDIA_NAME; ?>',
      media_url = '<?php echo MEDIA_URL; ?>',
      csrf_cookie_name = '<?php echo $this->config->item('csrf_cookie_name') ?>',
      csrf_token_name = '<?php echo $this->security->get_csrf_token_name() ?>',
      csrf_hash = '<?php echo $this->security->get_csrf_hash() ?>',
      language = {},
      lang_cnf = {},
      select = '<?php showSelectStatus() ?>';
    <?php if (!empty($controller)): ?>
      var url_ajax_list = '<?php echo site_url("admin/$controller/ajax_list") ?>',
        url_ajax_load = '<?php echo site_url("admin/$controller/ajax_load") ?>',
        url_ajax_add = '<?php echo site_url("admin/$controller/ajax_add") ?>',
        url_ajax_copy = '<?php echo site_url("admin/$controller/ajax_copy") ?>',
        url_ajax_edit = '<?php echo site_url("admin/$controller/ajax_edit") ?>',
        url_ajax_update = '<?php echo site_url("admin/$controller/ajax_update") ?>',
        url_ajax_update_field = '<?php echo site_url("admin/$controller/ajax_update_field") ?>',
        url_ajax_delete = '<?php echo site_url("admin/$controller/ajax_delete") ?>',
        url_ajax_total = '<?php echo site_url("admin/$controller/ajax_total") ?>',
        url_ajax_general_data = '<?php echo site_url("admin/$controller/ajax_general_data") ?>',
        url_ajax_top_visited = '<?php echo site_url("admin/$controller/ajax_top_visited") ?>',
        url_ajax_top_browser = '<?php echo site_url("admin/$controller/ajax_top_browser") ?>',
        url_ajax_top_referrers = '<?php echo site_url("admin/$controller/ajax_top_referrers") ?>',
        url_ajax_load_schools = '',
        url_ajax_load_school = '<?php echo site_url("admin/schools/ajax_load") ?>',
        url_ajax_load_package = '<?php echo site_url("admin/packages/ajax_load") ?>',
        url_ajax_load_account = '<?php echo site_url("admin/account/ajax_load") ?>';
    <?php endif; ?>
    <?php if (!empty($this->config->item('cms_language'))) foreach ($this->config->item('cms_language') as $lang_code => $lang_name) { ?>
      lang_cnf['<?php echo $lang_code; ?>'] = '<?php echo $lang_name; ?>';
    <?php } ?>
    GLOBAL_SCHOOL = '<?= $session ?>';
  </script>
  <div class="wrapper">
    <?php $this->load->view($this->template_path . '_header') ?>
    <!-- Left side column. contains the logo and sidebar -->
    <?php $this->load->view($this->template_path . '_sidebar') ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <?php echo !empty($heading_title) ? $heading_title : '' ?>
          <small><?php echo !empty($heading_description) ? $heading_description : '' ?></small>
        </h1>
        <?php echo !empty($breadcrumbs) ? $breadcrumbs : ''; ?>
      </section>
      <div id="app">
        <?php echo !empty($main_content) ? $main_content : '' ?>
      </div>
    </div>
    <!-- /.content-wrapper -->
    <?php $this->load->view($this->template_path . '_footer') ?>
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    //   $.widget.bridge('uibutton', $.ui.button);
  </script>

  <script src="<?= $this->templates_assets . 'bower_components/jquery/dist/jquery.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/jquery-ui/jquery-ui.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/bootstrap/dist/js/bootstrap.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/datatables.net/js/jquery.dataTables.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/datatables.net-bs/js/dataTables.bootstrap.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/datatables.net-rowreorder/js/dataTables.rowReorder.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/datatables.net-buttons/js/dataTables.buttons.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/datatables.net-buttons-bs/js/buttons.bootstrap.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/datatables.net-buttons/js/buttons.print.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/datatables.net-buttons/js/buttons.html5.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/datatables.net-buttons/js/buttons.flash.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/datatables.net-buttons/js/buttons.colVis.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/moment/min/moment.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/bootstrap-daterangepicker/daterangepicker.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/select2/dist/js/select2.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'js/jquery.nestable.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/jquery-slimscroll/jquery.slimscroll.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/bootstrap-daterangepicker/daterangepicker.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/jquery-number/jquery.number.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'js/bootstrap-datetimepicker.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/fancybox/dist/jquery.fancybox.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/raphael/raphael.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/morris.js/morris.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/jquery-jvectormap-2.0.3/jquery-jvectormap-2.0.3.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/jquery-jvectormap-2.0.3/jquery-jvectormap-world-mill.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/PACE/pace.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/toastr/toastr.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/bootstrap-sweetalert/dist/sweetalert.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'js/adminlte.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'js/demo.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'plugins/tinymce/tinymce.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'plugins/chart/chart.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'plugins/moxiemanager/js/moxman.loader.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/bs-iconpicker/js/iconset/iconset-fontawesome-4.7.0.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'bower_components/bs-iconpicker/js/bootstrap-iconpicker.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'js/jquery-menu-editor.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'js/jq-ajax-progress.min.js' ?>"></script>
  <script src="<?= $this->templates_assets . 'js/main.js?v=' . time() ?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/vi.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/7.20.0/babel.min.js"
    integrity="sha512-puBh3Lh7A+12Hysd0qGHkmg+Z4PkhLNmWNEFu8g9u2ucMgcZin5HOigiOhdNfvhXv612CuDo696KtKDMi/x5Bg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script crossorigin src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
  <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/antd/4.23.6/antd-with-locales.min.js"
    integrity="sha512-8Tg6ryAtaX4wUGXz5iGz73vuTd80+hfQUGQMfucIKogTeIfCG2q6HUDuG7x36q066XH/+LB1MJ/QRJxb8YIFFA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="<?= $this->templates_assets . 'js/apiV2.js?v=' . time() ?>"></script>
  <?php $version = "3.8";
  if (!empty($controller)): ?>
    <script src="<?= $this->templates_assets . 'js/pages/' . $controller . '.js?v=' . $version ?>"></script>
  <?php endif; ?>
  <script>
    const {
      useState,
      useEffect,
      useRef,
      useForceUpdate,
      useMemo
    } = React;

    const {
      Descriptions,
      Drawer,
      Transfer,
      Typography,
      Badge,
      DatePicker,
      Modal,
      Skeleton,
      Input,
      Divider,
      Spin,
      Row,
      Upload,
      Progress,
      Checkbox,
      TreeSelect,
      Tabs,
      Tree,
      Space,
      Radio,
      message,
      Select,
      Col,
      Card,
      Form,
      Popconfirm,
      Table,
      Button,
      InputNumber
    } = antd;
    const {
      TabPane
    } = Tabs;
  </script>
  <script type="text/javascript">
    toastr.options.escapeHtml = true;
    toastr.options.closeButton = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.timeOut = 5000;
    toastr.options.showMethod = 'fadeIn';
    toastr.options.hideMethod = 'fadeOut';
    toastr.options.progressBar = true;
    <?php if (!empty($this->session->flashdata('message'))): $message = $this->session->flashdata('message'); ?>
      toastr.<?php echo $message['type']; ?>('<?php echo trim(strip_tags($message['message'])); ?>');
    <?php endif; ?>
  </script>
</body>

</html>