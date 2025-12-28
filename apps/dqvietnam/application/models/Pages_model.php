<?php

class Pages_model extends C19_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->table = 'pages';
    $this->column_order = array('id', 'id', 'name'); //thiết lập cột sắp xếp
    $this->column_search = array('name'); //thiết lập cột search
    $this->order_default = array('id' => 'desc'); //cột sắp xếp mặc định
  }

  public function slugToId($slug)
  {
    $this->db->select($this->table . '.id');
    $this->db->from($this->table . '');
    $this->db->where($this->table . '.slug', $slug);
    $data = $this->db->get()->row();
    //ddQuery($this->db);
    return !empty($data) ? $data->id : null;
  }

  public function getPageByLayout($layout)
  {
    $this->db->select('*');
    $this->db->from($this->table . ' AS A');
    $this->db->where('A.status', 1);
    if (is_array($layout)) {
      $this->db->where_in('A.layout', $layout);
      $this->db->order_by('A.id', 'DESC');
      $data = $this->db->get()->result();
    } else {
      $this->db->where('A.style', $layout);
      $data = $this->db->get()->row();
    }
    return $data;
  }
}
