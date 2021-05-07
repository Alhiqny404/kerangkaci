<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_model extends CI_Model {

  var $table = 'cart';

  public function get_where($where) {
    $this->db->from($this->table);
    $this->db->where($where);
    $query = $this->db->get();
    return $query;
  }

  public function add_cart($data) {
    $this->db->insert('cart', $data);
    return $this->db->insert_id();
  }

  public function update_cart($data, $where) {
    $this->db
    ->update($this->table, $data, $where);
    return $this->db->affected_rows();
  }

  public function delete_cart($where) {
    $this->db->delete('cart', $where);
    redirect(site_url('cart'));
  }


}