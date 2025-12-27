<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Smart model.
 */
class C19_Model extends CI_Model
{
    public $table;
    public $table_trans;
    public $table_category;
    public $primary_key;
    public $column_order;
    public $column_search;
    public $order_default;
    public $where_custom;
    private $redis;

    public function __construct()
    {
        parent::__construct();
        $this->table = str_replace('_model', '', get_Class($this));
        $this->primary_key = "id";
        $this->column_order = array("$this->table.id", "$this->table.id", "$this->table_trans.title", "$this->table.is_status", "$this->table.updated_time", "$this->table.created_time"); //thiết lập cột sắp xếp
        $this->column_search = array("$this->table_trans.title"); //thiết lập cột search
        $this->order_default = array("$this->table.created_time" => "DESC"); //cột sắp xếp mặc định

        //load cache driver
        $this->load->driver('cache', array('adapter' => 'file'));
        if (ACTIVE_REDIS === TRUE) {
            try {
                $this->redis = new Redis();
                $this->redis->pconnect(REDIS_HOST, REDIS_PORT);
                if (REDIS_PASS) {
                    $this->redis->auth(REDIS_PASS);
                }
            } catch (Exception $e) {
                $this->redis->close();
                $this->redis = new Redis();
                $this->redis->pconnect(REDIS_HOST, REDIS_PORT);
                if (REDIS_PASS) {
                    $this->redis->auth(REDIS_PASS);
                }
            }
        }
    }

