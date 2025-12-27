<?php

class Task_model extends C19_Model
{
    public $table_detail;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'task';
        $this->table_detail = 'task_detail';
        $this->column_order = array('id', 'id', 'name', 'training', 'created_time', 'status'); //thiết lập cột sắp xếp
        $this->column_search = array('name'); //thiết lập cột search
        $this->order_default = array('id' => 'desc'); //cột sắp xếp mặc định
    }

    public function save_after($id, $params)
    {
        $data = $params['tasks_detail'];
        if (!empty($data)) foreach ($data as $item) {
            $detail["task_id"] = $id;
            $detail["content"] = $item['content'];
            $detail["type"] = $item['type'];
            $detail["number_order"] = $item['number_order'];
            $detail["point"] = $item['point'] ?? 0;
            $detail["type_point"] = $item['type_point'] ?? 1;
            if (!$this->insert($detail, $this->table_detail)) return false;
        }
    }

    public function update_after($id, $params)
    {
        if (!empty($params['tasks_detail'])) {
            $data = $params['tasks_detail'];
            $detail["task_id"] = $id;
            $this->delete($detail, $this->table_detail);
            if (!empty($data)) foreach ($data as $item) {
                $detail["content"] = $item['content'];
                $detail["type"] = $item['type'];
                $detail["number_order"] = $item['number_order'];
                $detail["point"] = $item['point'] ?? 0;
                $detail["type_point"] = $item['type_point'] ?? 1;
                if (!$this->insert($detail, $this->table_detail)) return false;
            }
        }
    }

    public function getTask() {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where("$this->table.status", 1);
        $this->db->order_by("$this->table.id", 'ACS');
        $query = $this->db->get();
        return $query->row();
    }

    public function getTaskNext($task_current) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where("$this->table.id >", "$task_current");
        $this->db->where("$this->table.status", 1);
        $this->db->order_by("$this->table.id", 'ACS');
        $query = $this->db->get();
        return $query->row();
    }

}