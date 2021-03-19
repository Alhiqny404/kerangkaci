<?php $this->load->view('layout/_datatables.php'); ?>


<div class="row">
  <div class="col-md-8">
    <!-- TABLE STRIPED -->
    <div class="panel">
      <div class="panel-body">
        <button type="button" class="add btn btn-primary btn-sm" onclick="add()">Tambah menu</button>
        <br><br>
        <table class="table table-striped table-hover table-sm" id="table">
          <thead>
            <tr>
              <th>No</th>
              <th>menu</th>
              <th>title</th>
              <th>icon</th>
              <th>url</th>
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

      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?= site_url('ajax/menu') ?>",
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
    $('.modal-title').text('Tambahkan menu'); // Set Title to Bootstrap modal title
    console.log(save_method);
  }

  function edit(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals

    //Ajax Load data from ajax
    $.ajax({
      url: "<?= site_url('ajax/menu/edit/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        $('[name="id"]').val(data.id);
        $('[name="menu"]').val(data.menu);

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
      url = "<?= site_url('ajax/menu/add') ?>";
    } else
    {
      url = "<?= site_url('ajax/menu/update') ?>";
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
        swal(
          'Good job!',
          'Data has been save!',
          'success'
        )
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
          url: "<?php echo site_url('ajax/menu/delete/') ?>"+id,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            //if success reload ajax table
            $('#modal_form').modal('hide');
            reload_table();
            swal(
              'Deleted!',
              'Your file has been deleted.',
              'success'
            );
          },
          error: function (jqXHR, textStatus, errorThrown) {
            alert('Error adding / update data');
          }
        });


      }
    })

  }

  function view_person(id) {
    $.ajax({
      url: "<?php echo site_url('welcome/list_by_id') ?>/" + id,
      type: "GET",
      success: function(result) {
        $('#haha').empty().html(result).fadeIn('slow');
      },
      error: function (jqXHR, textStatus, errorThrown) {}
    });
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
              <label class="control-label col-md-3">menu</label>
              <div class="col-md-9">
                <input name="menu" placeholder="menu" class="form-control" type="text">
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