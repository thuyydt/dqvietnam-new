<?php

class Payments_model extends C19_Model
{

    public $package_account;
    public $table_account;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'payments';
        $this->package_account = 'package_account';
        $this->table_account = 'account';
        $this->column_order = array('id', 'id', 'name', 'type'); //thiết lập cột sắp xếp
        $this->column_search = array('name'); //thiết lập cột search
        $this->order_default = array('id' => 'desc'); //cột sắp xếp mặc định
    }

    public function save_after($id, $params)
    {
        $detail = [
            'account_id' => $params['account_id'],
            'school_id' => $params['school_id'] ?? 0,
            'package_id' => $params['package_id'] ?? 0,
            'payment_id' => $id,
            'status' => $params['status'] ?? 1
        ];
        if (!$this->insert($detail, $this->package_account)) return false;
    }

    public function update_after($id, $params)
    {
        $detail["payment_id"] = $id;
        $data = $this->getData(['where' => $detail, 'table' => $this->package_account], 'row');
        $this->delete($detail, $this->package_account);
        $detail = [
            'account_id' => $params['account_id'] ?? $data->account_id,
            'package_id' => $params['package_id'] ?? $data->package_id,
            'status' => $params['status'],
            'payment_id' => $id,
        ];

        if (empty($params['school_id'])) {
            $detail['school_id'] = $data->school_id;
        }
        if (!$this->insert($detail, $this->package_account)) return false;
    }

    public function getPaymentByAccountId($id)
    {
        return $this->getData([
            'where' => [
                'account_id' => $id
            ]
        ]);
    }

    public function getDataExcel($date)
    {
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));

        $this->db
            ->select("$this->table.payment_code, $this->table.account_id, $this->table.time_payment, $this->table_account.username")
            ->from($this->table)
            ->join($this->table_account, "$this->table_account.id = $this->table.account_id", 'left');

        if (!empty($month) && !empty($year)) {
            $this->db->where("MONTH(c19_$this->table.time_payment)", $month);
            $this->db->where("YEAR(c19_$this->table.time_payment)", $year);
        }
        return $this->db->get()->result();
    }
}