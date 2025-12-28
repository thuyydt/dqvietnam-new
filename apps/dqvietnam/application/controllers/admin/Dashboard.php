<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{

  protected $google_analytics;
  protected $_post;
  protected $_users;

  public function __construct()
  {
    parent::__construct();
    $this->lang->load('dash_lang');
    $this->load->model(['users_model']);
    $this->_users = new Users_model();
  }

  public function index()
  {

    $data['heading_title'] = ucfirst($this->router->fetch_class());
    $data['heading_description'] = 'Tổng quan CMS';
    /*Breadcrumbs*/
    $this->breadcrumbs->push('Trang chủ', base_url());
    $this->breadcrumbs->push($data['heading_title'], '#');
    $data['breadcrumbs'] = $this->breadcrumbs->show();
    /*Breadcrumbs*/

    $data['main_content'] = $this->load->view($this->template_path . 'dashboard/index', $data, TRUE);
    $this->load->view($this->template_main, $data);
  }

  public function ajax_total()
  {
    // Dummy data
    $data = [
      'total_users' => 150,
      'total_posts' => 45,
      'total_orders' => 12,
      'total_contacts' => 5
    ];
    $this->output->set_content_type('application/json')->set_output(json_encode($data));
  }

  public function ajax_general_data()
  {
    $html = '<div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                      <tr>
                        <th>Ngày</th>
                        <th>Lượt xem</th>
                        <th>Người dùng</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr>
                        <td>' . date('d/m/Y') . '</td>
                        <td>100</td>
                        <td>50</td>
                      </tr>
                      <tr>
                        <td>' . date('d/m/Y', strtotime('-1 day')) . '</td>
                        <td>80</td>
                        <td>40</td>
                      </tr>
                      </tbody>
                    </table>
                  </div>';
    $this->output->set_content_type('application/json')->set_output(json_encode($html));
  }

  public function ajax_top_visited()
  {
    $html = '<ul class="nav nav-pills nav-stacked">
                    <li><a href="#">Trang chủ <span class="pull-right text-red"> 12%</span></a></li>
                    <li><a href="#">Giới thiệu <span class="pull-right text-green"> 4%</span></a></li>
                    <li><a href="#">Liên hệ <span class="pull-right text-yellow"> 3%</span></a></li>
                  </ul>';
    $this->output->set_content_type('application/json')->set_output(json_encode($html));
  }

  public function ajax_top_browser()
  {
    $html = '<ul class="nav nav-pills nav-stacked">
                    <li><a href="#">Chrome <span class="pull-right text-red"> 55%</span></a></li>
                    <li><a href="#">Safari <span class="pull-right text-green"> 30%</span></a></li>
                    <li><a href="#">Firefox <span class="pull-right text-yellow"> 15%</span></a></li>
                  </ul>';
    $this->output->set_content_type('application/json')->set_output(json_encode($html));
  }

  public function ajax_top_referrers()
  {
    $html = '<ul class="nav nav-pills nav-stacked">
                    <li><a href="#">Google <span class="pull-right text-red"> 60%</span></a></li>
                    <li><a href="#">Facebook <span class="pull-right text-green"> 30%</span></a></li>
                    <li><a href="#">Direct <span class="pull-right text-yellow"> 10%</span></a></li>
                  </ul>';
    $this->output->set_content_type('application/json')->set_output(json_encode($html));
  }
}
