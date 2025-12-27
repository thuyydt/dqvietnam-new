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
        $this->output->set_content_type('application/json')->set_output(json_encode([]));
    }

    public function ajax_general_data()
    {
        $this->output->set_content_type('application/json')->set_output(json_encode([]));
    }

    public function ajax_top_visited()
    {
        $this->output->set_content_type('application/json')->set_output(json_encode([]));
    }

    public function ajax_top_browser()
    {
        $this->output->set_content_type('application/json')->set_output(json_encode([]));
    }

    public function ajax_top_referrers()
    {
        $this->output->set_content_type('application/json')->set_output(json_encode([]));
    }

}
