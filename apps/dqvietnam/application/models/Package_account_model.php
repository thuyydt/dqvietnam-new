<?php

class Package_account_model extends C19_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'package_account';
        $this->column_order = array('id', 'id'); //thiết lập cột sắp xếp
        $this->column_search = array(); //thiết lập cột search
        $this->order_default = array('id' => 'desc'); //cột sắp xếp mặc định
    }

    public function getInfoByAccountId($account_id, $resetCeache = false) {
        $key = "getPackageByAccount_$account_id";
        $data = $this->getCache($key);
        if(empty($data) || $resetCeache == true){
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where("$this->table.account_id", $account_id);
            $query = $this->db->get();
            $data = $query->row();
            $this->setCache($key, $data, 60*60*24*7);
        }
        return $data;
    }

    public function getInfoBySchoolId($school_id, $resetCeache = false) {
        $key = "getPackageBySchool_$school_id";
        $data = $this->getCache($key);
        if(empty($data) || $resetCeache == true){
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where("$this->table.school_id", $school_id);
            $query = $this->db->get();
            $data = $query->row();
            $this->setCache($key, $data, 60*60*24*7);
        }
        return $data;
    }

}