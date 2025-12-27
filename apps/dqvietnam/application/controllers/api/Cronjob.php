<?php

/**
 * Created by PhpStorm.
 * User: doan_du
 * Date: 08/05/2022
 * Time: 10:22
 */


defined('BASEPATH') or exit('No direct script access allowed');

class Cronjob extends API_Controller
{
    public $_data;
    public $table;
    public $_data_account;
    public $_data_post;


    public function __construct()
    {
        parent::__construct();
        //$this->template = base_url();
        $this->table = "post";
        $this->load->helper(array('email'));
        $this->load->model(['account_model', 'Cronjob_model']);
        $this->_data = new Cronjob_model();
        $this->_data_account = new Account_model();
    }

    public function run()
    {
        $message = [];

        $data = $this->_data->getData(['where' => ['is_sync' => 0]], 'row');

        if (!empty($data)) {
            $data_sender = [];
            switch ($data->type) {
                case "send_password":

                    $account = $this->_data_account->getById($data->relation_id);

                    if (!empty($account)) {
                        if ($account->active != 1) return;
                    } else {
                        return;
                    }

                    $this->load->library('ion_account');
                    $field_id = $this->config->item('identity', 'ion_account');

                    $md5_hash = md5(rand(0, 999));
                    $security_code = substr($md5_hash, 15, 10);
                    $password = $this->ion_account->reset_password($account->{$field_id}, $security_code);

                    $subject = 'Thông Báo DQ - Tài Khoản Đăng Nhập Hệ Thống';

                    $data_replate = [
                        'email' => $account->{$field_id},
                        'password' => $password
                    ];

                    $response = sendMail('', $account->{$field_id}, $subject, 'send_password', $data_replate, $data_sender);

                    if ($response) {
                        $message['type'] = "success";
                        $message['message'] = 'send mail success';
                    } else {
                        $message['type'] = "error";
                        $message['message'] = 'send mail unsuccess';
                    }
                    break;
                case "send_payment":
                    $account = $this->_data_account->getById($data->relation_id);

                    if (!empty($account)) {
                        if ($account->active != 1) return;
                    } else {
                        return;
                    }

                    $subject = 'Thống Báo DQ - Tài Khoản Của Bạn Đã Thanh Toán';

                    $response = sendMail('', $account->username, $subject, 'send_payment', [], $data_sender);

                    if ($response) {
                        $message['type'] = "success";
                        $message['message'] = 'send mail success';
                    } else {
                        $message['type'] = "error";
                        $message['message'] = 'send mail unsuccess';
                    }
                    break;
                default:
            }

            $this->_data->update(['id' => $data->id], ['is_sync' => 1]);

        } else {
            $message['type'] = "warning";
            $message['message'] = 'no task send mail ';
        }
        $this->returnJson($message);
    }
}
