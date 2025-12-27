<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Task extends Admin_Controller
{
    protected $_data;
    protected $_name_controller;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Task_model');
        $this->_data = new Task_model();
    }

    public function index()
    {
        $data['heading_title'] = 'Nhiệm vụ';
        $data['heading_description'] = "Danh sách nhiệm vụ";
        /*Breadcrumbs*/
        $this->breadcrumbs->push('Trang chủ', base_url());
        $this->breadcrumbs->push($data['heading_title'], '#');
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        $data['main_content'] = $this->load->view($this->template_path . 'task/index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
    public function ajax_list()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST' && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {


            $length = $this->input->post('length');
            $start = $this->input->post('start');
            $page =  $start / $length + 1;
            $params['page'] = $page;
            $params['limit'] = $length;
            $list = $this->_data->getData($params);
            $data = array();
            foreach ($list as $item) {
                $row = array();
                $row[] = $item->id;
                $row[] = $item->id;
                $row[] = $item->name;
//                $row[] = $item->training;
                $row[] = showFeatured($item->training);
//                if ($item->type == 0) {
//                    $row[] = 'Dùng chung';
//                } else if ($item->type == 1) {
//                    $row[] = 'Gói cá nhân';
//                } else {
//                    $row[] = 'Gói nhà trường';
//                }
                $row[] = showCenter(date('d-m-Y H:i:s',strtotime($item->created_time)));
                $row[] = showStatusUser($item->status);
                $row[] = button_action($item->id, ['edit']);

                $data[] = $row;
            }
            $total=$this->_data->getTotal($params);
           // $total=$this->_data->getTotal();
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
        $detail = (array)$this->_data->getData([
            'table' => $this->_data->table_detail,
            'where' => ['task_id' => $data['id']],
            'order' => ['number_order' => 'ASC'],
            'limit' => 100
        ]);
        foreach ($detail as $key => $item) {
            $detail[$key] = json_decode($item->content, true);
        }
        $data['tasks_detail'] = json_encode($detail);
        die(json_encode($data));
    }
    public function ajax_update_field()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $id = $this->input->post('id');
            $field = $this->input->post('field');
            $value = $this->input->post('value');

            $field = $field == 'is_featured' ? 'training' : $field;
            $response = $this->_data->update(['id' => $id], [$field => $value]);
            if ($response != false) {
                $message['type'] = 'success';
                $message['message'] = $this->lang->line('mess_update_success');
            } else {
                $message['type'] = 'error';
                $message['message'] = $this->lang->line('mess_update_unsuccess');
            }
            print json_encode($message);
        }
        die;
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

    public function ajax_get_title()
    {
        $data = $this->_data->getLastRecord();

        $result = ['key' => 1];
        if (!empty($data)) {
            $result['key'] = (int) $data->key + 1;
        }
        die(json_encode($result));
    }

    /*
     * Kiêm tra thông tin post lên
     * */
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
        $data = $this->input->post();

        $tasks = json_decode($data['tasks'], true);
        $tasks_detail = [];

        if (!empty($data['order'])) {
            $data['order'] = array_reverse($data['order']);
            foreach ($data['order'] as $key => $item) {
                $task = $tasks[explode('item_', $item)[1]];

                $task['number_order'] = $key;
                $task['content'] = json_encode($task);

                switch ($task['type']) {
                    case 'slide':
                        $task['type'] = 0;
                        break;
                    case 'question':
                        $task['type'] = 1;
                        break;
                    case 'fill':
                        $task['type'] = 2;
                        break;
                    case 'crossword':
                        $task['type'] = 3;
                        break;
                    case 'images':
                        $task['type'] = 4;
                        break;
                    case 'card':
                        $task['type'] = 5;
                        break;
                    case 'chat':
                        $task['type'] = 6;
                        break;
                }

                $tasks_detail[$key] = $task;
            }
        }

        $data['tasks_detail'] = $tasks_detail;

        unset($data['order'], $data['task_thumbnail'], $data['tasks']);

        return $data;
    }
}
