<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Activation extends C19_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Activation_code_model');

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

    public function index()
    {
        // Dispatch based on HTTP method
        $method = $this->input->method(TRUE);
        if ($method === 'POST') {
            return $this->store();
        }

        $page = $this->input->get('page') ? $this->input->get('page') : 1;
        $pageSize = 10;
        $offset = ($page - 1) * $pageSize;

        $activation_table = $this->db->dbprefix('activation_code');
        $account_table = $this->db->dbprefix('account');

        $this->db->select($activation_table . '.*, ' . $account_table . '.username, ' . $account_table . '.email');
        $this->db->join('account', $account_table . '.id = ' . $activation_table . '.active_for', 'left');
        $this->db->limit($pageSize, $offset);
        $this->db->order_by($activation_table . '.id', 'DESC');
        $query = $this->db->get('activation_code');
        $result = $query->result();

        foreach ($result as $row) {
            if ($row->active_for) {
                $row->account = (object) [
                    'username' => $row->username,
                    'email' => $row->email
                ];
            } else {
                $row->account = null;
            }
        }

        $total = $this->db->count_all('activation_code');
        
        return $this->json_response([
            'data' => $result,
            'total' => $total,
            'current_page' => (int)$page,
            'per_page' => $pageSize
        ]);
    }

    public function store()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('code', 'Code', 'required|is_unique[activation_code.code]');

        if ($this->form_validation->run() == FALSE) {
             return $this->json_response(['message' => validation_errors()], 500);
        }

        $data = $this->input->post();
        if (isset($data['id'])) {
            unset($data['id']);
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['is_active'] = 0; // Default to unused

        if ($this->Activation_code_model->insert($data)) {
            return $this->json_response(['message' => 'success']);
        } else {
            return $this->json_response(['message' => 'Failed to create activation code'], 500);
        }
    }

    public function update($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('code', 'Code', 'required');

        if ($this->form_validation->run() == FALSE) {
             return $this->json_response(['message' => validation_errors()], 500);
        }

        $data = $this->input->post();
        if (isset($data['id'])) {
            unset($data['id']);
        }
        // $data['updated_at'] = date('Y-m-d H:i:s'); // If column exists

        if ($this->Activation_code_model->update(['id' => $id], $data)) {
            return $this->json_response(['message' => 'success']);
        } else {
             return $this->json_response(['message' => 'Failed to update activation code'], 500);
        }
    }

    public function destroy($id)
    {
        if ($this->Activation_code_model->delete(['id' => $id])) {
            return $this->json_response(['message' => 'success']);
        } else {
            return $this->json_response(['message' => 'Failed to delete activation code'], 500);
        }
    }

    public function handle_id($id)
    {
        $method = $this->input->method(TRUE);
        if ($method === 'PUT') {
            return $this->update($id);
        } elseif ($method === 'DELETE') {
            return $this->destroy($id);
        } elseif ($method === 'GET') {
             // show?
             return $this->json_response(['message' => 'Not implemented']);
        }
        return $this->json_response(['message' => 'Method not allowed'], 405);
    }
}
