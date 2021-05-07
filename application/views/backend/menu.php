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
      <?php $this->load->view('_layouts/breadcrumb') ?>
    </div>

    <div class="section-body">


      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <button type="button" class="add btn btn-primary btn-sm" onclick="add()"><i class="fa fa-plus"></i></button>

              <a href="<?=site_url('dashboard/sistem/menu/urutan'); ?>" class="add btn btn-warning btn-sm">Urutkan Menu</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-hover table-sm" id="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>menu</th>
                      <th>title</th>
                      <th>icon</th>
                      <th>tipe</th>
                      <th>opsi</th>
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



<?php $this->load->view('_layouts/js.php'); ?>


<script>
  var save_method; //for save method string
  var table;
  $(document).ready(function() {

    table = $('#table').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= site_url('crud-backend/menu/ajaxList') ?>",
        "type": "POST"
      },
      "columnDefs": [{
        "targets": [-1],
        "orderable": false,
      },
      ],

    });
  });


  function add() {
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambahkan menu'); // Set Title to Bootstrap modal title
    console.log(save_method);
  }

  function edit(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').empty();

    //Ajax Load data from ajax
    $.ajax({
      url: "<?= site_url('crud-backend/menu/ajax_edit/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      cache: false,
      success: function(data) {

        $('[name="id"]').val(data.id);
        $('[name="menu"]').val(data.menu);
        $('[name="title"]').val(data.title);
        $('[name="icon"]').val(data.icon);
        $('[name="tipe"]').val(data.tipe);

        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit menu'); // Set title to Bootstrap modal title

      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
  }

  function save() {
    var url;
    if (save_method == 'add') {
      url = "<?= site_url('crud-backend/menu/ajax_add') ?>";
    } else
    {
      url = "<?= site_url('crud-backend/menu/ajax_update') ?>";
    }

    // ajax adding data to database
    $.ajax({
      url: url,
      type: "POST",
      data: $('#form').serialize(),
      dataType: "JSON",
      cache: false,
      success: function(data) {
        //if success close modal and reload ajax table

        if (data.status == false) {
          if (!data.err.menu == "") {
            $('[name="menu"]').addClass('is-invalid');
            $('[in="menu"]').html(data.err.menu);
          } else {
            $('[name="menu"]').removeClass('is-invalid');
            $('[in="menu"]').html();
          }
          if (!data.err.title == "") {
            $('[name="title"]').addClass('is-invalid');
            $('[in="title"]').html(data.err.title);
          } else {
            $('[name="title"]').removeClass('is-invalid');
            $('[in="title"]').html();
          }
          if (!data.err.icon == "") {
            $('[name="icon"]').addClass('is-invalid');
            $('[in="icon"]').html(data.err.icon);
          } else {
            $('[name="icon"]').removeClass('is-invalid');
            $('[in="icon"]').html();
          }
          if (!data.err.tipe == "") {
            $('[name="tipe"]').addClass('is-invalid');
            $('[in="tipe"]').html(data.err.tipe);
          } else {
            $('[name="tipe"]').removeClass('is-invalid');
            $('[in="tipe"]').html();
          }

        } else {
          $('#modal_form').modal('hide');
          reload_table();
          if (save_method == 'add') {
            iziToast.success({
              title: 'DITAMBAHKAN!',
              message: 'Menu telah ditambahkan',
              position: 'topRight'
            });
          } else
          {
            iziToast.success({
              title: 'UPDATE!',
              message: 'Menu telah diupdate',
              position: 'topRight'
            });
          }

        }

      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');
      }
    });
  }

  function delete_menu(id) {

    swal({
      title: 'Kamu Yakin?',
      text: 'Menu Akan Dihapus',
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {

        // ajax delete data to database
        $.ajax({
          url: "<?php echo site_url('crud-backend/menu/ajax_delete/') ?>"+id,
          type: "POST",
          dataType: "JSON",
          cache: false,
          success: function(data) {
            //if success reload ajax table
            $('#modal_form').modal('hide');
            reload_table();
            swal.close();
            iziToast.success({
              title: 'TERHAPUS!',
              message: 'Menu telah terhapus',
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
          message: 'Menu batal dihapus',
          position: 'topRight'
        });
      }
    });



  }


</script>

<div class="modal fade" tabindex="-1" role="dialog" id="modal_form">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id" />
          <div class="form-body">
            <div class="form-group">
              <label class="control-label">menu</label>
              <input name="menu" placeholder="menu" class="form-control inputan" type="text">
              <div class="invalid-feedback" in="menu"></div>
            </div>
            <div class="form-group none">
              <label class="control-label">title</label>
              <input name="title" placeholder="title" class="form-control inputan" type="text">
              <div class="invalid-feedback" in="title"></div>
            </div>
            <div class="form-group none">
              <label class="control-label col-md-2">icon</label>
              <input name="icon" placeholder="icon" class="form-control inputan" type="text">
              <div class="invalid-feedback" in="icon"></div>
            </div>
            <div class="form-group">
              <label for="tipemenu" class="control-label col-md-2">Tipe</label>
              <select name="tipe" class="form-control tipemenu" id="tipemenu">
                <option value="">--- PILIH TIPE ---</option>
                <option value="1">Biasa</option>
                <option value="2">Dropdown</option>
              </select>
              <div class="invalid-feedback" in="tipe"></div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnSave" onclick="save()">SIMPAN</button>
      </div>
    </div>
  </div>
</div>