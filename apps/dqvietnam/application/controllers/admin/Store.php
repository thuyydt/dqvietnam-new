<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Store extends Admin_Controller
{
    protected $_data;
    protected $_name_controller;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Store_model');
        $this->_data = new Store_model();
    }

    public function index()
    {
        $data['heading_title'] = 'Kho số';
        $data['heading_description'] = "Danh sách số";
        /*Breadcrumbs*/
        $this->breadcrumbs->push('Trang chủ', base_url());
        $this->breadcrumbs->push($data['heading_title'], '#');
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        $data['main_content'] = $this->load->view($this->template_path . 'store/index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
    public function ajax_list()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST' && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $params['limit'] = $this->input->post('length');
            $params['offset'] = $this->input->post('start');
            $list = $this->_data->getData($params);

            $data = array();
            foreach ($list as $item) {
                $row = array();
                $row[] = $item->id;
                $row[] = $item->id;
                $row[] = $item->phone;
                $row[] = showCenter(date('d-m-Y H:i:s',strtotime($item->created_time)));
                $data[] = $row;
            }
            $total=$this->_data->getTotal($params);
            $output = array(
                "draw" => $this->input->post('draw'),
                "recordsTotal" => $total,
                "recordsFiltered" => $total,
                "data" => $data,
            );
            echo json_encode($output);
        }
        exit;
    }
}
