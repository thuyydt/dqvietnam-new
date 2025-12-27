<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account_model extends C19_Model
{
    protected $table_device_logged;
    protected $point;
    protected $payment;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'account';
        $this->point = 'logs_point';
        $this->table_device_logged = 'logged_device';//bảng logged device
        $this->column_order = array("$this->table.id", "$this->table.id", "$this->table.username", "point", "$this->table.active", "$this->table.created_time"); //thiết lập cột sắp xếp
        $this->column_search = array("$this->table.username"); //thiết lập cột search
        $this->order_default = array('id' => 'desc'); //cột sắp xếp mặc định
        $this->payment = 'payments';
    }

    public function _where_custom($args)
    {
        if (!empty($args['join']['point'])) {
            $this->order_default = ["$this->point.point" => 'desc'];
            $this->db
                ->join($this->point, "$this->point.account_id = $this->table.id", 'left')
                ->group_by("$this->table.id");
        }
        if (!empty($args['join']['payments'])) {
            $this->db->join($this->payment, "$this->payment.account_id = $this->table.id", 'left')
                ->group_by("$this->table.id");
        }
    }

    public function decodePwd($pwd)
    {
        return $this->bcrypt->encodeBytes($pwd);
    }

    public function check_oauth($field, $oauth)
    {
        $tablename = $this->table;
        $this->db->select('*');
        $this->db->where($field, $oauth);

        return $this->db->get($tablename)->row();
    }

    public function getInfoUserById($id, $resetCache = false)
    {
        $key = "getAccountDQById_$id";
        $data = $this->getCache($key);
        if (empty($data) || $resetCache == true) {
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where("$this->table.id", $id);
            $query = $this->db->get();
            $data = $query->row();
            $this->setCache($key, $data, 60 * 60 * 24 * 7);
        }
        return $data;
    }

    public function getUserByField($key, $value, $status = '')
    {
        $this->db->select('*');
        $this->db->where($this->table . '.' . $key, $value);
        if ($status != '') $this->db->where($this->table . '.active', $status);
        return $this->db->get($this->table)->row();
    }

    public function setIsDone($accountId, $isDone = 1)
    {
        $this->update(['id' => $accountId], ['is_done' => $isDone]);
    }

}
