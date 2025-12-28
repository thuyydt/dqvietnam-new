<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Activation extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $data['heading_title'] = "Mã kích hoạt";
    $data['heading_description'] = "Quản lý Tài khoản";
    /*Breadcrumbs*/
    $this->breadcrumbs->push('Trang chủ', base_url());
    $this->breadcrumbs->push($data['heading_title'], '#');
    $data['breadcrumbs'] = $this->breadcrumbs->show();

    $content = $this->template_path  . '/activation/index';
    $data['main_content'] = $this->load->view($content, $data, TRUE);
    $this->load->view($this->template_main, $data);
  }
}
