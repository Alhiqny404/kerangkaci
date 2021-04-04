<?php $getId = $this->uri->segment(4); ?>


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
    </div>

    <div class="section-body">


      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="text-right">
                <a href="<?= site_url('sistem/role'); ?>" class="add mb-4 btn btn-primary mt-3" onclick="tambah()" style="background-color: #00aaff;padding:5px 10px">Kembali</a>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-hover table-sm" id="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Menu</th>
                      <th>Akses</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>



<?php $this->load->view('_layouts/js'); ?>




<script>

  let save_method; //for save method string
  let table;
  let getId = <?= $this->uri->segment(4); ?>;
  $(document).ready(function() {

    console.log(getId);

    table = $('#table').DataTable({

      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?= site_url('sistem/role/ajaxAccess/') ?>"+getId,
        "type": "POST"
      },

      //Set column definition initialisation properties.
      "columnDefs": [{
        "targets": [-1], //last column
        "orderable": false, //set not orderable
      },
      ],
      success: function(data) {
        console.log(data);
      }

    });

  });

  function changeAccess(menuId, roleId) {


    $.ajax({
      url: "<?= site_url('sistem/role/changeAccess'); ?>",
      type: "post",
      data: {
        menuId: menuId,
        roleId: roleId
      },
      success: function() {
        iziToast.success({
          title: 'UPDATE!',
          message: 'Akses Telah diubah',
          position: 'topRight'
        });
        console.log('success');
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }

    });
  }


</script>