<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends Admin_Controller
{
    protected $_data;
    protected $_name_controller;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('pages_model');
        $this->_data = new Pages_model();
    }

    public function index()
    {
        $data['heading_title'] = 'Trang';
        $data['heading_description'] = "Danh sách trang";
        /*Breadcrumbs*/
        $this->breadcrumbs->push('Trang chủ', base_url());
        $this->breadcrumbs->push($data['heading_title'], '#');
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        $data['main_content'] = $this->load->view($this->template_path . 'pages/index', $data, TRUE);
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
                $row[] = $item->name;
                $row[] = $item->location == 1 ? 'Phải' : 'Trái';
                $row[] = $item->status == 1 ? 'Active' : 'Inactive';
                $row[] = showCenter(date('d-m-Y H:i:s',strtotime($item->created_time)));

                $row[] = button_action($item->id, ['edit','delete']);

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

    public function ajax_add()
    {
        $data_store = $this->_convertData();
        unset($data_store['id']);
        if ($id_post = $this->_data->save($data_store)) {
            // log action
            $action = $this->router->fetch_class();
            $note = "Insert $action: " . $id_post;
            $this->addLogaction($action, $note);
            $message['type'] = 'success';
            $message['message'] = $this->lang->line('mess_add_success');
        } else {
            $message['type'] = 'error';
            $message['message'] = $this->lang->line('mess_add_unsuccess');
        }
        die(json_encode($message));
    }

    public function ajax_edit($id)
    {
        $data = (array)$this->_data->getById($id);
        die(json_encode($data));
    }

    public function ajax_update()
    {
        $data_store = $this->_convertData();
        $response = $this->_data->update(array('id' => $this->input->post('id')), $data_store, $this->_data->table);
        if ($response != false) {
            // log action
            $action = $this->router->fetch_class();
            $note = "Update $action: " . $data_store['id'];
            $this->addLogaction($action, $note);
            $message['type'] = 'success';
            $message['message'] = $this->lang->line('mess_update_success');
        } else {
            $message['type'] = 'error';
            $message['message'] = $this->lang->line('mess_update_unsuccess');
        }
        die(json_encode($message));
    }

    public function ajax_delete($id)
    {
        $response = $this->_data->delete(['id' => $id]);
        if ($response != false) {
            $this->_data->delete(["id" => $id], $this->_data->table_trans);
            // log action
            $action = $this->router->fetch_class();
            $note = "Update $action: $id";
            $this->addLogaction($action, $note);
            $message['type'] = 'success';
            $message['message'] = $this->lang->line('mess_delete_success');
        } else {
            $message['type'] = 'error';
            $message['message'] = $this->lang->line('mess_delete_unsuccess');
            $message['error'] = $response;
            log_message('error', $response);
        }
        die(json_encode($message));
    }

    public function ajax_load()
    {
        $this->checkRequestGetAjax();
        $term = $this->input->get("q");
        $params = [
//            'is_status' => 1,
            'search' => [
                'name' => $term
            ],
            'limit' => 50,
            'order' => array('id' => 'desc')
        ];
        $list = $this->_data->getData($params);
        if (!empty($list)) foreach ($list as $item) {
            $item = (object)$item;
            $json[] = ['id' => $item->id, 'text' => $item->name];
        }
        $this->returnJson($json);
    }

    public function ajax_get_by_account_id($account_id)
    {
        $data = (array)$this->_data->getData([
            'account_id' => $account_id
        ], 'row', 'pages.id, pages.name');

        $this->returnJson($data);
    }

    private function _validate()
    {
        $this->checkRequestPostAjax();
        $rules[] = array(
            'field' => 'name',
            'label' => 'Tiêu đề',
            'rules' => 'required|trim|xss_clean|callback_validate_html'
        );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == false) {
            $this->return_notify_validate($rules);
        }
    }

    private function _convertData()
    {
        $this->_validate();
        return $this->input->post();
    }
}
