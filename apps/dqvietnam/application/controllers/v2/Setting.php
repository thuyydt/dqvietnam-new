<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends C19_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Config_model');
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
        $query = $this->db->get('settings');
        $result = $query->result();
        return $this->json_response($result);
    }

    public function store()
    {
        $all = $this->input->post();
        if ($all) {
            foreach ($all as $key => $value) {
                $exists = $this->Config_model->get_by(['key' => $key]);
                if ($exists) {
                    $this->Config_model->update($exists->id, ['value' => $value]);
                } else {
                    $this->Config_model->insert(['key' => $key, 'value' => $value]);
                }
            }
        }
        return $this->json_response(true);
    }

    public function handle_index()
    {
        $method = $this->input->method(TRUE);
        if ($method === 'POST') {
            return $this->store();
        }
        return $this->index();
    }
}
