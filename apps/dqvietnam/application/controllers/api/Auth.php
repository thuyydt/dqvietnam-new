<?php

/**
 * Created by PhpStorm.
 * User: doan_du
 * Date: 08/05/2022
 * Time: 10:22
 */


defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends API_Controller
{
  public $status;
  public $code;
  public $message;
  public $data;
  protected $account;
  protected $field_id;

  public function __construct()
  {
    parent::__construct();

    $this->status = 'fail';
    $this->code = 500;
    $this->data = [];

    $this->load->library('ion_account');
    $this->lang->load(['account', 'user']);
    $this->load->model(['account_model', 'ion_account_model', 'Activity_model']);
    $this->account = new Account_model();
    $this->field_id = $this->config->item('identity', 'ion_account');
  }

  public function login()
  {

    if ($this->input->server('REQUEST_METHOD') == 'POST') {
      $inputJSON = file_get_contents('php://input');
      $request = json_decode($inputJSON, true);

      if (empty($request)) $request = $this->input->post();

      if (empty(strip_tags(trim($request['username']))) || empty(strip_tags(trim($request['password'])))) {
        $this->_message = [
          'code' => self::RESPONSE_REQUEST_ERROR,
          "message" => "Vui lòng điền đầy đủ thông tin đăng nhập"
        ];

        $this->returnJson($this->_message);
      }

      //            $userModel = new Account_model();
      //            $infoUser = $userModel->getInfoAccount(strip_tags(trim($request['account'])), $request['type']);

      $infoUser = $this->ion_account->login(strip_tags(trim($request['username'])), strip_tags(trim($request['password'])));

      if ($infoUser) {

        if (is_array($infoUser)) {
          if (empty($infoUser['is_password'])) {
            $this->_message = [
              "code" => self::RESPONSE_LOGIN_ERROR,
              "message" => "Tài khoản hoặc mật khẩu không đúng."
            ];

            $this->returnJson($this->_message);
          }
        }

        if ($infoUser->active != 1) {
          $this->_message = [
            "code" => self::RESPONSE_LOGIN_ERROR,
            "message" => "Tài khoản của bạn đang bị khóa, vui lòng kiểm tra lại."
          ];

          $this->returnJson($this->_message);
        }


        $arr_data_token = array(
          'user_id' => $infoUser->id,
          'name' => $infoUser->username,
          'phone' => $infoUser->phone,
          //                    'birthday' => $infoUser->birthday,
          //                    'avatar' => $infoUser->avatar,
          //                    'auth_uid' => $infoUser->auth_uid,
          'type_user' => 4
        );
      } else {
        $this->_message = [
          "code" => self::RESPONSE_LOGIN_ERROR,
          'data' => $infoUser,
          "message" => "Tài khoản hoặc mật khẩu không đúng."
        ];

        $this->returnJson($this->_message);
      }

      if (!empty($arr_data_token)) {
        $this->genAccessToken($arr_data_token);
        if ($this->status_token == 500) {
          $this->_message = [
            "code" => self::RESPONSE_SERVER_ERROR,
            "message" => "Hệ thống đang lỗi, bạn vui lòng quay lại sau."
          ];

          $this->returnJson($this->_message);
        } else {

          $activity = new Activity_model();
          if ($activity->check_logged_device($infoUser->id)) {
            $this->_message = [
              "code" => self::RESPONSE_SERVER_ERROR,
              "message" => "Bạn đã đăng nhập từ một trình duyệt khác. Vui lòng đăng xuất trước khi đăng nhập từ trình duyệt này."
            ];
            $this->returnJson($this->_message);
          }
          $url_redirect = base_url('guide');
          if (!empty($_COOKIE['dq_try_play'])) {
            $this->load->model(['report_model']);
            $report_model = new Report_model();
            $logGamePlay = $report_model->checkExistLogsPlay($infoUser->id);

            if (!empty($logGamePlay) && $logGamePlay->key > 3) {
              $this->switchToAccountReal($infoUser->id);
            }
            if (!empty($logGamePlay)) {
              $url_redirect = base_url('game');
            }
          }

          $this->_message = [
            "code" => self::RESPONSE_SUCCESS,
            "message" => "Login thành công",
            "data" => [
              'authKey' => $infoUser->id,
              'url_redirect' => $url_redirect,
              'access_token' => $this->access_token
            ]
          ];

          $this->returnJson($this->_message);
        }
      } else {

        $this->_message = [
          "code" => self::RESPONSE_SERVER_ERROR,
          "message" => "Hệ thống đang lỗi, bạn vui lòng quay lại sau."
        ];

        $this->returnJson($this->_message);
      }
    } else {
      $this->_message = [
        "code" => self::RESPONSE_REQUEST_ERROR,
        "message" => "Vui lòng kiểm tra method API."
      ];

      $this->returnJson($this->_message);
    }
  }

  public function register()
  {

    if ($this->input->server('REQUEST_METHOD') == 'POST') {
      $inputJSON = file_get_contents('php://input');
      $request = json_decode($inputJSON, true);
      if (empty($request)) $request = $this->input->post();
      //            $userModel = new Account_model();

      if (
        empty($request['username'])
        || empty($request['password'])
        || empty($request['re_password'])
        || empty($request['full_name'])
        || empty($request['birthday'])
      ) {

        $this->_message = [
          'code' => self::RESPONSE_REQUEST_ERROR,
          "message" => "Vui lòng điền đầy đủ thông tin đăng ký"
        ];

        $this->returnJson($this->_message);
      }

      //Valid email!
      if (!filter_var($request['username'], FILTER_VALIDATE_EMAIL)) {
        $this->_message = [
          'code' => self::RESPONSE_REQUEST_ERROR,
          "message" => "Email nhập không đúng định dạng"
        ];

        $this->returnJson($this->_message);
      }

      if (strlen($request['password']) < 8 || strlen('password') > 20) {
        $this->_message = [
          'code' => self::RESPONSE_REQUEST_ERROR,
          "message" => "Mật khẩu phải từ 8-20 ký tự, vui lòng kiểm tra lại"
        ];

        $this->returnJson($this->_message);
      }

      if ($request['password'] != $request['re_password']) {
        $this->_message = [
          'code' => self::RESPONSE_REQUEST_ERROR,
          "message" => "Nhập lại mật khẩu không trùng khớp"
        ];

        $this->returnJson($this->_message);
      }

      if (!filter_var($request['username'], FILTER_VALIDATE_EMAIL)) {
        if (strlen($request['username']) < 10 || strlen($request['username']) > 15) {
          $this->_message = [
            'code' => self::RESPONSE_REQUEST_ERROR,
            "message" => "Email không hợp lệ."
          ];

          $this->returnJson($this->_message);
        }
      }

      if (!empty($this->account->getUserByField('username', $request['username']))) {
        $this->_message = [
          'code' => self::RESPONSE_SERVER_ERROR,
          "message" => "Email đã được sử dụng, vui lòng kiểm tra lại."
        ];
        $this->returnJson($this->_message);
      }

      //            if(!empty($userModel->getInfoAccount($request['phone'], $request['type']))) {
      //                $this->code = 500;
      //                $this->message = 'Số điện thoại đã được sử dụng, vui lòng kiểm tra lại.';
      //                $this->response($this->status, $this->code, $this->message, $this->data);
      //            }

      if ($id = $this->ion_account->register($request['username'], $request['password'], '', $request, []) !== false) {
        $this->_message = [
          'code' => self::RESPONSE_SUCCESS,
          "message" => "Đăng ký tài khoản thành công."
        ];

        $logo = $this->email->attach(base_url('public/email/img/logo.png'), 'inline');
        $logoCid = $this->email->attachment_cid($logo);
        $this->sendMail([
          'title' => 'Thông tin tài khoản DQ',
          'to' => $request['username'],
          'template' => $this->load->view('admin/template_mail/userNewRegist.php', [
            'username' => $request['username'],
            'password' => $request['password'],
            'logo' => $logoCid,
            'contentTitle' => $logoCid,
            'hello' => $logoCid,
            'amiga' => $logoCid,
          ], true)
        ]);
      } else {
        $this->_message = [
          'code' => self::RESPONSE_SERVER_ERROR,
          "message" => "Hệ thống đang bảo trì, vui lòng quay lại sau ít phút."
        ];
      }

      $this->returnJson($this->_message);
    } else {
      $this->_message = [
        "code" => self::RESPONSE_REQUEST_ERROR,
        "message" => "Vui lòng kiểm tra method API."
      ];

      $this->returnJson($this->_message);
    }
  }

  public function register_schools()
  {
    if ($this->input->server('REQUEST_METHOD') == 'POST') {
      $inputJSON = file_get_contents('php://input');
      $request = json_decode($inputJSON, true);
      if (empty($request)) $request = $this->input->post();

      if (
        empty($request['name'])
        || empty($request['email'])
        || empty($request['phone'])
      ) {

        $this->_message = [
          'code' => self::RESPONSE_REQUEST_ERROR,
          "message" => "Vui lòng điền đầy đủ thông tin đăng ký"
        ];

        $this->returnJson($this->_message);
      }

      //Valid email!
      if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
        $this->_message = [
          'code' => self::RESPONSE_REQUEST_ERROR,
          "message" => "Email nhập không đúng định dạng"
        ];

        $this->returnJson($this->_message);
      }

      //Valid phone!
      if (!preg_match('/^[0-9]{10}+$/', $request['phone'])) {
        $this->_message = [
          'code' => self::RESPONSE_REQUEST_ERROR,
          "message" => "Số điện thoại nhập không đúng định dạng"
        ];

        $this->returnJson($this->_message);
      }

      $this->load->model(['Schools_register_model', 'Schools_model']);
      $schools_model = new Schools_register_model();
      $sch_model = new Schools_model();

      $result = $schools_model->save([
        'name' => $request['name'],
        'email' => $request['email'],
        'phone' => $request['phone'],
        'status' => 0,
      ]);

      $result = $sch_model->save([
        'name' => $request['name'],
        'email' => $request['email'],
        'phone' => $request['phone'],
        'status' => 1,
      ]);

      if ($result) {
        $this->_message = [
          'code' => self::RESPONSE_SUCCESS,
          "message" => "Đăng ký thành công. Chúng tôi sẽ liên lạc với bạn sớm nhất!"
        ];
      } else {
        $this->_message = [
          'code' => self::RESPONSE_SERVER_ERROR,
          "message" => "Hệ thống đang bảo trì, vui lòng quay lại sau ít phút."
        ];
      }

      $this->returnJson($this->_message);
    }
  }

  public function forgotPassword()
  {
    if ($this->input->server('REQUEST_METHOD') == 'POST') {
      $field_identity = $this->config->item('identity', 'ion_account');

      $inputJSON = file_get_contents('php://input');
      $request = json_decode($inputJSON, true);
      if (empty($request)) $request = $this->input->post();

      if (empty(strip_tags(trim($request['email'])))) {
        $this->_message = [
          'code' => self::RESPONSE_REQUEST_ERROR,
          "message" => "Vui lòng điền đầy đủ thông tin đăng nhập"
        ];

        $this->returnJson($this->_message);
      }

      $account = $this->account->getUserByField($this->field_id, $request['email']);
      if (!empty($account)) {
        if ($account->active != 1) {
          $this->_message = [
            'code' => self::RESPONSE_REQUEST_ERROR,
            "message" => "Tài khoản đã ngừng hoạt động!"
          ];

          $this->returnJson($this->_message);
        }
      } else {
        $this->_message = [
          'code' => self::RESPONSE_REQUEST_ERROR,
          "message" => "Tài khoản không tồn tại"
        ];

        $this->returnJson($this->_message);
      }

      $md5_hash = md5(rand(0, 999));
      $security_code = substr($md5_hash, 15, 10);
      $password = $this->ion_account->reset_password($account->{$this->field_id}, $security_code);

      // run the forgotten password method to email an activation code to the user
      $forgotten = $this->ion_account->forgotten_password($account->{$this->field_id}, $security_code);
      if ($forgotten && $password) {
        $this->_message = [
          "code" => self::RESPONSE_SUCCESS,
          "message" => "Thay đổi mật khẩu thành công"
        ];

        $this->returnJson($this->_message);
      } else {
        $this->_message = [
          "code" => self::RESPONSE_REQUEST_ERROR,
          "message" => "Có lỗi xãy ra, vui lòng thứ lại"
        ];
      }
      $this->returnJson($this->_message);
    }
  }

  public function switchToAccountReal($accountID)
  {
    $id = $_COOKIE['dq_try_play'];

    //switch Data Redis
    $taskOld = $this->getCache('TaskCurrent_' . $accountID);

    if (!$taskOld) {
      $task = $this->getCache('TaskCurrent_' . $id);
      $countAllPoint = $this->getCache('CountPoint_' . $id);
      $turnTry = $this->getCache('TryGame_' . $id);

      $this->setCache('TaskCurrent_' . $accountID, $task);
      $this->setCache('CountPoint_' . $accountID, $countAllPoint);
      $this->setCache('TryGame_' . $accountID, $turnTry);
    }

    $this->redis->del($this->redis->keys('dqedu_*_' . $id));

    //switch Data Log Points
    $this->load->model(['point_model']);
    $point_model = new Point_model();
    $pointOld = $point_model->checkExistLogsPoint($accountID);

    if (!$pointOld) {
      $point_model->updateAccountId($accountID, $id);
    } else {
      // Nếu hệ thống đã có dữ liệu của tài khoản, dữ liệu trải nghiệm sẽ bị xoá bỏ
      $point_model->delete(['account_id' => $id]);
    }

    //switch Data Log Play
    $this->load->model(['report_model']);
    $report_model = new Report_model();
    $playOld = $report_model->checkExistLogsPlay($accountID);

    if (!$playOld) {
      $report_model->updateAccountId($accountID, $id);
    } else {
      // Nếu hệ thống đã có dữ liệu của tài khoản, dữ liệu trải nghiệm sẽ bị xoá bỏ
      $report_model->delete(['account_id' => $id], $report_model->logs_play);
    }

    unset($_COOKIE['dq_try_play']);
    setcookie('dq_try_play', null, -1, '/');
  }
}
