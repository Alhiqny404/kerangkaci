<?php $this->load->view('layout/_datatables.php'); ?>


<div class="row">
  <div class="col-md-10">
    <!-- TABLE STRIPED -->
    <div class="panel">
      <div class="panel-body">
        <button type="button" class="add btn btn-primary btn-sm" onclick="add()">Tambah Menu</button>
        <a href="<?=site_url('sistem/menu/urutan');?>" class="add btn btn-warning btn-sm">Urutkan Menu</a>
        <br><br>
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
    <!-- END TABLE STRIPED -->
  </div>
</div>


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
        "url": "<?= site_url('sistem/menu/ajaxList') ?>",
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
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambahkan menu'); // Set Title to Bootstrap modal title
    console.log(save_method);
  }

  function edit(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals

    //Ajax Load data from ajax
    $.ajax({
      url: "<?= site_url('sistem/menu/ajax_edit/') ?>" + id,
      type: "GET",
      dataType: "JSON",
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
      url = "<?= site_url('sistem/menu/ajax_add') ?>";
    } else
    {
      url = "<?= site_url('sistem/menu/ajax_update') ?>";
    }

    // ajax adding data to database
    $.ajax({
      url: url,
      type: "POST",
      data: $('#form').serialize(),
      dataType: "JSON",
      success: function(data) {
        //if success close modal and reload ajax table
        $('#modal_form').modal('hide');
        reload_table();
        if (save_method == 'add') {
          toastr.success('Menu Baru Berhasil Ditambahkan!');
        } else
        {
          toastr.success('Menu Baru saja diedit');
        }

      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');

      }
    });
  }

  function delete_menu(id) {

    swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      closeOnConfirm: false
    }).then(function(isConfirm) {
      if (isConfirm) {

        // ajax delete data to database
        $.ajax({
          url: "<?php echo site_url('sistem/menu/ajax_delete/') ?>"+id,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            //if success reload ajax table
            $('#modal_form').modal('hide');
            reload_table();
            swal.close();
            toastr.success('Menu Baru saja dihapus');
          },
          error: function (jqXHR, textStatus, errorThrown) {
            alert('Error adding / update data');
          }
        });


      }
    })

  }


</script>


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" menu="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">menu Form</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id" />
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-2">menu</label>
              <div class="col-md-9">
                <input name="menu" placeholder="menu" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group none">
              <label class="control-label col-md-2">title</label>
              <div class="col-md-9">
                <input name="title" placeholder="title" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group none">
              <label class="control-label col-md-2">icon</label>
              <div class="col-md-9">
                <input name="icon" placeholder="icon" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label for="tipemenu" class="control-label col-md-2">Tipe</label>
              <div class="col-md-9">
                <select name="tipe" class="form-control tipemenu" id="tipemenu">
                  <option value="0">--- PILIH TIPE ---</option>
                  <option value="1">Biasa</option>
                  <option value="2">Dropdown</option>
                </select>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- End Bootstrap modal -->