<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_model extends CI_Model {

  var $table = 'transactions';
  var $column_order = ['id_transaction',
    'total_pay',
    'status',
    'created_at',
    null];
  var $column_search = ['status'];
  var $order = ['pay_at' => 'asc'];

  public function __construct() {
    parent::__construct();
    $this->load->database();
  }


  private function _get_datatables_query() {
    $this->db->from($this->table);
    $this->db->where(['status !=' => 'new']);
    $i = 0;

    foreach ($this->column_search as $item) {
      if ($_POST['search']['value']) {
        if ($i === 0) {
          $this->db->group_start();
          $this->db->like($item,
            $_POST['search']['value']);
        } else
        {
          $this->db->or_like($item,
            $_POST['search']['value']);
        }
        if (count($this->column_search) - 1 == $i)
          $this->db->group_end();
      }
      $i++;
    }

    if (isset($_POST['order'])) {
      $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($this->order)) {
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

  // GET DATA
  function get_datatables() {
    $this->_get_datatables_query();
    if ($_POST['length'] != -1)
      $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered() {
    $this->_get_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all() {
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }

  // GET BERDASARKAN ID
  public function get_by_id($id) {
    $this->db->from($this->table);
    $this->db->where('id_transaction', $id);
    $query = $this->db->get();
    return $query->row();
  }





  public function get_where($where) {
    $this->db->from($this->table);
    $this->db->where($where);
    $query = $this->db->get();
    return $query;
  }

  public function add_transaction($data) {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }

  public function update_transaction($data, $where) {
    $this->db
    ->update($this->table, $data, $where);
    return $this->db->affected_rows();
  }

  public function delete_transaction($where) {
    $this->db->delete('cart', $where);
    redirect(site_url('cart'));
  }


}