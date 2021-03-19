<?php

function harus_login() {
  $ci = get_instance();
  if (!$ci->session->userdata('email')) {
    redirect('login');
  } else
  {
    $roleId = $ci->session->userdata('role_id');
    $menu = $ci->uri->segment(1);

    $query = $ci->db->get_where('menu', ['menu' => $menu])->row_array();
    $menuId = $query['id'];
    $access = $ci->db->get_where('role_menu', ['role_id' => $roleId, 'menu_id' => $menuId]);

    if ($access->num_rows() < 1) {
      redirect('login/blokir');
    }
  }
}


function menu() {
  $ci = get_instance();
  $roleId = $ci->session->userdata('role_id');

  $queryM = "
             SELECT menu.id, menu.menu FROM menu
             INNER JOIN role_menu
             ON role_menu.menu_id = menu.id
             WHERE role_menu.role_id = $roleId
            ";
  return $menu = $ci->db->query($queryM)->result_array();
}

function submenu($id) {
  $ci = get_instance();
  $menuId = $id;
  $querySM = "
            SELECT * FROM sub_menu WHERE menu_id = $menuId
            ";
  return $subMenu = $ci->db->query($querySM)->result_array();
}

function datauser($email) {

  $ci = get_instance();
  $query = "
  SELECT `avatar`,`nama` FROM `user` WHERE `email` = '$email'
  ";
  $user = $ci->db->query($query)->row_array();
  return $datauser = [
    'avatar' => $user['avatar'],
    'nama' => $user['nama']
  ];
}

function access($roleId, $menuId) {
  $ci = get_instance();

  $ci->db->where('role_id', $roleId);
  $ci->db->where('menu_id', $menuId);
  $return = $ci->db->get('role_menu');

  if ($return->num_rows() > 0) {
    return 'checked="checked"';
  }

}