<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Schools_register extends Admin_Controller
{
  protected $_data;
  protected $_name_controller;

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Schools_register_model');
    $this->_data = new Schools_register_model();
  }

  public function index()
  {
    $data['heading_title'] = 'Danh sách trường học đăng ký';
    $data['heading_description'] = "Danh sách trường học đăng ký";
    /*Breadcrumbs*/
    $this->breadcrumbs->push('Trang chủ', base_url());
    $this->breadcrumbs->push($data['heading_title'], '#');
    $data['breadcrumbs'] = $this->breadcrumbs->show();

    $data['main_content'] = $this->load->view($this->template_path . 'schools_register/index', $data, TRUE);
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
        $row[] = $item->email;
        $row[] = $item->phone;
        $row[] = showStatus($item->status);
        $row[] = showCenter(date('d-m-Y H:i:s', strtotime($item->created_time)));
        $row[] = button_action($item->id, ['delete']);

        $data[] = $row;
      }
      $total = $this->_data->getTotal($params);
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

  public function ajax_update_field()
  {
    if ($this->input->server('REQUEST_METHOD') == 'POST' && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      $id = $this->input->post('id');
      $field = $this->input->post('field');
      $value = $this->input->post('value');
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
    exit;
  }
}
