<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjob_model extends C19_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->table  = "cron_job";
		//$this->table_trans      = "banner_translations";
		// $this->column_order     = array("$this->table.id","$this->table.id", "$this->table.position","$this->table_trans.title", "$this->table.order","$this->table.thumbnail","$this->table.is_status","$this->table.created_time","$this->table.updated_time"); //thiết lập cột sắp xếp
		// $this->column_search    = array("$this->table.id","$this->table_trans.title"); //thiết lập cột search
		 $this->order_default    = array("$this->table.id" => "ASC"); //cột sắp xếp mặc định
	}

	public function addCronJob($id, $type)
    {
        $this->save([
            'type' => $type,
            'is_sync' => 0,
            'relation_id' => $id
        ]);
    }
	
}