    /*Hàm xử lý các tham số truyền từ Datatables Jquery*/
    public function _get_datatables_query()
    {
        if (!empty($this->input->post('columns'))) {
            $i = 0;
            foreach ($this->column_search as $item) // loop column
            {
                if (trim(xss_clean($this->input->post('search')['value']))) // if datatable send POST for search
                {
                    if ($i === 0) // first loop
                    {
                        $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                        $this->db->like($item, trim(xss_clean($this->input->post('search')['value'])));
                    } else {
                        $this->db->or_like($item, trim(xss_clean($this->input->post('search')['value'])));
                    }

                    if (count($this->column_search) - 1 == $i) //last loop
                        $this->db->group_end(); //close bracket
                }
                $i++;
            }

            if ($this->input->post('order')) {
                if (!empty($this->column_order)) {
                    $this->db->order_by($this->column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
                }
            } else if (isset($this->order_default)) {
                $order = $this->order_default;
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }
    }

    public function _where_before($args, $select = '')
    {
        if (empty($select)) $select = "*";
        // $lang_code = $this->session->admin_lang; //Mặc định lấy lang của Admin

        extract($args);
        //$this->db->distinct();

        if (!empty($table)) {
            $this->table = $table;
        }

        $this->db->select($select);
        $this->db->from($table ?? $this->table);

        if (!empty($where)) {
            $this->db->where($where);
        }

        if (isset($search)) {
            if (is_array($search)) {
                foreach ($search as $key => $item) {
                    $this->db->like($key, $item);
                }
            } else {
                $this->db->like('title', $search);
            }
        }

        if (isset($status))
            $this->db->where("$table.status", $status);

        if (!empty($in))
            $this->db->where_in("$table.id", $in);
        if (!empty($not_in))
            $this->db->where_not_in("$table.id", $not_in);
    }

    public function _where_after($args, $typeQuery)
    {
        $page = 1; //Page default
        $limit = 10;
        extract($args);

        $this->_get_datatables_query();
        if ($typeQuery === null || empty($typeQuery)) {
            //query for datatables jquery
            if (!empty($order) && is_array($order)) {
                foreach ($order as $k => $v)
                    $this->db->order_by($k, $v);
            } else if (!empty($this->order_default)) {
                $order = $this->order_default;
                $this->db->order_by(key($order), $order[key($order)]);
            }
            if (!isset($args['offset'])) {
                $offset = ($page - 1) * $limit;
            }
            $this->db->limit($limit, $offset);
        }
    }

    public function _where_custom($args)
    {
    }

    //Xử lý tham số truyền vào. Tham số truyền vào phải dạng Array
    private function _where($args, $typeQuery = null, $select = '')
    {
        $this->_where_before($args, $select);
        $this->_where_custom($args);
        $this->_where_after($args, $typeQuery);
    }

    /*
     * Đếm tổng số bản ghi
     * */
    public function getTotalAll($table = '')
    {
        if (empty($table)) $table = $this->table;
        $this->db->from($table);
        return $this->db->count_all_results();
    }


    public function getTotal($args = [])
    {
        $this->_where($args, "count");
        $query = $this->db->get();
        //ddQuery($this->db);
        return $query->num_rows();
    }

    public function getData($args = array(), $returnType = "object", $select = '')
    {
        $this->_where($args, null, $select);
        $query = $this->db->get();
        //ddQuery($this->db);
        if ($returnType === "object") return $query->result(); //Check kiểu data trả về
        else if ($returnType === "row") return $query->row(); //Check kiểu data trả về
        else return $query->result_array();
    }

    /*
     * Lấy dữ liệu một hàng ra
     * Truyền vào id
     * */
    public function getById($id, $select = '*', $lang_code = null)
    {

        $this->db->select($select);
        $this->db->from("$this->table as A");
        $this->db->where("A.id", $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getSelect2($ids)
    {
        $this->db->select("$this->table.id, title AS text");
        $this->db->from($this->table);
        if (!empty($this->table_trans)) {
            $this->db->join($this->table_trans, "$this->table.id = $this->table_trans.id");
            $this->db->where("$this->table_trans.language_code", $this->session->admin_lang);
        }
        if (is_array($ids)) $this->db->where_in("$this->table.id", $ids);
        else $this->db->where("$this->table.id", $ids);

        $query = $this->db->get();
        return $query->result();
    }


    public function save($data, $tablename = '')
    {
        if ($tablename == '') {
            $tablename = $this->table;
        }
        $data_store = array();
        if (!empty($data)) foreach ($data as $k => $item) {
            if (!is_array($item)) $data_store[$k] = $item;
        }

        if (!$this->db->insert($tablename, $data_store)) {
            log_message('info', json_encode($data_store));
            log_message('error', json_encode($this->db->error()));
            return false;
        } else {
            $id = $this->db->insert_id();

            /*Xử lý bảng category nếu có*/
            if (!empty($this->table_category) && !empty($data['category_id']) && is_array($data['category_id'])) {
                $dataCategory = $data['category_id'];
                if (!empty($dataCategory)) foreach ($dataCategory as $item) {
                    $tmpCategory[$this->table . "_id"] = $id;
                    $tmpCategory["category_id"] = $item;
                    if (!$this->insert($tmpCategory, $this->table_category)) return false;
                    unset($tmpCategory);
                }
            }
            if (isset($data['category_id'])) unset($data['category_id']);

            $this->save_after($id, $data);

            //$this->cache->clean();
            return $id;
        }
    }

    public function save_after($id, $data)
    {

    }


    public function search($conditions = null, $limit = 500, $offset = 0, $tablename = '')
    {
        if ($tablename == '') {
            $tablename = $this->table;
        }
        if ($conditions != null) {
            $this->db->where($conditions);
        }

        $query = $this->db->get($tablename, $limit, $offset);

        return $query->result();
    }

    public function single($conditions, $tablename = '')
    {
        if ($tablename == '') {
            $tablename = $this->table;
        }
        $this->db->where($conditions);

        return $this->db->get($tablename)->row();
    }

    public function get_by($conditions, $tablename = '')
    {
        return $this->single($conditions, $tablename);
    }

    public function insert($data, $tablename = '')
    {
        if ($tablename == '') {
            $tablename = $this->table;
        }
        $this->db->insert($tablename, $data);
        //$this->cache->clean();
        return $this->db->affected_rows();
    }


    public function insertMultiple($data, $tablename = '')
    {
        if ($tablename == '') {
            $tablename = $this->table;
        }
        $this->db->insert_batch($tablename, $data);
        //$this->cache->clean();
        return $this->db->affected_rows();
    }

    public function insertOnUpdate($data, $tablename = '')
    {
        if ($tablename == '') {
            $tablename = $this->table;
        }
        $data_update = [];
        if (!empty($data)) foreach ($data as $k => $val) {
            $data_update[] = $k . " = '" . $val . "'";
        }
        $queryInsertOnUpdate = $this->db->insert_string($tablename, $data) . " ON DUPLICATE KEY UPDATE " . implode(', ', $data_update);
        if (!$this->db->query($queryInsertOnUpdate)) {
            log_message('info', json_encode($data));
            log_message('error', json_encode($this->db->error()));
            return false;
        }
        //$this->cache->clean();
        return $this->db->affected_rows();
    }

    public function update($conditions, $data, $tablename = '')
    {
        if ($tablename == '') {
            $tablename = $this->table;
        }
        $dataInfo = [];
        if (!empty($data)) foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $dataInfo[$key] = $value;
                unset($data[$key]);
            }
        }

        if (!$this->db->update($tablename, $dataInfo, $conditions)) {
            log_message('info', json_encode($conditions));
            log_message('info', json_encode($data));
            log_message('error', json_encode($this->db->error()));
            return false;
        }

        /*Xử lý bảng category nếu có*/
        if (!empty($this->table_category) && isset($data['category_id'])) {
            $dataCategory = $data['category_id'];
            $tmpCategory[$this->table . "_id"] = $conditions['id'];
            $this->delete($tmpCategory, $this->table_category);
            if (!empty($dataCategory)) foreach ($dataCategory as $item) {
                $tmpCategory["category_id"] = $item;
                if (!$this->insert($tmpCategory, $this->table_category)) {
                    log_message('error', json_encode($this->db->error()));
                    return false;
                }
            }
        }
        if (isset($data['category_id'])) unset($data['category_id']);

        if (is_array($conditions) && isset($conditions['id'])) {
            $this->update_after($conditions['id'], $data);
        } elseif (is_numeric($conditions) || is_string($conditions)) {
             // Try to guess ID if conditions is just the ID
             $this->update_after($conditions, $data);
        }

        //$this->cache->clean();
        return true;
    }

    public function update_after($id, $data)
    {

    }

    public function delete($conditions, $tablename = '')
    {
        if ($tablename == '') {
            $tablename = $this->table;
        }
        $this->db->where($conditions);
        if (!$this->db->delete($tablename)) {
            log_message('info', json_encode($conditions));
            log_message('info', json_encode($tablename));
            log_message('error', json_encode($this->db->error()));
        }
        //$this->cache->clean();
        return $this->db->affected_rows();
    }

    public function count($conditions = null, $tablename = '')
    {
        if ($conditions != null) {
            $this->db->where($conditions);
        }

        if ($tablename == '') {
            $tablename = $this->table;
        }

        $this->db->select('1');
        return $this->db->get($tablename)->num_rows();
    }

    public function getLastOrder()
    {
        $this->db->select('order');
        $this->db->from($this->table);
        $this->db->order_by('order', 'DESC');
        $data = $this->db->get()->row();
        return $data;
    }

    public function getLastRecord()
    {
        return $this->db
            ->select('*')
            ->from($this->table)
            ->order_by('id', 'DESC')
            ->get()->row();
    }

    public function getFirstRecord()
    {
        return $this->db
            ->select('*')
            ->from($this->table)
            ->get()->row();
    }

    public function getCache($key, $isObject = true)
    {
        $key = REDIS_PREFIX . $key;
        $data = ACTIVE_REDIS === TRUE ? $this->redis->get($key) : '';
        if (!empty($data) && $isObject === true) $data = json_decode($data);
        return $data;
    }

    public function setCache($key, $value = [], $timeOut = null)
    {
        $key = REDIS_PREFIX . $key;
        if (ACTIVE_REDIS !== TRUE) return false;
        $this->redis->set($key, json_encode($value), $timeOut);
    }
}
