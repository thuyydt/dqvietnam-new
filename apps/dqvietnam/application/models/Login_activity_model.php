<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_activity_model extends C19_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->table = 'logged_logs';
    $this->column_order = array('id', 'user_id', 'ip', 'device', 'last_logged', 'time_leave', 'is_logged');
    $this->column_search = array('user_id', 'ip');
    $this->order_default = array('id' => 'desc');
  }
}
