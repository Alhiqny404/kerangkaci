<?php $this->load->view('layout/_datatables.php'); ?>


<div class="row">
  <div class="col-md-10">
    <!-- TABLE STRIPED -->
    <div class="panel">
      <div class="panel-body">
        <button type="button" class="add mb-4 btn btn-primary mt-3" style="background-color: #00aaff;padding:5px 10px" onclick="add()">Tambah submenu</button> <br><br>
        <div class="table-responsive">
          <table class="table table-striped table-hover table-sm" id="table">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">submenu Group</th>
                <th scope="col">Title</th>
                <th scope="col">Icon</th>
                <th scope="col">Url</th>
                <th scope="col">Opsi</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
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
        "url": "<?php echo site_url('ajax/submenu') ?>",
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
    $('.modal-title').text('Tambahkan submenu'); // Set Title to Bootstrap modal title
    console.log(save_method);
  }

  function edit(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    console.log(id);
    //Ajax Load data from ajax
    $.ajax({
      url: "<?= site_url('ajax/submenu/edit/') ?>" + id,
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
      url = "<?= site_url('ajax/submenu/add') ?>";
    } else
    {
      url = "<?= site_url('ajax/submenu/update') ?>";
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

  function delete_submenu(id) {

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
          url: "<?php echo site_url('ajax/submenu/delete/') ?>"+id,
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
                <select class="form-control" name="menu_id">
                  <option>--- menu ---</option>
                  <?php foreach ($menu as $m) : ?>
                  <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">title</label>
              <div class="col-md-9">
                <input name="title" placeholder="title" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">icon</label>
              <div class="col-md-9">
                <input name="icon" placeholder="icon" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">url</label>
              <div class="col-md-9">
                <input name="url" placeholder="url" class="form-control" type="text">
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



<!-- Bootstrap modal -->
<div class="modal fade" id="modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Data Pelanggan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('submenu/subsubmenuAdd'); ?>" id="form" class="form-horizontal" method="POST">
          <input type="hidden" value="" name="id" />
          <div class="form-body">
            <div class="form-group">
              <select class="form-control" name="submenu_id">
                <option>--- submenu ---</option>
                <?php foreach ($submenu as $m) : ?>
                <option value="<?= $m['id']; ?>"><?= $m['submenu']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label>Title</label>
              <input type="text" name="title" class="form-control">
            </div>
            <div class="form-group">
              <label>Icon</label>
              <input type="text" name="icon" class="form-control">
            </div>
            <div class="form-group">
              <label>Url</label>
              <input type="text" name="url" class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnSave" class="btn btn-primary">Save</button>
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