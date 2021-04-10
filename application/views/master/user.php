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
              <button type="button" class="add btn btn-primary btn-sm" onclick="add()"><i class="fa fa-plus"></i></button>
            </div>
            <div class="card-body">
              <d9v class="table-responsive">

                <table class="table table-striped table-hover table-sm" id="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>Foto Profile</th>
                      <th>Role</th>
                      <th>Akun Dibuat</th>
                      <th>Status Aktif</th>
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

  function coba(id, status) {

    $.ajax({
      url: "<?= site_url('master/user/status/'); ?>"+id,
      type: "post",
      data: {
        id: id, status: status
      },
      success: function() {
        reload_table();
        if (status == 0) {
          iziToast.success({
            title: 'DIAKTIFKAN!',
            message: 'user telah diaktifkan',
            position: 'topRight'
          });
        } else
        {
          iziToast.success({
            title: 'DIBLOKIR!',
            message: 'User telah diblokir',
            position: 'topRight'
          });
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });

  }

  $(document).ready(function() {


    table = $('#table').DataTable({

      "processing": true,
      //Feature control the processing indicator.
      "serverSide": true,
      //Feature control DataTables' server-side processing mode.

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?= site_url('master/user/ajaxList') ?>",
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


  function add() {
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambahkan User'); // Set Title to Bootstrap modal title
    console.log(save_method);
  }

  function edit(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('.password').html('<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="">Ganti Passoword</a>');

    //Ajax Load data from ajax
    $.ajax({
      url: "<?= site_url('master/user/ajax_edit/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        $('[name="id"]').val(data.id);
        $('[name="nama"]').val(data.nama);
        $('[name="email"]').val(data.email);
        $('[name="avatar"]').val(data.avatar);
        $('[name="role_id"]').val(data.role_id);

        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit User'); // Set title to Bootstrap modal title

      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function reload_table() {
    table.ajax.reload(null,
      false); //reload datatable ajax
  }

  function save() {
    console.log(save_method);
    var url;
    if (save_method == 'add') {
      url = "<?= site_url('master/user/ajax_add') ?>";
    } else
    {
      url = "<?= site_url('master/user/ajax_update') ?>";
    }

    // ajax adding data to database
    $.ajax({
      url: url,
      type: "POST",
      data: $('#form').serialize(),
      dataType: "JSON",
      success: function(data) {
        //if success close modal and reload ajax table

        if (data.status == false) {
          if (!data.err.nama == "") {
            $('[name="nama"]').addClass('is-invalid');
            $('[in="nama"]').html(data.err.nama);
          } else {
            $('[name="nama"]').removeClass('is-invalid');
            $('[in="nama"]').html();
          }
          if (!data.err.email == "") {
            $('[name="email"]').addClass('is-invalid');
            $('[in="email"]').html(data.err.email);
          } else {
            $('[name="email"]').removeClass('is-invalid');
            $('[in="email"]').html();
          }
          if (!data.err.password == "") {
            $('[name="password"]').addClass('is-invalid');
            $('[in="password"]').html(data.err.password);
          } else {
            $('[name="password"]').removeClass('is-invalid');
            $('[in="password"]').html();
          }
          if (!data.err.role_id == "") {
            $('[name="role_id"]').addClass('is-invalid');
            $('[in="role_id"]').html(data.err.role_id);
          } else {
            $('[name="role_id"]').removeClass('is-invalid');
            $('[in="role_id"]').html();
          }

        } else {
          $('#modal_form').modal('hide');
          reload_table();
          if (save_method == 'add') {
            iziToast.success({
              title: 'DITAMBAHKAN!',
              message: 'data telah ditambahkan',
              position: 'topRight'
            });
          } else
          {
            iziToast.success({
              title: 'UPDATE!',
              message: 'data telah diupdate',
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

  function delete_user(id) {


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
          url: "<?php echo site_url('master/user/ajax_delete/') ?>"+id,
          type: "POST",
          dataType: "JSON",
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
              <label class="control-label col-md-2">Nama</label>
              <input name="nama" placeholder="nama" class="form-control" type="text">
              <div class="invalid-feedback" in="nama"></div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2">email</label>
              <input name="email" placeholder="email" class="form-control" type="text">
              <div class="invalid-feedback" in="email"></div>
            </div>
            <div class="form-group password">
              <label class="control-label col-md-2">password</label>
              <input name="password" placeholder="password" class="form-control" type="text" value="123">
              <div class="invalid-feedback" in="password"></div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2">Role</label>
              <select class="form-control" name="role_id" id="datarole">
                <option value="">--- Role ---</option>
                <?php foreach ($role as $r) : ?>
                <option value="<?= $r['id']; ?>" datarole="<?= $r['role']; ?>" id="role"><?= $r['role']; ?></option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback" in="role_id"></div>
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