<?php $this->load->view('layout/_datatables.php'); ?>


<div class="row">
  <div class="col-md-8">
    <!-- TABLE STRIPED -->
    <div class="panel">
      <div class="panel-body">
        <button type="button" class="add btn btn-primary btn-sm" onclick="add()">Tambah Role</button>
        <br><br>
        <table class="table table-striped table-hover table-sm" id="table">
          <thead>
            <tr>
              <th>No</th>
              <th>Role</th>
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
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambahkan Role'); // Set Title to Bootstrap modal title
    console.log(save_method);
  }

  function edit(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals

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
        let namaRole = $('[name="role"]').val();
        $('#modal_form').modal('hide');
        reload_table();
        if (save_method == 'add') {
          toastr.success('Role ' + namaRole + ' Berhasil Ditambahkan!');
        } else
        {
          toastr.success('Role Baru saja diedit');
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');

      }
    });
  }

  function delete_role(id) {

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
          url: "<?php echo site_url('sistem/role/ajax_delete/') ?>"+id,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            //if success reload ajax table
            $('#modal_form').modal('hide');
            reload_table();
            swal.close();
            toastr.success('Role Berhasil Dihapus')
          },
          error: function (jqXHR, textStatus, errorThrown) {
            alert('Error adding / update data');
          }
        });


      }
    })

  }

  function akses(id) {
    document.location.href = "<?=site_url('sistem/role/akses/') ?>"+id;
  }

</script>


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Role Form</h3>
      </div>
      <div class="modal-body form">
        <form id="form" action="#" class="form-horizontal">
          <input type="hidden" value="" name="id" />
          <div class="form-body">
            <div class="form-group">
              <label class="control-label">Role</label>
              <input name="role" placeholder="Role" id="role" class="form-control is-invalid" type="text">
              <div class="invalid-feedback"></div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- End Bootstrap modal -->