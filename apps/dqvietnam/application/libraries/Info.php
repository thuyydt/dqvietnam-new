<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Info
{
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Config_model');
    }

    function get($key, $default = "")
    {
        $config = new Config_model();
        return $config->findOne($key)->value ?? $default;
    }
}
