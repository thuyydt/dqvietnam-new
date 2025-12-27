<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Payments extends Admin_Controller
{
    protected $_data;
    protected $_data_cron;
    protected $_name_controller;

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['Payments_model', 'Cronjob_model', 'Account_model']);
        $this->_data = new Payments_model();
        $this->_data_cron = new Cronjob_model();
    }

    public function index()
    {
        $data['heading_title'] = 'Thanh toán';
        $data['heading_description'] = "Danh sách thanh toán";
        /*Breadcrumbs*/
        $this->breadcrumbs->push('Trang chủ', base_url());
        $this->breadcrumbs->push($data['heading_title'], '#');
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        $data['main_content'] = $this->load->view($this->template_path . 'payments/index', $data, TRUE);
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
                $account = $this->Account_model->getById(39);
                $row = array();
                $row[] = $item->id;
                $row[] = $item->id;
                $row[] = $item->payment_code;
                $row[] = json_encode($account);
                $row[] = formatDate($item->time_payment, 'datetime');
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

    public function ajax_add()
    {
        $data_store = $this->_convertData();
        $data_store['users_created'] = $this->session->userdata['user_id'];
        unset($data_store['id']);
        if ($id_post = $this->_data->save($data_store)) {
            // log action
            $this->_data_cron->addCronJob($data_store['account_id'], 'send_payment');
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

        $packages = getPackage($data['package_id']);
        $account = getAccount($data['account_id']);

        $data['package_id'] = [
            [
                'id' => $packages->id,
                'text' => $packages->name,
            ]
        ];

        $data['account_id'] = [
            [
                'id' => $account->id,
                'text' => $account->username,
            ]
        ];

        $data['time_payment'] = date('d-m-Y H:i:s', strtotime($data['time_payment']));
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
            // Xoá package account
            $this->_data->delete(["payment_id" => $id], $this->_data->package_account);
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

    /*
     * Kiêm tra thông tin post lên
     * */
    private function _validate()
    {
        $this->checkRequestPostAjax();
        $rules[] = array(
            'field' => 'payment_code',
            'label' => 'Mã thanh toán',
            'rules' => 'required|trim|xss_clean|callback_validate_html'
        );
        $rules[] = array(
            'field' => 'account_id',
            'label' => 'Tài khoản',
            'rules' => 'required|trim|xss_clean|callback_validate_html'
        );
        $rules[] = array(
            'field' => 'package_id',
            'label' => 'Khoá học',
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

        $data['time_payment'] = date('Y-m-d H:i:s', strtotime($data['time_payment']));
        $data['users_updated'] = $this->session->userdata['user_id'];

        unset($data['schools_name']);
        return $data;
    }

    public function export()
    {
        $date = $this->input->get('month');
        $nameFile = $date . date('Ymd_H\hi');

        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $tmp_path = FCPATH . 'template-excel/bao_cao_thanh_toan.xls';
        $objPHPExcel = $objReader->load($tmp_path);

        $list = $this->_data->getDataExcel($date);

        if (!empty($list)) {
            $objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);

            $objWorkSheet->setCellValue('A1', 'Report');
            $rowNumberH = 3;
            foreach ($list as $stt => $item) {
                $objWorkSheet->setCellValue('A' . $rowNumberH, $stt + 1);
                $objWorkSheet->setCellValue('B' . $rowNumberH, $item->payment_code);
                $objWorkSheet->setCellValue('C' . $rowNumberH, $item->username);
                $objWorkSheet->setCellValue('D' . $rowNumberH, date('d/m/Y H:i', strtotime($item->time_payment)));
                $rowNumberH++;
            }
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment;filename="bao_cao_thanh_toan_' . $nameFile . '.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        ob_start();
        $objWriter->save('php://output');
    }
}
