<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Activity_model extends C19_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->table = 'logged_logs';
    $this->setting = 'settings';
  }

  public function getLimitLogged()
  {
    $limitLoggedRow = $this->db->from($this->setting)->where('key', 'login_limit')->get()->first_row();
    return !$limitLoggedRow ? 1 : $limitLoggedRow->value;
  }

  public function check_logged_device($userId, $deviceId = '')
  {
    $this->db->where('user_id', $userId);
    $this->db->from($this->table);
    $count = $this->db->count_all_results();

    return $count >= $this->getLimitLogged();
  }
}
