<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends C19_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Account_model');
    $this->load->model('Login_activity_model');
    $this->load->model('Activation_code_model');
    $this->load->model('Payments_model');
    $this->load->library('user_agent');
    $this->load->library('bcrypt');

    // Handle JSON input
    $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
    $request = json_decode($stream_clean, true);
    if (!empty($request) && is_array($request)) {
      $_POST = array_merge($_POST, $request);
    }
  }

  private function json_response($data, $status = 200)
  {
    $this->output
      ->set_content_type('application/json')
      ->set_status_header($status)
      ->set_output(json_encode($data));
  }

  public function pingPong()
  {
    $userId = $this->input->post('user_id');
    if (!$userId) {
      return $this->json_response(['success' => false], 400);
    }

    $deviceId = $this->agent->platform() . ' ' . $this->agent->browser();
    if ($this->agent->is_mobile()) {
      $deviceId .= ' Mobile';
    }

    $activity = $this->Login_activity_model->single(['user_id' => $userId, 'device' => $deviceId]);

    if (!$activity) {
      $data = [
        'device' => $deviceId,
        'ip' => $this->input->ip_address(),
        'is_logged' => 1,
        'user_id' => $userId,
        'last_logged' => date('Y-m-d H:i:s')
      ];
      $this->Login_activity_model->insert($data);
    } else {
      $this->Login_activity_model->update($activity->id, ['is_logged' => 1]);
    }

    return $this->json_response(true);
  }

  public function logout()
  {
    // In CI3 with session
    $this->session->sess_destroy();
    return $this->json_response(true);
  }

  public function active()
  {
    try {
      $code = $this->input->post('code');
      $userId = $this->input->post('userId');

      $codeActive = $this->Activation_code_model->single(['code' => $code]);

      if (!$codeActive) {
        return $this->json_response(['success' => false, 'message' => 'Mã kích hoạt không tồn tại'], 500);
      }

      $this->db->trans_start();

      $account = $this->Account_model->single(['id' => $userId]);
      if (!$account) {
        return $this->json_response(['success' => false, 'message' => 'Phiên đăng nhập đã hết hạn! Để tiếp tục thanh toán vui lòng đăng nhập lại'], 500);
      }

      if ($codeActive->is_active) {
        return $this->json_response(['success' => false, 'message' => 'Mã kích hoạt đã được sử dụng, vui lòng thử lại'], 500);
      }

      $this->Account_model->update(['id' => $userId], [
        'is_payment' => 1,
        'active' => 1
      ]);

      $this->Activation_code_model->update(['id' => $codeActive->id], [
        'is_active' => 1,
        'active_for' => $userId,
        'active_at' => date('Y-m-d H:i:s')
      ]);

      $this->Payments_model->insert([
        'payment_code' => $code,
        'account_id' => $userId,
        'school_id' => $account->schools_id,
        'status' => 1,
        'time_payment' => date('Y-m-d H:i:s'),
        'content' => 'Account active by code',
        'package_id' => 1,
        'price' => 850000,
        'users_created' => $userId,
        'users_updated' => $userId,
      ]);

      $this->db->trans_complete();

      if ($this->db->trans_status() === FALSE) {
        return $this->json_response(['success' => false, 'message' => 'Transaction failed'], 500);
      }

      // Reload account to get updated info
      $account = $this->Account_model->single(['id' => $userId]);
      return $this->json_response(['success' => true, 'account' => $account]);
    } catch (Exception $exception) {
      return $this->json_response(['success' => false, 'message' => $exception->getMessage()], 500);
    }
  }

  public function saveLogged()
  {
    try {
      $data = $this->input->post();
      $deviceId = $this->agent->platform() . ' ' . $this->agent->browser();

      $data['device'] = $deviceId;
      $data['ip'] = $this->input->ip_address();
      $data['is_logged'] = 1;
      $data['last_logged'] = date('Y-m-d H:i:s');

      // Check if exists to update or create
      $exists = $this->Login_activity_model->single([
        'user_id' => $data['user_id'],
        'device' => $deviceId
      ]);

      if ($exists) {
        $this->Login_activity_model->update($exists->id, $data);
        return $this->json_response($exists); // Return object as in Laravel? Laravel returns boolean or model
      } else {
        $id = $this->Login_activity_model->insert($data);
        $data['id'] = $id;
        return $this->json_response($data);
      }
    } catch (Exception $e) {
      return $this->json_response($e->getMessage(), 500);
    }
  }

  public function activities()
  {
    // Pagination in CI is different. Laravel: paginate(15)
    // Here we might just return all or implement simple pagination
    $page = $this->input->get('page') ? $this->input->get('page') : 1;
    $limit = 15;
    $offset = ($page - 1) * $limit;

    // Need to join with account
    // C19_Model might have join capabilities or we use db builder
    $this->db->select('logged_logs.*, account.username');
    $this->db->join('account', 'account.id = logged_logs.user_id');
    $this->db->limit($limit, $offset);
    $query = $this->db->get('logged_logs');
    $result = $query->result();

    return $this->json_response($result);
  }

  public function login()
  {
    try {
      $username = $this->input->post('username');
      $password = $this->input->post('password');

      $user = $this->Account_model->single([
        'username' => $username,
        'regular_pwd' => $password
      ]);

      if ($user) {
        // Set session or return user data
        // Laravel: Auth::login($user); return Auth::user();
        // Here we just return user data, maybe set session if needed for web
        $this->session->set_userdata('user_id', $user->id);
        return $this->json_response($user);
      } else {
        return $this->json_response(['message' => 'Invalid credentials'], 401);
      }
    } catch (Exception $e) {
      return $this->json_response($e->getMessage(), 500);
    }
  }

  public function register()
  {
    try {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('username', 'Email', 'required|valid_email|is_unique[account.username]');
      $this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[6]');
      $this->form_validation->set_rules('re_password', 'Nhập lại mật khẩu', 'required|matches[password]');
      $this->form_validation->set_rules('phone', 'Số điện thoại', 'required|numeric|exact_length[10]');
      $this->form_validation->set_rules('birthday', 'Ngày sinh', 'required');
      $this->form_validation->set_rules('full_name', 'Họ và tên', 'required');

      if ($this->form_validation->run() == FALSE) {
        // Format validation errors as an array
        $errors = $this->form_validation->error_array();
        return $this->json_response(['success' => false, 'message' => $errors], 400);
      }

      $data = $this->input->post();
      // Remove re_password if it exists in data
      unset($data['re_password']);

      // Add missing fields
      $data['ip_address'] = $this->input->ip_address();
      $data['email'] = $data['username'];
      $data['created_on'] = time();
      $data['active'] = 1;
      $data['regular_pwd'] = $data['password'];
      $data['password'] = $this->bcrypt->hash($data['password']);

      $id = $this->Account_model->insert($data);

      // Dispatch email job - In CI we might send email directly or use a queue library if available
      // For now, I'll skip the job dispatch or just send email if simple
      // Laravel: AccountMailJob::dispatch(...)

      return $this->json_response(['success' => true, 'message' => 'Đăng ký tài khoản thành công']);
    } catch (Exception $e) {
      return $this->json_response(['success' => false, 'message' => $e->getMessage()], 500);
    }
  }

  public function forgot()
  {
    // Empty in Laravel source
  }

  public function reset()
  {
    // Empty in Laravel source
  }

  public function handle_activities()
  {
    $method = $this->input->method(TRUE);
    if ($method === 'POST') {
      return $this->saveLogged();
    }
    return $this->activities();
  }
}
