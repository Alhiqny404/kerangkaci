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
                <a href="<?=site_url('sistem/menu'); ?>" class="add btn btn-primary btn-sm">Kembali</a>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-hover table-sm" id="table">
                  <thead>
                    <tr>
                      <th>Urutan</th>
                      <th>Menu</th>
                      <th>opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($menu as $m) : ?>
                    <tr>
                      <td><?=$m['urutan'] ?></td>
                      <td><?=$m['menu'] ?></td>
                      <td>
                        <button class="btn btn-sm btn-success" onclick="naikan(<?=$m['id'] ?>,<?=$m['urutan'] ?>)"><i class="fas fa-angle-up"></i>Naikan</button>
                        <button class="btn btn-sm btn-danger" onclick="turunkan(<?=$m['id'] ?>,<?=$m['urutan'] ?>)">Turunkan</button>
                      </td>
                    </tr>
                    <?php endforeach ?>
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
  var save_method; //for save method string
  var table;
  $(document).ready(function() {

    table = $('#table').DataTable({

      "processing": true,
      //Feature control the processing indicator.
      "serverSide": true,
      //Feature control DataTables' server-side processing mode.

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?= site_url('sistem/menu/ajaxUrutan') ?>",
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

  function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
  }

  function naikan(id, urutan) {
    $.ajax({
      url: '<?=site_url("sistem/menu/naikan") ?>',
      type: 'post',
      data: {
        id: id,
        urutan: urutan
      },
      dataType: 'JSON',
      success: function(data) {

        iziToast.success({
          title: 'DINAIKAN!',
          message: 'menu dinaikan',
          position: 'topRight'
        });
        reload_table();
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');
      }
    });
  }

  function turunkan(id, urutan) {
    $.ajax({
      url: '<?=site_url("sistem/menu/turunkan") ?>',
      type: 'post',
      data: {
        id: id,
        urutan: urutan
      },
      dataType: 'JSON',
      success: function(data) {
        reload_table();

        iziToast.error({
          title: 'DITURUNKAN!',
          message: 'menu diturunkan',
          position: 'topRight'
        });
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');
      }
    });
  }



</script>