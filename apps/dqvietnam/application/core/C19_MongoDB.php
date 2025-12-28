<?php


class C19_MongoDB extends CI_Model
{
  public $mongo;

  public function __construct()
  {
    parent::__construct();

    /*Khởi tạo mongodb*/
    $params = array('activate' => 'default');
    $this->load->library('mongo_db');
    $this->mongo = new Mongo_db($params);
  }
}
