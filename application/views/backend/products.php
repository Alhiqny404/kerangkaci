<link rel="stylesheet" href="<?= base_url('stisla/'); ?>assets/modules/datatables/datatables.min.css">
<link rel="stylesheet" href="<?= base_url('stisla/'); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('stisla/'); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">

<script src="<?= base_url('stisla/'); ?>assets/modules/datatables/datatables.min.js"></script>
<script src="<?= base_url('stisla/'); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('stisla/'); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?=$title; ?></h1>
      <?php $this->load->view('_layouts/breadcrumb'); ?>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <a href="<?=site_url('dashboard/product/add') ?>" class="add btn btn-primary btn-sm"></button><i class="fa fa-plus"></i></a>
          </div>
          <div class="card-body">
            <d9v class="table-responsive">

              <table class="table table-striped table-hover table-sm" id="table">
                <thead>
                  <tr>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>stok</th>
                    <th>Opsi</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </d9v>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
</div>



<?php $this->load->view('_layouts/js'); ?>




<script>
var save_method; //for save method string
var table;


$(document).ready(function() {


table = $('#table').DataTable({

"processing": true,
"serverSide": true,
"ajax": {
"url": "<?= site_url('crud-backend/product/ajaxList') ?>",
"type": "POST"
},

//Set column definition initialisation properties.
"columnDefs": [{
"targets": [-1],
//last column
"orderable": false,
//set not orderable
},
],

});
});

function detail(slug) {
window.location.href = "<?=site_url('dashboard/product/detail/') ?>"+slug;

}

function add() {
save_method = 'add';
$('#form')[0].reset(); // reset form on modals
$('.form-control').removeClass('is-invalid');
$('.invalid-feedback').empty();
$('#modal_form').modal('show'); // show bootstrap modal
$('.modal-title').text('Tambahkan Kategori'); // Set Title to Bootstrap modal title
console.log(save_method);
}

function edit(id) {
window.location.href = "<?=site_url('dashboard/product/edit/') ?>"+id;
}

function reload_table() {
table.ajax.reload(null,
false); //reload datatable ajax
}

function delete_product(id) {

swal({
title: 'Kamu Yakin?',
text: 'Produk ini Akan Dihapus',
icon: 'warning',
buttons: true,
dangerMode: true,
})
.then((willDelete) => {
if (willDelete) {

// ajax delete data to database
$.ajax({
url: "<?php echo site_url('crud-backend/product/ajax_delete/') ?>"+id,
type: "POST",
dataType: "JSON",
cache: false,
success: function(data) {
$('#modal_form').modal('hide');
reload_table();
swal.close();
iziToast.success({
title: 'TERHAPUS!',
message: 'Data telah terhapus',
position: 'topRight'
});
},
error: function (jqXHR, textStatus, errorThrown) {
alert('Error adding / update data');
}
});

} else {
iziToast.error({
title: 'GAGAL!!',
message: 'Data batal dihapus',
position: 'topRight'
});
}
});

}



function createTextSlug() {
var name_categories = $('[name="name_categories"]').val();
$('[name="slug_categories"]').val(generateSlug(name_categories));
}
function generateSlug(text) {
return text.toString().toLowerCase()
.replace(/^-+/,
'')
.replace(/-+$/,
'')
.replace(/\s+/g,
'-')
.replace(/\-\-+/g,
'-')
.replace(/[^\w\-]+/g,
'');
}


</script>