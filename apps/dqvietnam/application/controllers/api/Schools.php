<?php

/**
 * Created by PhpStorm.
 * User: doan_du
 * Date: 08/05/2022
 * Time: 10:22
 */


defined('BASEPATH') or exit('No direct script access allowed');

class Schools extends API_Controller
{
  private $schools_model;

  public function __construct()
  {
    parent::__construct();

    $this->load->model(['Schools_model']);
    $this->schools_model = new Schools_model();
  }

  public function register() {}
}
