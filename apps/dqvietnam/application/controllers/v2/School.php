<?php
defined('BASEPATH') or exit('No direct script access allowed');

class School extends C19_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Schools_model');
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
    $pageSize = $this->input->get('pageSize') ? $this->input->get('pageSize') : 20;
    $offset = ($page - 1) * $pageSize;

    $this->db->limit($pageSize, $offset);
    $query = $this->db->get('schools');
    $result = $query->result();

    return $this->json_response(['data' => $result]);
  }

  public function create()
  {
    return $this->json_response(['message' => 'Not implemented']);
  }
  public function update($id)
  {
    return $this->json_response(['message' => 'Not implemented']);
  }
  public function delete($id)
  {
    return $this->json_response(['message' => 'Not implemented']);
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
