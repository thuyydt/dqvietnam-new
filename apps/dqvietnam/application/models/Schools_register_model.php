<?php

class Schools_register_model extends C19_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->table = 'schools_register';
    $this->column_order = array('id', 'id', 'name', 'email', 'phone', 'status'); //thiết lập cột sắp xếp
    $this->column_search = array('name'); //thiết lập cột search
    $this->order_default = array('id' => 'desc'); //cột sắp xếp mặc định
  }
}
