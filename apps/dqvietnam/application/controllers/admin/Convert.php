<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Convert extends  Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
  }
  public function convertTime()
  {

    $this->db->select(['created_time', 'updated_time', 'id']);
    $this->db->from('channel');
    $data = $this->db->get()->result();
    foreach ($data as $item) {
      $this->db->update('channel', ['created_time' => date('Y-m-d H:i:s', (int)$item->created_time / 1000), 'updated_time' => date('Y-m-d H:i:s', (int)$item->updated_time / 1000)], 'id=' . $item->id);
    }
  }
}
