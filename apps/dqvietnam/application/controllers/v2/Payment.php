<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends C19_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Payments_model');
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
    $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
    $pageSize = $this->input->get('pageSize') ? (int)$this->input->get('pageSize') : 20;
    $offset = ($page - 1) * $pageSize;
    $key = $this->input->get('key');

    // Build query conditions
    $this->db->from('payments');
    $this->db->join('account', 'account.id = payments.account_id', 'left');
    $this->db->join('schools', 'schools.id = payments.school_id', 'left');
    $this->db->where('account.is_payment', 1);

    if ($key) {
      $this->db->group_start();
      $this->db->like('account.username', $key);
      $this->db->or_like('account.full_name', $key);
      $this->db->or_like('account.phone', $key);
      $this->db->or_like('account.email', $key);
      $this->db->group_end();
    }

    // Clone for counting
    $temp_db = clone $this->db;
    $total = $temp_db->count_all_results();

    // Get data
    $this->db->select('payments.*, account.email, account.full_name, account.phone, schools.name as school_name');
    $this->db->order_by('payments.time_payment', 'DESC');
    $this->db->limit($pageSize, $offset);

    $query = $this->db->get();
    $result = $query->result();

    return $this->json_response([
      'data' => $result,
      'total' => $total,
      'current_page' => $page,
      'per_page' => $pageSize
    ]);
  }
}
