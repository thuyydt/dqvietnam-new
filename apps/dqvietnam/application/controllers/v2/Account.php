<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account extends C19_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Account_model');
        $this->load->model('Payments_model');
        $this->load->model('Point_model');
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

    private function _apply_filters()
    {
        $key = $this->input->get('key');
        if ($key) {
            $this->db->group_start();
            $this->db->like('account.username', $key);
            $this->db->or_like('account.phone', $key);
            $this->db->or_like('account.full_name', $key);
            $this->db->or_like('account.email_parent', $key);
            $this->db->or_like('account.phone_parent', $key);
            $this->db->group_end();
        }

        $schoolIds = $this->input->get('schoolIds');
        if ($schoolIds) {
            if (is_array($schoolIds)) {
                $this->db->where_in('account.schools_id', $schoolIds);
            } else {
                 $this->db->where_in('account.schools_id', explode(',', $schoolIds));
            }
        }
    }

    public function index()
    {
        $page = $this->input->get('page') ? $this->input->get('page') : 1;
        $pageSize = $this->input->get('pageSize') ? $this->input->get('pageSize') : 20;
        $offset = ($page - 1) * $pageSize;

        // Get Total Count
        $this->_apply_filters();
        $total = $this->db->count_all_results('account');

        // Get Data
        $this->_apply_filters();
        $this->db->select('account.username, account.email, account.phone, account.birthday, account.gender, account.active, account.class, account.full_name, account.created_time, account.id, account.schools_id, account.is_payment');
        $this->db->select_sum('logs_point.point', 'point_sum_point');
        $this->db->join('logs_point', 'logs_point.account_id = account.id', 'left');
        $this->db->group_by('account.id');
        
        $this->db->order_by('account.created_time', 'DESC');
        $this->db->limit($pageSize, $offset);
        
        $query = $this->db->get('account');
        $result = $query->result();
        
        return $this->json_response([
            'data' => $result,
            'total' => $total,
            'current_page' => (int)$page,
            'per_page' => (int)$pageSize
        ]);
    }

    public function create()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Email', 'required|valid_email|is_unique[account.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('phone', 'Phone', [
            'required',
            'regex_match[/^(0|84)[35789][0-9]{8}$/]'
        ], [
            'regex_match' => 'Trường {field} không đúng định dạng.'
        ]);

        if ($this->form_validation->run() == FALSE) {
             return $this->json_response(['message' => validation_errors()], 400);
        }

        $this->db->trans_start();
        
        $data = $this->input->post();
        
        // Handle password
        $password = $data['password'];
        $data['password'] = $this->bcrypt->hash($password);
        $data['regular_pwd'] = $password;
        
        // Remove non-column fields
        $fromSchool = isset($data['fromSchool']) ? $data['fromSchool'] : null;
        $sendMail = isset($data['sendMail']) ? $data['sendMail'] : null;
        
        unset($data['fromSchool']);
        unset($data['sendMail']);
        unset($data['confirmpassword']); // Common field to remove
        
        $id = $this->Account_model->save($data);
        
        if (!$id) {
             $this->db->trans_rollback();
             return $this->json_response(['message' => 'Create failed'], 500);
        }

        $exist = $this->Account_model->get_by(['id' => $id]);
        
        if ($fromSchool) {
             $this->Payments_model->insert([
                'payment_code' => "DQ $id",
                'account_id' => $id,
                'school_id' => $exist->schools_id,
                'status' => 1,
                'time_payment' => date('Y-m-d H:i:s'),
                'content' => 'Auto created',
                'package_id' => 1,
                'price' => 850000,
                'users_created' => $id,
                'users_updated' => $id,
            ]);
            $this->Account_model->update($id, ['is_payment' => 1]);
            $exist->is_payment = 1;
        }

        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
             return $this->json_response(['message' => 'Transaction failed'], 500);
        }

        return $this->json_response($exist);
    }

    public function update($id)
    {
        $data = $this->input->post();
        
        // Remove fields that shouldn't be updated directly
        unset($data['id']);
        unset($data['username']); // Email/Username usually immutable
        unset($data['created_time']);
        unset($data['point_sum_point']);
        unset($data['fromSchool']); // Not a DB column
        unset($data['sendMail']); // Not a DB column
        
        // Handle password if present
        if (isset($data['password']) && !empty($data['password'])) {
             $data['password'] = $this->bcrypt->hash($data['password']);
        } else {
            unset($data['password']);
        }

        if ($this->Account_model->update(['id' => $id], $data)) {
             return $this->json_response(['message' => 'success']);
        }
        return $this->json_response(['message' => 'Failed'], 500);
    }

    public function payment($id)
    {
        $model = $this->Account_model->get_by(['id' => $id]);
        if (!$model) {
            return $this->json_response(['message' => 'Not found'], 404);
        }

        $newStatus = ($model->is_payment == 1) ? 0 : 1;
        $this->Account_model->update($id, ['is_payment' => $newStatus]);
        
        $payment = $this->Payments_model->get_by(['account_id' => $id]);
        if (!$payment) {
             $this->Payments_model->insert([
                'payment_code' => "DQ $id",
                'account_id' => $id,
                'school_id' => $model->schools_id,
                'status' => 1,
                'time_payment' => date('Y-m-d H:i:s'),
                'content' => 'Account registered',
                'package_id' => 1,
                'price' => 850000,
                'users_created' => $id,
                'users_updated' => $id,
            ]);
        }

        return $this->json_response(true);
    }

    public function changePassword()
    {
        $oldPwd = $this->input->post('password_old');
        $newPwd = $this->input->post('password_new');
        $key = $this->input->post('key');

        $user = $this->Account_model->get_by(['id' => $key]);
        if (!$user) {
             return $this->json_response(['error' => 'User not found'], 404);
        }

        if (!$this->bcrypt->verify($oldPwd, $user->password)) {
             return $this->json_response(['error' => 'Mật khẩu không chính xác'], 500);
        }

        $newHash = $this->bcrypt->hash($newPwd);
        $this->Account_model->update($key, [
            'password' => $newHash,
            'regular_pwd' => $newPwd
        ]);

        return $this->json_response(['success' => 'Thay đổi mật khẩu thành công']);
    }

    public function delete($id)
    {
        $this->db->trans_start();
        
        $model = $this->Account_model->get_by(['id' => $id]);
        if (!$model) {
             return $this->json_response(['message' => 'Not found'], 404);
        }

        $this->db->delete('logs_point', ['account_id' => $id]);
        $this->db->delete('logs_play', ['account_id' => $id]);
        
        $this->cache->delete("dqedu_TryGame_$id");
        $this->cache->delete("Cards_$id");
        $this->cache->delete("dqedu_CountPoint_$id");
        $this->cache->delete("dqedu_TaskCurrent_$id");
        $this->cache->delete("dqedu_getAccountDQById_$id");
        $this->cache->delete("CountPoint_$id");

        $this->Account_model->delete(['id' => $id]);

        $this->db->trans_complete();
        
        return $this->json_response(true);
    }
    
    public function sendTest()
    {
        // Mail logic
        return $this->json_response(true);
    }
    
    public function export()
    {
        $this->load->library('PHPExcel');

        $this->db->select('account.id, account.full_name, account.username, account.phone, account.created_time, account.regular_pwd, payments.created_time as payment_date, payments.price as payment_price');
        $this->db->from('account');
        $this->db->join('payments', 'payments.account_id = account.id', 'left');
        $this->db->order_by('account.created_time', 'DESC');
        $accounts = $this->db->get()->result();

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        // Headers
        $headers = [
            'A' => 'Mã thanh toán',
            'B' => 'Họ tên',
            'C' => 'Email/Tên đăng nhập',
            'D' => 'Điện thoại',
            'E' => 'Ngày đăng ký',
            'F' => 'Mật khẩu',
            'G' => 'Ngày thanh toán',
            'H' => 'Gói dịch vụ'
        ];

        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 14
            ],
            'alignment' => [
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ],
            'fill' => [
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => ['rgb' => '25B645']
            ]
        ];

        foreach ($headers as $col => $text) {
            $sheet->setCellValue($col . '1', $text);
            $sheet->getColumnDimension($col)->setWidth(25);
            $sheet->getStyle($col . '1')->applyFromArray($headerStyle);
        }
        $sheet->getColumnDimension('H')->setWidth(15);

        // Data
        $row = 2;
        foreach ($accounts as $account) {
            $sheet->setCellValue('A' . $row, "DQ " . $account->id);
            $sheet->setCellValue('B' . $row, $account->full_name);
            $sheet->setCellValue('C' . $row, $account->username);
            $sheet->setCellValue('D' . $row, $account->phone);
            $sheet->setCellValue('E' . $row, $account->created_time);
            $sheet->setCellValue('F' . $row, $account->regular_pwd);
            $sheet->setCellValue('G' . $row, $account->payment_date);
            $sheet->setCellValue('H' . $row, $account->payment_price ? number_format($account->payment_price) : '');

            $sheet->getStyle('A' . $row . ':H' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $row++;
        }

        $filename = 'Tai_khoan_' . date('d-m-Y') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function handle_id($id)
    {
        $method = $this->input->method(TRUE);
        if ($method === 'PUT') {
            return $this->update($id);
        } elseif ($method === 'DELETE') {
            return $this->delete($id);
        }
        return $this->json_response(['message' => 'Method not allowed'], 405);
    }
}
