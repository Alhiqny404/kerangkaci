<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wilayah extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->keyrajaongkir = '0c017604e721bbe96b59dbe272f58e9c';
    $this->kabupatenrajaongkir = 'https://api.rajaongkir.com/starter/city?key=' . $this->keyrajaongkir;

  }

  public function index() {
    $kabupaten = $this->db->get('wilayah_kabupaten')->result_array();
    foreach ($kabupaten as $kab) {
      $kab = str_replace('Kab. ', '', $kab['nama']);
      $kab = str_replace('Kota ', '', $kab);
      $kab = ucwords(strtolower($kab));
      echo '<pre>';
      print_r($kab);
      echo '</pre>';
    }

  }


  public function ajax_prov() {
    $prov = $this->db->get('wilayah_provinsi')->result_array();
    echo json_encode($prov);
  }
  public function ajax_kab($id) {
    $kab = $this->db->get_where('wilayah_kabupaten', ['provinsi_id' => $id])->result_array();
    echo json_encode($kab);
  }
  public function ajax_kec($id) {
    $kec = $this->db->get_where('wilayah_kecamatan', ['kabupaten_id' => $id])->result_array();
    echo json_encode($kec);
  }

  public function ajax_cost() {
    $id_kab = $this->db->get_where('wilayah_kecamatan', ['id' => $id])->row_array()['kabupaten_id'];
    $name_kab = $this->db->get_where('wilayah_kabupaten', ['id' => $this->input->post('kab')])->row_array()['nama'];
    echo json_encode(1); die;

    $datarajaongkir = json_decode(file_get_contents($this->kabupatenrajaongkir));
    $asal = 'Kuningan';

    $kab = $name_kab;
    $kab1 = str_replace('Kab. ', '', $kab['nama']);
    $kab2 = str_replace('Kota ', '', $kab1);
    $tujuan = ucwords(strtolower($kab));
    //echo json_decode($tujuan); die;
    $semuakabupatenrajaongkir = $datarajaongkir->rajaongkir->results;

    foreach ($semuakabupatenrajaongkir as $row) {
      if ($asal == $row->city_name) {
        $origin = $row->city_id;
      }
      if ($tujuan == $row->city_name) {
        $destination = $row->city_id;
      }
      $destination = 114;
    }
    if ($origin == null || $destination == null) {

      //$this->session->set_flashdata('pesan', 'Data kabupaten yang dipilih tidak ada di rajaongkir');
      // redirect('home');
      echo json_encode(['status' => false]);
    }
    $kurir = ['jne',
      'pos',
      'tiki'];
    $datakurir = [];
    foreach ($kurir as $value) {
      $itemcourier = $this->_cost($origin, $destination, 1000, $value);
      array_push($datakurir, $itemcourier);
    }
    // echo "<pre>";
    // print_r($datakurir);
    // echo "</pre>";
    $data['hasil'] = $datakurir;
    //$this->load->view('hasil', $data);
    echo json_encode($data['hasil']);

  }


  public function getcost() {
    $id = $this->input->post('kab');
    $name = $this->db->get_where('wilayah_kabupaten', ['id' => $id])->row_array()['nama'];
    $filter = str_replace('Kab. ', '', $name);
    $filter1 = str_replace('Kota ', '', $filter);
    $filter2 = ucwords(strtolower($filter1));
    //echo $filter2;
    $origin = 211;
    $dest = $this->api_kab($filter2);
    $weight = 1000;
    $kurir = $this->input->post('kurir');


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "origin=$origin&destination=$dest&weight=$weight&courier=$kurir",

      CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded",
        "key: 0c017604e721bbe96b59dbe272f58e9c"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      $data = json_decode($response, TRUE);

      echo '<option value="" selected disabled>--- PILIH LAYANAN ---</option>';

      for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {

        for ($l = 0; $l < count($data['rajaongkir']['results'][$i]['costs']); $l++) {

          echo '<option value="'.$data['rajaongkir']['results'][$i]['costs'][$l]['cost'][0]['value'].','.$data['rajaongkir']['results'][$i]['costs'][$l]['service'].'('.$data['rajaongkir']['results'][$i]['costs'][$l]['description'].')">';
          echo $data['rajaongkir']['results'][$i]['costs'][$l]['service'].'('.$data['rajaongkir']['results'][$i]['costs'][$l]['description'].')</option>';

        }

      }
    }

  }

  public function cost() {
    $biaya = explode(',', $this->input->post('service', TRUE));
    $total = $this->input->post('total_pay') + $biaya[0];

    echo $biaya[0].','.$total;
  }

  public function get_id_kab($id) {
    echo $id;

  }


  public function api_kab($kab) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "key: 0c017604e721bbe96b59dbe272f58e9c"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      $decode = json_decode($response, true);
      foreach ($decode['rajaongkir']['results'] as $row) {
        if ($kab == $row['city_name']) {
          $id_kab = $row['city_id'];
          break;
        }
      }
      return $id_kab;

    }

  }



}