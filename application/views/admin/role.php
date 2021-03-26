<?php $this->load->view('dist/_partials/header'); ?>


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
              <button type="button" class="add btn btn-primary btn-sm" onclick="add()"><i class="fa fa-plus"></i></button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-hover table-sm" id="table">
                  <thead class="text-center">
                    <tr>
                      <th>
                        <div class="custom-checkbox custom-control">
                          <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                          <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                        </div>
                      </th>
                      <th>No</th>
                      <th>Role</th>
                      <th>opsi</th>
                    </tr>
                  </thead>
                  <tbody class="text-center">
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



<?php $this->load->view('dist/_partials/footer'); ?>



<script>
  let save_method; //for save method string
  let table;
  $(document).ready(function() {
    table = $('#table').DataTable({

      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?= site_url('sistem/role/ajaxList') ?>",
        "type": "POST"
      },

      //Set column definition initialisation properties.
      "columnDefs": [{
        "targets": [-1], //last column
        "orderable": false, //set not orderable
      },
      ],

    });
  });


  function add() {
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('input.inputan').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambahkan Role'); // Set Title to Bootstrap modal title
    console.log(save_method);
  }

  function edit(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('input.inputan').removeClass('is-invalid');
    $('.invalid-feedback').empty();

    //Ajax Load data from ajax
    $.ajax({
      url: "<?= site_url('sistem/role/ajax_edit/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        $('[name="id"]').val(data.id);
        $('[name="role"]').val(data.role);

        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit Role'); // Set title to Bootstrap modal title

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
    let url;
    if (save_method == 'add') {
      url = "<?= site_url('sistem/role/ajax_add') ?>";
    } else
    {
      url = "<?= site_url('sistem/role/ajax_update') ?>";
    }

    // ajax adding data to database
    $.ajax({
      url: url,
      type: "POST",
      data: $('#form').serialize(),
      dataType: "JSON",
      success: function(data) {
        //if success close modal and reload ajax table
        console.log(data.status);
        if (data.status == false) {
          $('input.inputan').addClass('is-invalid');
          $('.invalid-feedback').html(data.errors);
          console.log(data.errors);
        } else {
          let namaRole = $('[name="role"]').val();
          $('#modal_form').modal('hide');
          reload_table();
          if (save_method == 'add') {
            iziToast.success({
              title: 'DITAMBAHKAN!',
              message: 'role telah ditambahkan',
              position: 'topRight'
            });
          } else
          {
            iziToast.success({
              title: 'UPDATE!',
              message: 'role telah diupdate',
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

  function delete_role(id) {



    swal({
      title: 'Kamu Yakin?',
      text: 'Role Akan Dihapus',
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        // ajax delete data to database
        $.ajax({
          url: "<?php echo site_url('sistem/role/ajax_delete/') ?>"+id,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            //if success reload ajax table
            $('#modal_form').modal('hide');
            reload_table();
            swal.close();
            iziToast.success({
              title: 'TERHAPUS!',
              message: 'role telah terhapus',
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
          message: 'role batal dihapus',
          position: 'topRight'
        });
      }
    });

  }

  function akses(id) {
    document.location.href = "<?=site_url('sistem/role/akses/') ?>"+id;
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
        <form id="form" action="#" class="form-horizontal">
          <input type="hidden" value="" name="id" />
          <div class="form-body">
            <div class="form-group">
              <label class="control-label">Role</label>
              <input name="role" placeholder="Role" id="role" class="form-control inputan" type="text">
              <div class="invalid-feedback">
                Please choose a username.
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btnSave" onclick="save()">SIMPAN</button>
        </form>
      </div>
    </div>
  </div>
</div>