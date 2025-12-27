<?php

class Report_model extends C19_Model
{
    public $logs_point = '';
    public $logs_play = '';
    public $task_detail = '';

    public function __construct()
    {
        parent::__construct();
        $this->logs_point = 'logs_point';
        $this->logs_play = 'logs_play';
        $this->task_detail = 'task_detail';
    }

    public function getLastTask($userId)
    {
        $this->db->where('account_id', $userId);
        $this->db->order_by("$this->logs_play.id", 'DESC');
        $query = $this->db->get();
        return $query->row();
    }

    public function updateAccountId($id_new, $id_old)
    {
        $this->db
            ->where('account_id', $id_old)
            ->update($this->logs_play, [
                'account_id' => $id_new
            ]);
        return true;
    }

    public function checkExistLogsPlay($account_id)
    {
        $this->db->select('*');
        $this->db->from($this->logs_play);
        $this->db->where("$this->logs_play.account_id", $account_id);
        $this->db->where("$this->logs_play.status", 1);
        $this->db->order_by("$this->logs_play.id", 'DESC');
        $query = $this->db->get();
        $result = $query->row();
        return $result ? $result : false;
    }

    public function getAnswerByAccountId($account_id, $key)
    {
        $this->db->select('*');
        $this->db->from($this->logs_play);
        $this->db->where("$this->logs_play.account_id", $account_id);
        $this->db->where("$this->logs_play.key", $key);
        $query = $this->db->get();
        $result = $query->row();
        return $result ? $result : false;
    }

    public function getCountPointForType($account_id, $type = '', $is_done = 0)
    {
        $where = ' WHERE account_id = ' . $account_id;
        if (!empty($type)) $where .= ' AND task_type_point = ' . $type;

        $sql = $this->queryCommonGetPointForType("", $is_done);

        $sql .= $where;
        $query = $this->db->query($sql);
        if(!$query) return [];
        if (!empty($type)) {
            return $query->row();
        }
        return $query->result();
    }

    public function getCountPointForAccountDone($school_id)
    {
        $sql = $this->queryCommonGetPointMedium("SUM( point_medium ) AS point", $school_id);

        $query = $this->db->query($sql);
        $point = $query->row();

        if (!empty($point)) return $point->point ?? 0;
        return 0;
    }

    public function getPointForAccountDone($school_id)
    {
        $sql = $this->queryCommonGetPointMedium("*", $school_id);
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function getDataAccountLever4($school_id, $page, $limit = 10)
    {
        $sql_limit = "";

        if ($page) {
            $offset = ($page - 1) * $limit;
            $sql_limit = "LIMIT " . $offset . ", " . $limit;
        }

        $sql = $this->queryCommonGetPointMedium("*", $school_id);

        $sql .= " WHERE point_medium < 88 ORDER BY point_medium DESC  " . $sql_limit;

        $query = $this->db->query($sql);

        if ($page) {
            return $query->result();
        } else {
            return $query->num_rows();
        }
    }

    private function queryCommonGetPointMedium($select = '*', $school_id = "", $is_done = 1)
    {
        $sql = $this->queryCommonGetPointForType($school_id, $is_done);

        return "SELECT " . $select . " FROM (
                    SELECT *, SUM( point_dq ) / 8 AS point_medium FROM ( " . $sql . " ) AS point_total 
                    GROUP BY point_total.account_id 
                ) AS result";
    }

    private function queryCommonGetPointForType($school_id = "", $is_done = 1)
    {
        $select = '*';

        $where_schools = "";
        if (!empty($school_id)) {
            $where_schools = "AND c19_account.schools_id = " . $school_id;
        }

        return "SELECT " . $select . ", point_total AS point_dq FROM
                    (
                    SELECT
                        c19_logs_point.account_id,
                        c19_logs_point.type,
                        c19_logs_point.task_type_point,
                        c19_account.username,
                        c19_account.birthday,
                        TIMESTAMPDIFF( YEAR, c19_account.birthday, CURDATE( ) ) AS age,
                        SUM( c19_logs_point.point ) AS point_total 
                    FROM
                        `c19_logs_point`
                        LEFT JOIN c19_account ON c19_account.id = c19_logs_point.account_id 
                    WHERE
                        c19_account.is_done = " . $is_done . "  " . $where_schools . "
                    GROUP BY
                        c19_logs_point.account_id,
                        c19_logs_point.task_type_point 
                    ) AS point_for_type ";
    }
}
