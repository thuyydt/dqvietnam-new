<?php

/**
 * Created by PhpStorm.
 * User: doan_du
 * Date: 08/05/2022
 * Time: 10:22
 */


defined('BASEPATH') or exit('No direct script access allowed');

class Account extends API_Controller
{
  public $account_model;

  public function __construct()
  {
    parent::__construct();

    $this->load->model(['account_model']);
    $this->load->library('ion_account');
    $this->account_model = new Account_model();
  }

  public function getInfoAccount()
  {
    $inputJSON = file_get_contents('php://input');
    $request = json_decode($inputJSON, true);

    $info_account = $this->user_auth;
    unset($info_account->password);
    unset($info_account->schools_id);
    unset($info_account->ip_address);
    unset($info_account->forgotten_password_code);
    unset($info_account->forgotten_password_time);

    $this->_message = [
      "code" => self::RESPONSE_SUCCESS,
      "message" => "Thông tin tài khoản",
      "data" => $info_account
    ];
    $this->returnJson($this->_message);
  }

  public function update()
  {
    $inputJSON = file_get_contents('php://input');
    $request = json_decode($inputJSON, true);
    if (empty($request)) $request = $this->input->post();

    $rules = array(
      array(
        'field' => 'full_name',
        'label' => 'Họ và tên',
        'rules' => 'xss_clean|callback_validate_html'
      ),
      array(
        'field' => 'email_parent',
        'label' => 'Email',
        'rules' => 'xss_clean|callback_validate_html'
      ),
      array(
        'field' => 'phone_parent',
        'label' => 'Số điện thoại',
        'rules' => 'xss_clean|callback_validate_html'
      ),
      array(
        'field' => 'school',
        'label' => 'Trường học',
        'rules' => 'xss_clean|callback_validate_html'
      )
    );

    $this->form_validation->set_rules($rules);
    if ($this->form_validation->run() !== TRUE) {
      $message['type'] = "warning";
      $message['code'] = self::RESPONSE_REQUEST_ERROR;
      $message['message'] = 'Có lỗi xãy ra, vui lòng thứ lại!';
      $valid = array();
      if (!empty($rules)) foreach ($rules as $item) {
        if (!empty(form_error($item['field']))) $valid[$item['field']] = form_error($item['field']);
      }
      $message['validation'] = $valid;
    }

    $data_store['full_name'] = $request['full_name'];
    $data_store['gender'] = $request['gender'];
    //  $data_store['school'] = $request['school'];
    $data_store['email_parent'] = $request['email_parent'];
    $data_store['phone_parent'] = $request['phone_parent'];
    $data_store['active'] = 1;
    $d = $request['dob'] ?? '01';
    $m = $request['mob'] ?? '01';
    $y = $request['yob'] ?? '2000';
    $data_store['birthday'] = "$y-$m-$d";

    unset($data_store['avatar']);
    if (!empty($_FILES['avatar']['name'])) {
      $file_allow = ['.png', '.jpg', '.jpeg', '.gif'];
      $ext = substr($_FILES['avatar']['name'], strrpos($_FILES['avatar']['name'], '.'));
      if (in_array($ext, $file_allow)) {
        $image_name = 'avatar_account/' . 'avatar_' . time() . $ext;
        $target_dir = MEDIA_NAME . $image_name;

        if (!file_exists(MEDIA_NAME . 'avatar_account')) {
          mkdir(MEDIA_NAME . 'avatar_account', 0775, true);
        }

        move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_dir);

        if ($this->user_auth->avatar && file_exists(MEDIA_NAME . $this->user_auth->avatar)) {
          unlink(MEDIA_NAME . $this->user_auth->avatar);
        }
        $data_store['avatar'] = $image_name;
      } else {
        $message['type'] = 'error';
        $message['code'] = self::RESPONSE_LOGIN_ERROR;
        $message['message'] = 'Hình ảnh lỗi, xin vui lòng thứ lại!';
        die(json_encode($message));
      }
    }

    if ($this->account_model->update(['id' => $this->user_auth->id], $data_store)) {
      $message['type'] = 'success';
      $message['code'] = self::RESPONSE_SUCCESS;
      $message['message'] = 'Cập nhật thành công';

      $key = REDIS_PREFIX . 'getAccountDQById_' . $this->user_auth->id;
      if ($this->redis) {
        $this->redis->del($this->redis->keys($key));
      }
    } else {
      $message['type'] = 'error';
      $message['code'] = self::RESPONSE_LOGIN_ERROR;
      $message['message'] = 'Có lỗi xãy ra, xin vui lòng thứ lại!';
    }
    die(json_encode($message));
  }

  public function password()
  {
    if ($this->input->server('REQUEST_METHOD') == 'POST') {
      $inputJSON = file_get_contents('php://input');
      $request = json_decode($inputJSON, true);
      if (empty($request)) $request = $this->input->post();

      $rules = array(
        array(
          'field' => 'password_old',
          'label' => 'Mật khẩu cũ',
          'rules' => 'required|trim|min_length[6]|xss_clean|callback_validate_html'
        ),
        array(
          'field' => 'password_new',
          'label' => 'Mật khẩu mới',
          'rules' => 'required|trim|min_length[6]|max_length[32]|xss_clean|callback_validate_html'
        )
      );

      $this->form_validation->set_rules($rules);

      if ($this->form_validation->run() === TRUE) {
        $result = $this->ion_account->change_password($this->user_auth->username, $request['password_old'], $request['password_new']);
        if (!empty($result)) {
          $message['type'] = "success";
          $message['code'] = self::RESPONSE_SUCCESS;
          $message['message'] = 'Thay đổi mật khẩu thành công';


          $this->sendMail([
            'title' => 'Thông tin tài khoản DQ',
            'to' => $request['username'],
            'template' => $this->load->view('admin/template_mail/accountUpdate.php', [
              'changePass' => true,
              'oldPassword' => $request['password_old'],
              'newPassword' => $request['password_new']
            ], true)
          ]);
        } else {
          $message['type'] = 'warning';
          $message['code'] = self::RESPONSE_REQUEST_ERROR;
          $message['message'] = 'Có lỗi xãy ra, vui lòng thứ lại!';
        }
      } else {
        $message['type'] = "warning";
        $message['code'] = self::RESPONSE_REQUEST_ERROR;
        $message['message'] = 'Có lỗi xãy ra, vui lòng thứ lại!';
        $valid = array();
        if (!empty($rules)) foreach ($rules as $item) {
          if (!empty(form_error($item['field']))) $valid[$item['field']] = form_error($item['field']);
        }
        $message['validation'] = $valid;
      }
      die(json_encode($message));
    }
  }

  public function reset()
  {
    $this->load->model(array('Report_model'));
    $report_model = new Report_model();

    //Xoá điểm
    $report_model->delete(['account_id' => $this->user_auth->id], $report_model->logs_point);

    //Xoá lịch sử chơi game
    $report_model->delete(['account_id' => $this->user_auth->id], $report_model->logs_play);

    //Xoá redis
    $this->redis->del($this->redis->keys(REDIS_PREFIX . '*_' . $this->user_auth->id));

    $message['type'] = 'success';
    $message['message'] = 'Thành công';
    die(json_encode($message));
  }
}
