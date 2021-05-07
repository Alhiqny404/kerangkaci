<div class="container bg-white shadow-sm">
  <div class="container p-4">

    <form action="" method="post">
      <?php foreach ($items_cart as $item): ?>
      <?= form_hidden('id_product', $item->id_product); ?>
      <?= form_hidden('status_tmp[]', 1); ?>
      <?= form_hidden('id_cart', $item->id_cart); ?>
      <?= form_hidden('id_carts[]', $item->id_cart); ?>
      <?= form_hidden('total_weight', $total_weight); ?>
      <?= form_hidden('total_price', $total_price); ?>
      <input type="hidden" name="nama_prov">
      <input type="hidden" name="nama_kab">
      <input type="hidden" name="nama_kec">
      <?php  endforeach ?>
      <div class="form-row">
        <div class="form-inline  p-3 col">
          <label for="receiver" class="font-weight-bold">Penerima </label>
          <input type="text" class="form-control mx-sm-3 border-bottom" style="border: 0;" name="receiver"
          id="receiver" placeholder="Nama penerima" name="receiver">
        </div>
        <div class="form-inline  p-3 col">
          <label for="phone" class="font-weight-bold">No. Tlp/Hp </label>
          <input type="number" class="form-control mx-sm-3 border-bottom" style="border: 0;" name="phone"
          id="phone" placeholder="0812">
        </div>
      </div>
      <div class="form-row p-3">
        <div class="col ">
          <table class="mt-4 float-right table">
            <?php  foreach ($items_cart as $item) : ?>
            <tr>
              <td class="p-0">
                <small class="title text-truncate"><?= $item->name_products ?> </small>
              </td>
              <td class="p-0">
                <span class="title text-truncate"><?= $item->price_products ?> </span>
              </td>
              <td class="p-0">
                <span class="title text-truncate"><?= $item->discount_products ?> %</span>
              </td>
              <td class="p-0">
                <span class="title text-truncate">x<?= $item->qty ?> </span>
              </td>
              <td class="p-0">
                <span class="title text-truncate"><?= $item->total_price ?> </span>
              </td>
            </tr>
            <?php endforeach; ?>
            <tr class="table-info">
              <th colspan="4" class="p-0">Total Harga</th>
              <td class="p-0"><?= $total_price ?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="form-row hide-jemput">
      <div class='form-group col-md-3'>
        <label>Provinsi</label>
        <select class='form-control' id='prov' name="prov" required>
          <option value='0'>--PILIH PROVINSI--</option>
        </select>
      </div>
      <div class='form-group col-md-3'>
        <label>Kota / Kabupaten</label>
        <select class='form-control' id='kab' name="kab" required>
          <option value='0'>--- PILIH KABUPATEN ---</option>
        </select>
      </div>
      <div class='form-group col-md-3'>
        <label>Kecamatan</label>
        <select class='form-control' id='kec' name="kec" required>
          <option value='0'>--- PILIH KECAMATAN ---</option>
        </select>
      </div>
      <div class="form-group col-md-3">
        <label for="kode_pos">Kode pos</label>
        <input type="text" class="form-control" id="kode_pos" placeholder="Kode pos" name="kode_pos"
        required="">
      </div>
      <div class='form-group col'>
        <label for="address">Alamat penerima</label>
        <textarea class="form-control" id="address" placeholder="Jl. Kartini"
          name="address_detail" rows="3"></textarea>
      </div>
    </div>
    <div class="form-row">
      <div class='form-group col-md-6 hide-jemput'>
        <label>Pilih Kurir</label>
        <select class='form-control' id='kurir' name="kurir" required>
          <option value='0'>--Pilih Kurir--</option>
          <option value="pos">POS</option>
          <option value="jne">JNE</option>
          <option value="tiki">TIKI</option>
        </select>
      </div>
      <div class='form-group col-md-3 hide-jemput'>
        <label>Layanan</label>
        <select class='form-control' id='service' name="service" required>
          <option value='0'>--- PILIH LAYANAN ---</option>
        </select>
      </div>
      <div class="form-group col-md-3 hide-jemput">
        <label for="ongkir">Ongkir Rp.</label>
        <input type="text" class="form-control" name="postal_fee" id="postal_fee" value="0" readonly required>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label for="total_pay" class="mt-2">Total bayar Rp.</label>
        <input type="text" class="form-control" id="total_pay" name="total_pay" value="" readonly required>
      </div>
      <div class="form-group">
        <button class="btn btn-danger" type="submit" name="submit" value="submit">CHECKOUT</button>
      </div>

    </div>
    <div id="coba" data-coba="ada"></div>

  </form>
</div>
</div>


<script type="text/javascript">
$(document).ready(function() {
//$('.hide-jemput').hide();
$('#total_pay').val("<?=$total_price ?>");



$.ajax({
url: "<?=site_url('api/wilayah/ajax_prov') ?>",
type: 'get',
dataType: 'json',
success: function(data) {
let option = `<option value="">--- PILIH PROVINSI ---</option>`;
$.each(data, function(key, value) {
option += `<option value="`+value.id+`" data-nama="`+value.nama+`">`+value.nama+`</option>`;
});
$('#prov').html(option);
}
});

$('#prov').change(function() {
let id = $(this).val();
$('[name="nama_prov"]').val($(this).find(':selected').data('nama'));
$.ajax({
url: "<?=site_url('api/wilayah/ajax_kab/') ?>"+id,
type: 'get',
dataType: 'json',
data: {
id: id
},
success: function(data) {
let option = `<option value="">--- PILIH KABUPATEN ---</option>`;
$.each(data, function(key, value) {
option += `<option value="`+value.id+`" data-nama="`+value.nama+`">`+value.nama+`</option>`;
});
$('#kab').html(option);

}
});
});


$('#kab').change(function() {
let id = $(this).val();
$('[name="nama_kab"]').val($(this).find(':selected').data('nama'));
$.ajax({
url: "<?=site_url('api/wilayah/ajax_kec/') ?>"+id,
type: 'get',
dataType: 'json',
data: {
id: id
},
success: function(data) {
let option = `<option value="">--- PILIH KECAMATAN ---</option>`;
$.each(data, function(key, value) {
option += `<option value="`+value.id+`" data-nama="`+value.nama+`">`+value.nama+`</option>`;
});
$('#kec').html(option);
}
});
});


$('#kec').change(function() {
let id = $(this).val();
$('[name="nama_kec"]').val($(this).find(':selected').data('nama'));
});


$('#kurir').change(function() {
var kab = $('#kab').val();
var kurir = $('#kurir').val();
$('#service').html(`<option value='0'>MENCARI LAYANAN...</option>`);
$.ajax({
url: "<?=site_url('api/wilayah/getcost') ?>",
method: 'post',
data: {
kab: kab,
kurir: kurir
},
success: function(data) {
$('#service').html(data);
}
});

});


$('#service').change(function() {
var service = $('#service').val();
var total_pay = $('#total_pay').val();

$.ajax({
url: "<?=site_url('api/wilayah/cost'); ?>",
method: "POST",
data: {
service: service,
total_pay: total_pay
},
success: function(data) {
console.log(data);
var hasil = data.split(",");

$('#postal_fee').val(hasil[0]);
$('#total_pay').val(hasil[1]);


}
});
});


});
</script>