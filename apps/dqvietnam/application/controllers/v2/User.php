<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends C19_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Groups_model');
        $this->load->model('Ion_auth_model');
    }

    private function json_response($data, $status = 200)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($status)
            ->set_output(json_encode($data));
    }

    public function index()
    {
        $page = $this->input->get('page') ? $this->input->get('page') : 1;
        $pageSize = $this->input->get('pageSize') ? $this->input->get('pageSize') : 15;
        $offset = ($page - 1) * $pageSize;

        // $this->db->order_by('id', 'DESC');
        // $this->db->limit($pageSize, $offset);
        
        // $query = $this->db->get('users');
        // i want to join groups table to get group id
        $this->db->select('users.*, groups.id as type');
        $this->db->from('users');
        $this->db->join('users_groups', 'users.id = users_groups.user_id', 'left');
        $this->db->join('groups', 'users_groups.group_id = groups.id', 'left');
        $this->db->order_by('users.id', 'DESC');
        $this->db->limit($pageSize, $offset);
        
        $query = $this->db->get();
        $result = $query->result();
        
        return $this->json_response(['data' => $result]);
    }

    public function roles()
    {
        $query = $this->db->get('groups');
        $result = $query->result();
        return $this->json_response($result);
    }

    public function create()
    {
        // Handle JSON input
        $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
        $request = json_decode($stream_clean, true);
        if (!empty($request)) {
            $_POST = array_merge($_POST, $request);
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('phone', 'Phone', [
            'required',
            'regex_match[/^(0|84)[35789][0-9]{8}$/]'
        ], [
            'regex_match' => 'Trường {field} không đúng định dạng.'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');

        if ($this->form_validation->run() == FALSE) {
             return $this->json_response(['message' => validation_errors()], 400);
        }

        $this->db->trans_start();
        
        $data = $this->input->post();
        $type = isset($data['type']) ? $data['type'] : null;
        if (isset($data['type'])) unset($data['type']);
        
        $sendMail = isset($data['sendMail']) ? $data['sendMail'] : 0;
        if (isset($data['sendMail'])) unset($data['sendMail']);
        
        // Hash password and save plain text
        if (isset($data['password'])) {
            $data['regular_pwd'] = $data['password'];
            $data['password'] = $this->Ion_auth_model->hash_password($data['password']);
        }

        $id = $this->Users_model->insert($data);
        $exist = $this->Users_model->get_by(['id' => $id]);

        if ($type) {
            $this->db->insert('users_groups', [
                'user_id' => $id,
                'group_id' => $type
            ]);

            $exist->type = $type;
        }

        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
             return $this->json_response(['message' => 'Transaction failed'], 500);
        }

        return $this->json_response($exist);
    }

    public function delete($id)
    {
        $model = $this->Users_model->get_by(['id' => $id]);
        if (!$model) {
             return $this->json_response(['message' => 'Not found'], 404);
        }
        $this->Users_model->delete(['id' => $id]);



        return $this->json_response(true);
    }

    public function update($id)
    {
        $model = $this->Users_model->get_by(['id' => $id]);
        if (!$model) {
             return $this->json_response(['message' => 'Not found'], 404);
        }

        // Handle JSON input
        $request = json_decode($this->input->raw_input_stream, true);
        if (!empty($request)) {
            $_POST = array_merge($_POST, $request);
        }

        $this->load->library('form_validation');
        // Set data for validation if method exists (CI 3.0+)
        if (method_exists($this->form_validation, 'set_data')) {
            $this->form_validation->set_data($_POST);
        }

        $this->form_validation->set_rules('username', 'Username', 'required|callback_check_username[' . $id . ']');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_check_email[' . $id . ']');
        $this->form_validation->set_rules('phone', 'Phone', [
            'required',
            'regex_match[/^(0|84)[35789][0-9]{8}$/]'
        ], [
            'regex_match' => 'Trường {field} không đúng định dạng.'
        ]);

        if ($this->form_validation->run() == FALSE) {
             $errors = $this->form_validation->error_array();
             $message = implode("\n", $errors);
             if (empty($message)) {
                 $message = validation_errors();
             }
             if (empty($message)) {
                 $message = "Validation failed. POST: " . json_encode($_POST) . ". Raw: " . $this->input->raw_input_stream;
             }
             return $this->json_response(['message' => $message], 400);
        }

        $data = $this->input->post();
        $type = isset($data['type']) ? $data['type'] : null;
        if (isset($data['type'])) unset($data['type']);

        // Hash password and save plain text if password is updated
        if (isset($data['password']) && !empty($data['password'])) {
            $data['regular_pwd'] = $data['password'];
            $data['password'] = $this->Ion_auth_model->hash_password($data['password']);
        } else {
            // If password is empty or not set, remove it from update data to prevent overwriting with empty string
            if (isset($data['password'])) unset($data['password']);
        }

        $this->Users_model->update($id, $data);
        
        if ($type) {
            // update or insert
            $exist = $this->db->get_where('users_groups', ['user_id' => $id])->row();
            if ($exist) {
                $this->db->where('user_id', $id);
                $this->db->update('users_groups', ['group_id' => $type]);
            } else {
                $this->db->insert('users_groups', [
                    'user_id' => $id,
                    'group_id' => $type
                ]);
            }
        }

        $updated = $this->Users_model->get_by(['id' => $id]);

        // merge group id into
        $updated->type = $type;

        return $this->json_response($updated);
    }

    public function check_username($username, $id)
    {
        $this->db->where('username', $username);
        $this->db->where('id !=', $id);
        $user = $this->db->get('users')->row();
        if ($user) {
            $this->form_validation->set_message('check_username', 'Tên tài khoản đã tồn tại.');
            return FALSE;
        }
        return TRUE;
    }

    public function check_email($email, $id)
    {
        $this->db->where('email', $email);
        $this->db->where('id !=', $id);
        $user = $this->db->get('users')->row();
        if ($user) {
            $this->form_validation->set_message('check_email', 'Email đã tồn tại.');
            return FALSE;
        }
        return TRUE;
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
