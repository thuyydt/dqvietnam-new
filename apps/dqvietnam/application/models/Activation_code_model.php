<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Activation_code_model extends C19_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->table = 'activation_code';
    $this->column_order = array('id', 'code', 'expired_at', 'is_active', 'active_for', 'active_at');
    $this->column_search = array('code');
    $this->order_default = array('id' => 'desc');
  }
}
