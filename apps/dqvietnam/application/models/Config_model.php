<?php

class Config_model extends C19_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->table = 'settings';
  }

  public function findOne($key)
  {
    $query =  $this->db->select('value')
      ->from($this->table)
      ->where('key', $key)
      ->get();
    return $query->row();
  }
}
