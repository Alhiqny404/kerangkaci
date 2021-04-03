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
                  <thead>
                    <tr>
                      <th scope="col">No</th>
                      <th scope="col">menu Group</th>
                      <th scope="col">Title</th>
                      <th scope="col">Icon</th>
                      <th scope="col">Url</th>
                      <th scope="col">Status</th>
                      <th scope="col">Opsi</th>
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



<?php $this->load->view('dist/_partials/footer'); ?>



<script>


  var save_method; //for save method string
  var table;
  $(document).ready(function() {


    $('#datamenu').on('change', function() {
      var menu = $("#datamenu option:selected").attr('datamenu').toLowerCase();
      var urlval = $('[name="url"]').val();
      if (save_method == 'add') {
        $('[name="url"]').val(menu+'/');
      } else {
        var url = urlval.split('/');

        console.log(url[0]);
        url[0] = menu;
        console.log(url.join('/'));
        $('[name="url"]').val(url.join('/'));

      }
    });

    table = $('#table').DataTable({

      "processing": true,
      //Feature control the processing indicator.
      "serverSide": true,
      //Feature control DataTables' server-side processing mode.

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('sistem/submenu/ajaxList') ?>",
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


  function status(id) {


    $.ajax({
      url: "<?= site_url('sistem/submenu/status'); ?>",
      type: "post",
      data: {
        id: id
      },
      success: function() {
        iziToast.success({
          title: 'UPDATE!',
          message: 'Status Telah diubah',
          position: 'topRight'
        });
        console.log('success');
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }

    });
  }


  function add() {
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambahkan submenu'); // Set Title to Bootstrap modal title
    console.log(save_method);
  }

  function edit(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    console.log(id);
    //Ajax Load data from ajax
    $.ajax({
      url: "<?= site_url('sistem/submenu/ajax_edit/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        $('[name="id"]').val(data.id);
        $('[name="menu_id"]').val(data.menu_id);
        $('[name="title"]').val(data.title);
        $('[name="icon"]').val(data.icon);
        $('[name="url"]').val(data.url);

        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit submenu'); // Set title to Bootstrap modal title

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
      url = "<?= site_url('sistem/submenu/ajax_add') ?>";
    } else
    {
      url = "<?= site_url('sistem/submenu/ajax_update') ?>";
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
          if (!data.err.menu_id == "") {
            $('[name="menu_id"]').addClass('is-invalid');
            $('[in="menu_id"]').html(data.err.menu_id);
          } else {
            $('[name="menu_id"]').removeClass('is-invalid');
            $('[in="menu_id"]').html();
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
          if (!data.err.url == "") {
            $('[name="url"]').addClass('is-invalid');
            $('[in="url"]').html(data.err.url);
          } else {
            $('[name="url"]').removeClass('is-invalid');
            $('[in="url"]').html();
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

  function delete_submenu(id) {


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
          url: "<?php echo site_url('sistem/submenu/ajax_delete/') ?>"+id,
          type: "POST",
          dataType: "JSON",
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
              <label class="control-label col-md-2">menu</label>
              <select class="form-control" name="menu_id" id="datamenu">
                <option value="">--- menu ---</option>
                <?php foreach ($menu as $m) : ?>
                <option value="<?= $m['id']; ?>" datamenu="<?= $m['menu']; ?>" id="menu"><?= $m['menu']; ?></option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback" in="menu_id"></div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2">title</label>
              <input name="title" placeholder="title" class="form-control" type="text">
              <div class="invalid-feedback" in="title"></div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2">icon</label>
              <input name="icon" placeholder="icon" class="form-control" type="text">
              <div class="invalid-feedback" in="icon"></div>
            </div>
            <div class="form-group">
              <label for="basic-url" class="control-label col-md-2">Url</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3"><?= site_url(); ?></span>
                </div>
                <input type="text" name="url" placeholder="url" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                <div class="invalid-feedback" in="url"></div>
              </div>
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