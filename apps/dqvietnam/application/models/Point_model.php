<?php

class Point_model extends C19_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table = 'logs_point';
        $this->column_order = array('id', 'id'); //thiết lập cột sắp xếp
        $this->column_search = array('id'); //thiết lập cột search
        $this->order_default = array('id' => 'desc'); //cột sắp xếp mặc định
    }

    public function getPointSummary($accountId)
    {
        $query = $this->db->select_sum('point')
            ->from($this->table)
            ->where("$this->table.account_id", $accountId)
            ->where("$this->table.status", 1)
            ->order_by("$this->table.id", 'DESC')->get();
        return $query->row();
    }

    public function checkExistLogsPointByAccTask($account_id, $task_detail_id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where("$this->table.account_id", $account_id);
        $this->db->where("$this->table.task_detail_id", $task_detail_id);
        $this->db->where("$this->table.status", 1);
        $this->db->order_by("$this->table.id", 'DESC');
        $query = $this->db->get();
        $result = $query->row();
        return $result ? $result : false;
    }

    public function checkExistLogsPoint($account_id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where("$this->table.account_id", $account_id);
        $this->db->where("$this->table.status", 1);
        $this->db->order_by("$this->table.id", 'DESC');
        $query = $this->db->get();
        $result = $query->row();
        return $result ? $result : false;
    }

    public function updateAccountId($id_new, $id_old)
    {
        $this->db
            ->where('account_id', $id_old)
            ->update($this->table, [
                'account_id' => $id_new
            ]);
        return true;
    }

}
