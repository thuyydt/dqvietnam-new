<?php

class Schools_model extends C19_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->table = 'schools';
    $this->column_order = array('id', 'id', 'name', 'province'); //thiết lập cột sắp xếp
    $this->column_search = array('name'); //thiết lập cột search
    $this->order_default = array('id' => 'desc'); //cột sắp xếp mặc định
  }

  public function getInfoField($value, $field = 'id')
  {
    $this->db->select('*');
    $this->db->from($this->table);
    $this->db->where($field, $value);
    $query = $this->db->get();
    return $query->row();
  }

  public function _where_custom($args)
  {
    if (!empty($args['account_id'])) {
      $this->db
        ->join('account', 'account.schools_id=schools.id')
        ->where("account.id", $args['account_id']);
    }
  }

  public function getInfoById($id, $resetCache = false)
  {
    $this->db->select('*');
    $this->db->from($this->table);
    $this->db->where("$this->table.id", $id);
    $query = $this->db->get();
    return $query->row();
  }
}
