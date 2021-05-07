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
                      <th>Nama Kategori</th>
                      <th>Slug</th>
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
      //Feature control the processing indicator.
      "serverSide": true,
      //Feature control DataTables' server-side processing mode.

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?= site_url('crud-backend/category/ajaxList') ?>",
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
    $('.modal-title').text('Tambahkan Kategori'); // Set Title to Bootstrap modal title
    console.log(save_method);
  }

  function edit(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').empty();

    //Ajax Load data from ajax
    $.ajax({
      url: "<?= site_url('crud-backend/category/ajax_edit/') ?>" + id,
      type: "POST",
      dataType: "JSON",
      cache: false,
      success: function(data) {

        $('[name="id_categories"]').val(data.id_categories);
        $('[name="name_categories"]').val(data.name_categories);
        $('[name="slug_categories"]').val(data.slug_categories);

        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit Kategori'); // Set title to Bootstrap modal title

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
      url = "<?= site_url('crud-backend/category/ajax_add') ?>";
    } else
    {
      url = "<?= site_url('crud-backend/category/ajax_update') ?>";
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
          if (!data.err.name_categories == "") {
            $('[name="name_categories"]').addClass('is-invalid');
            $('[in="name_categories"]').html(data.err.name_categories);
          } else {
            $('[name="name_categories"]').removeClass('is-invalid');
            $('[in="name_categories"]').html();
          }
          if (!data.err.slug_categories == "") {
            $('[name="slug_categories"]').addClass('is-invalid');
            $('[in="slug_categories"]').html(data.err.slug_categories);
          } else {
            $('[name="slug_categories"]').removeClass('is-invalid');
            $('[in="slug_categories"]').html();
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

  function delete_category(id) {


    swal({
      title: 'Kamu Yakin?',
      text: 'Kategori Akan Dihapus',
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {

        // ajax delete data to database
        $.ajax({
          url: "<?php echo site_url('crud-backend/category/ajax_delete/') ?>"+id,
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
          <input type="hidden" value="" name="id_categories" />
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-2">Nama</label>
              <input name="name_categories" placeholder="" class="form-control" type="text" onkeyup="createTextSlug()">
              <div class="invalid-feedback" in="name_categories"></div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2">Slug</label>
              <input name="slug_categories" placeholder="" class="form-control" type="text">
              <div class="invalid-feedback" in="slug_categories"></div>
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