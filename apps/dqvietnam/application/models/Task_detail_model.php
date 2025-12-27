<?php

class Task_detail_model extends C19_Model
{
    protected $table_task;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'task_detail';
        $this->table_task = 'task';
        $this->column_order = array('id', 'id'); //thiết lập cột sắp xếp
        $this->column_search = array('id'); //thiết lập cột search
        $this->order_default = array('id' => 'desc'); //cột sắp xếp mặc định
    }

    public function getTaskDetailByTaskId($task_id)  {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where("$this->table.task_id", $task_id);
        $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }

    public function getTaskDetailTraining()
    {
        $this->db->select("$this->table.*");
        $this->db->from($this->table);
        $this->db->join($this->table_task, "$this->table.task_id = $this->table_task.id");
        $this->db->where("$this->table_task.training", 1);
        $this->db->order_by("$this->table.task_id", 'ASC');
        $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }

}