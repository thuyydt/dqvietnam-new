<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account extends Admin_Controller
{
    protected $_data;
    protected $_data_schools;
    protected $_data_cron;
    protected $_data_payment;
    protected $_name_controller;

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('account');
        $this->load->library('ion_account');
        $this->load->model(array('account_model', 'users_model', 'Report_model', 'Schools_model', 'Cronjob_model', 'Payments_model', 'Point_model'));
        $this->_data = new Account_model();
        $this->_data_schools = new Schools_model();
        $this->_data_cron = new Cronjob_model();
        $this->_data_payment = new Payments_model();
        $this->_name_controller = $this->router->fetch_class();
    }

    public function index()
    {
        $data['heading_title'] = "Tài khoản";
        $data['heading_description'] = "Quản lý Tài khoản";
        /*Breadcrumbs*/
        $this->breadcrumbs->push('Trang chủ', base_url());
        $this->breadcrumbs->push($data['heading_title'], '#');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        /*Breadcrumbs*/
        $school = $this->_data_schools->getInfoField($this->session->email, 'email');
        if ($school) {
            $data['school_id'] = $school->id;
        }
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        $userInfo = $this->users_model->roleName($this->session->user_id);
        $data['userInfo'] = $userInfo;
        $content = $this->template_path . $this->_name_controller . '/index';
        $data['main_content'] = $this->load->view($content, $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function detail()
    {
        $id = $this->uri->segment(3);
        $data['heading_title'] = "Chi tiết tài khoản";
        $data['heading_description'] = "Quản lý Tài khoản";
        /*Breadcrumbs*/
        $this->breadcrumbs->push('Trang chủ', base_url());
        $this->breadcrumbs->push($data['heading_title'], '#');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['info'] = $this->account_model->getById($id, 'full_name,username');
        $pointModel = new Point_model();
        $data['point'] = $pointModel->getPointSummary($id)->point;

        $reportModel = new Report_model();
        $points = $reportModel->getCountPointForType($id, '', 1);
        $answerOne = $this->getKeyAnswer($id, '2', '3');
        $answerTwo = $this->getKeyAnswer($id, '12', 'A');
        $answerThree = $this->getKeyAnswer($id, '23', 'A');
        $answerFour = $this->getKeyAnswer($id, '32', 'A', 2);
        $answerFive = $this->getKeyAnswer($id, '50', '3', 1);
        $answerSix = $this->getKeyAnswer($id, '60', '3', 2);
        $answerSeven = $this->getKeyAnswer($id, '70', '3', 2);
        $answerEight = $this->getKeyAnswer($id, '72', '3');
        $data['answers'] = [
            '1' => $answerOne,
            '2' => $answerTwo,
            '3' => $answerThree,
            '4' => $answerFour,
            '5' => $answerFive,
            '6' => $answerSix,
            '7' => $answerSeven,
            '8' => $answerEight,
        ];

        if (!empty($points)) {
            foreach ($points as $point) {
                $count_point = (int)$point->point_dq;
                $list[$point->task_type_point] = $count_point;
            }
            $data['point_type'] = $list;
        }
        if (!$data['info']) {
            throw new Exception("Tài khoản không tồn tại");
        }
        /*Breadcrumbs*/
        $data['main_content'] = $this->load->view($this->template_path . $this->_name_controller . '/detail', $data, TRUE);
        $this->load->view($this->template_path . '/account/report/layout', $data);
    }

    public function getKeyAnswer($accountId, $key, $chose, $position = 0)
    {
        try {
            $reportModel = new Report_model();
            $answerOne = $reportModel->getAnswerByAccountId($accountId, $key);
            $question = $answerOne ? json_decode($answerOne->task) : false;
            $taskDetail = $question ? array_shift($question->task_detail) : false;
            if ($position > 0 && isset($question->task_detail[$position])) {
                $taskDetail = $question->task_detail[$position];
            }
            //$taskDetail = $question ? array_shift($question->task_detail) : false;
            $answers = $taskDetail ? json_decode($taskDetail->content, true) : false;
            return $answers['answers'][$chose] ?? '';
        } catch (\Exception $exception) {
            return '';
        }

    }

    /*
     * Ajax trả về datatable
     * */
    public function ajax_list()
    {
        $this->checkRequestPostAjax();
        $length = $this->input->post('length', 20);
        $no = $this->input->post('start', 0);
        $page = $no / $length + 1;
        $params['page'] = $page;
        $params['join'] = [
            'point' => 1,
            'payments' => 1
        ];
        $params['limit'] = $length;

        if (!empty($this->session->school_id)) {
            $params['where'] = [
                'schools_id' => $this->session->school_id
            ];
        } elseif (!empty($this->input->post('filter_school'))) {
            $params['where'] = [
                'schools_id' => $this->input->post('filter_school')
            ];
        }

        if ($this->input->post('is_status') != '') $params['active'] = $this->input->post('is_status');

        $select = 'c19_account.id, c19_account.username, c19_account.active, c19_account.schools_id, c19_account.created_time, c19_account.is_payment, c19_payments.payment_code as code, COUNT(c19_logs_point.point) AS point';

        $list = $this->_data->getData($params, 'object', $select);

        $data = array();
        if (!empty($list)) foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->id;
            $row[] = showCenter("DQ $item->id");
            //$row[] = showCenter($item->id);
            $row[] = $item->username;
            $row[] = $item->point;
            $row[] = showCenter(showStatusUser($item->active));
            $row[] = showCenter(showAdminPaymentUser($item->id, $item->is_payment));
            $row[] = showCenter(formatDate($item->created_time, 'datetime'));
            $row[] = button_action($item->id, ['view', 'edit', 'delete']);
            $data[] = $row;
        }

        $total = $this->_data->getTotal($params);
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => $data,
        );
        $this->returnJson($output);
    }

    /*
     * Ajax lấy thông tin
     * */
    public function ajax_edit($id)
    {
        $data = (array)$this->_data->getById($id);
        unset($data['password']);

        if (!empty($data['schools_id'])) {
            $school = $this->_data_schools->getById($data['schools_id']);

            if (!empty($school)) {
                $data['schools_id'] = array(['id' => $school->id, 'text' => $school->name]);
            } else {
                $data['schools_id'] = [];
            }
        } else {
            $data['schools_id'] = [];
        }

        die(json_encode($data));
    }

    public function ajax_add()
    {
        $this->_validate();
        $identity = strip_tags(trim($this->input->post('username')));
        $password = strip_tags(trim($this->input->post('password')));
        $email = strip_tags(trim($this->input->post('email')));
        $data_store['phone'] = strip_tags(trim($this->input->post('phone')));
        $data_store['schools_id'] = strip_tags(trim($this->input->post('schools_id')));

        if (isset($this->session->school_id)) {
            $data_store['schools_id'] = $this->session->school_id;
            $data_store['is_payment'] = 1;
        }

        $data_store['type'] = strip_tags(trim($this->input->post('type')));
        $data_store['gender'] = strip_tags(trim($this->input->post('gender')));
        $data_store['active'] = !empty($this->input->post('active')) ? $this->input->post('active') : 0;
        $data_store['full_name'] = strip_tags(trim($this->input->post('full_name')));
        $birthday = strip_tags(trim($this->input->post('birthday')));
        if (!empty($birthday) && isDateTime($birthday))
            $data_store['birthday'] = convertDate($birthday);
        $group_id = 2;
        if ($this->input->post('group_id')) {
            $group_id = strip_tags(trim($this->input->post('group_id')));
        }
        $id = $this->ion_account->register($identity, $password, $email, $data_store, ['group_id' => $group_id]);
        if (!empty($id)) {

            $this->_data_cron->addCronJob($id, 'send_password');

            $action = $this->router->fetch_class();
            $note = "Insert $action: " . $id;
            $this->addLogaction($action, $note);
            $message['type'] = 'success';
            $message['message'] = $this->lang->line('mess_add_success');


            if ($this->input->post('sendMail') === 'on') {
                $this->sendMail([
                    'title' => 'Thông tin tài khoản DQ',
                    'to' => $email,
                    'template' => $this->load->view('admin/template_mail/accountCreate.php', array_merge($data_store, ['password' => $password]), true)
                ]);
            }

        } else {
            $message['type'] = 'error';
            $message['message'] = $this->lang->line('mess_add_unsuccess');
        }

        die(json_encode($message));
    }

    public function ajax_update()
    {
        $this->load->library('encryption');
        $data_store = [];
        $userID = $this->input->post('id');
        $exists = $this->account_model->getInfoUserById($userID);

        if ($this->input->post('password')) {
            $data_store['password'] = strip_tags(trim($this->input->post('password')));
        }
        $data_store['username'] = $this->input->post('username');
        $data_store['schools_id'] = $this->input->post('schools_id') ? strip_tags(trim($this->input->post('schools_id'))) : $exists->schools_id;
        $data_store['type'] = strip_tags(trim($this->input->post('type')));
        $data_store['active'] = trim($this->input->post('active'));
        $data_store['gender'] = trim($this->input->post('gender'));
        $data_store['birthday'] = $birthday = strip_tags(trim($this->input->post('birthday')));
        if (!empty($birthday) && isDateTime($birthday)) $data_store['birthday'] = convertDate($birthday);

        $response = $this->ion_account->update($this->input->post('id'), $data_store);
        if ($response != false) {
            $action = $this->router->fetch_class();
            $note = "Update $action: " . $this->input->post('id');
            $this->addLogaction($action, $note);
            $message['type'] = 'success';
            $message['message'] = $this->lang->line('mess_update_success');
            $school = $this->Schools_model->getInfoById($exists->schools_id);
            if ($this->input->post('sendMail') === 'on') {
                $message['mailSend'] = $this->sendMail([
                    'title' => 'Thông báo cập nhật tài khoản DQ',
                    'to' => $exists->username,
                    'template' => $this->load->view('admin/template_mail/accountUpdate.php', [
                        'password' => isset($data_store['password']) ? $data_store['password'] : 'Không thay đổi',
                        'username' => $exists->username,
                        'phone' => $exists->phone,
                        'school' => $school ? $school->name : '',
                    ], true)
                ]);
            }
        } else {
            $message['type'] = 'error';
            $message['message'] = $this->lang->line('mess_update_unsuccess');
        }
        die(json_encode($message));
    }

    /*
     * Xóa một bản ghi
     * */
    public function ajax_delete($id)
    {
        $response = $this->_data->update(['id' => $id], ['active' => 0]);
        if ($response != false) {
            $action = $this->router->fetch_class();
            $note = "delete $action: $id";
            $this->addLogaction($action, $note);
            $message['type'] = 'success';
            $message['message'] = $this->lang->line('mess_delete_success');
        } else {
            $message['type'] = 'error';
            $message['message'] = $this->lang->line('mess_delete_unsuccess');
            $message['error'] = $response;
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
//                'full_name' => $term,
                'username' => $term
            ],
            'limit' => 50,
            'order' => array('id' => 'desc')
        ];
        $list = $this->_data->getData($params);
        if (!empty($list)) foreach ($list as $item) {
            $item = (object)$item;
            $json[] = ['id' => $item->id, 'text' => $item->username];
        }
        $this->returnJson($json);
    }


    private function _validate()
    {
        $this->checkRequestPostAjax();
        if (empty($this->input->post('id'))) {
            //$this->form_validation->set_rules('username', 'Tài khoản', 'required|trim|min_length[3]|max_length[300]|strip_tags|xss_clean|is_unique[account.username]');
            $this->form_validation->set_rules('username', 'Tài khoản', 'valid_email|callback_check_email|strip_tags|xss_clean');
//            $this->form_validation->set_rules('email', 'Email', 'valid_email|callback_check_email|strip_tags|xss_clean');
        }
        // $this->form_validation->set_rules('full_name', 'Họ và tên', 'required|trim|strip_tags|xss_clean');

        $this->form_validation->set_rules('phone', 'Số điện thoại', 'required|trim|regex_match[/^[0-9]{10,11}$/]|strip_tags|xss_clean');

        $this->form_validation->set_rules('birthday', 'Ngày sinh', 'required|strip_tags|xss_clean|callback_max_time_current');

        if (!isset($this->session->school_id)) {
            if (empty($this->input->post('id')) || !empty($this->input->post('password'))) {
                //  $this->form_validation->set_rules('repassword', 'Nhập lại mật khẩu', 'trim|matches[password]|min_length[6]|max_length[20]|required');
                $this->form_validation->set_rules('password', 'Mật khẩu', 'trim|min_length[6]|max_length[20]|required');
            }
        }

        if ($this->form_validation->run() === false) {
            $message['type'] = "warning";
            $message['message'] = $this->lang->line('mess_validation');
            $valid = [];
            if (empty($this->input->post('id')) || !empty($this->input->post('password'))) {
                $valid["password"] = form_error("password");
                // $valid["repassword"] = form_error("repassword");
            }
            $valid["username"] = form_error("username");
            //$valid["full_name"] = form_error("full_name");
            $valid["email"] = form_error("email");
            // $valid["phone"] = form_error("phone");
            $valid["birthday"] = form_error("birthday");
            $message['validation'] = $valid;
            $this->returnJson($message);
        }
    }

    public function check_username()
    {
        $username = trim($this->input->post('username'));
        $check = $this->_data->check_oauth('username', $username);
        if (!empty($check)) {
            $this->form_validation->set_message('check_username', 'Username đã tồn tại');
            return FALSE;
        }
        if (empty($username)) {
            $this->form_validation->set_message('check_username', 'Trường Username là bắt buộc');
            return FALSE;
        }
        return TRUE;
    }

    public function check_email()
    {
        $email = trim($this->input->post('email'));
        $check = $this->_data->check_oauth('email', $email);
        if (!empty($email) && !empty($check)) {
            $this->form_validation->set_message('check_email', 'Email đã tồn tại');
            return FALSE;
        }

        return TRUE;
    }

    public function ajax_view_detail($id)
    {
        $this->load->model(array('Report_model'));
        $reportModel = new Report_model();
        $points = $reportModel->getCountPointForType($id);
        $medium = 0;
        $list = [];
        if (!empty($points)) {
            foreach ($points as $key => $point) {
                $count_point = (int)$point->point_dq;
                $medium += $count_point;
                $list[$point->type] = $count_point;
            }
            $medium = intval($medium / 8);
        }

        $account = $this->_data->getById($id);

        echo json_encode(compact('medium', 'list', 'account'));
        exit;
    }

    public function ajax_reset_account($id)
    {
        $this->load->model(array('Report_model'));
        $report_model = new Report_model();

        //Xoá điểm
        $report_model->delete(['account_id' => $id], $report_model->logs_point);

        //Xoá lịch sử chơi game
        $report_model->delete(['account_id' => $id], $report_model->logs_play);

        //Xoá redis
        $this->redis->del($this->redis->keys(REDIS_PREFIX . '*_' . $id));

        $message['type'] = 'success';
        $message['message'] = 'Cài lại thành công';
        die(json_encode($message));
    }

    public function ajax_update_payment($id)
    {
        $this->_data_payment->delete(['account_id' => $id]);
        $value = $this->input->post('value') ?? 0;
        $response = $this->_data->update(['id' => $id], ['is_payment' => $value]);

        if ((int)$value) {
            $this->_data_payment->save([
                'payment_code' => 'DQ ' . $id,
                'account_id' => $id,
                'school_id' => 0,
                'price' => 0,
                'time_payment' => date('Y-m-d H:i:s'),
                'content' => 'auto created'
            ]);

            $this->_data_cron->addCronJob($id, 'send_payment');
        }

        if ($response != false) {
            $message['type'] = 'success';
            $message['message'] = $this->lang->line('mess_update_success');
        } else {
            $message['type'] = 'error';
            $message['message'] = $this->lang->line('mess_update_unsuccess');
        }
        print json_encode($message);
    }
}
