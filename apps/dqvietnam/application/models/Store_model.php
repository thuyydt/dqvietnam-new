<?php

class Store_model extends C19_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->table = 'store';
    $this->column_order = array('id', 'phone'); //thiết lập cột sắp xếp
    $this->column_search = array('id', 'phone'); //thiết lập cột search
    $this->order_default = array('id' => 'desc'); //cột sắp xếp mặc định
  }
}
