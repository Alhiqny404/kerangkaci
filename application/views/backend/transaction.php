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
              <div class="text-right">
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-hover table-sm" id="table">
                  <thead>
                    <tr>
                      <th>NO PESANAN</th>
                      <th>COSTUMER</th>
                      <th>JUMLAH HARGA</th>
                      <th>STATUS</th>
                      <th>TGL PESANAN</th>
                      <th>OPSI</th>
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



<?php $this->load->view('_layouts/js'); ?>


<script>
  var save_method; //for save method string
  var table;
  $(document).ready(function() {
    $('.form-group #opsi').change(function() {
      let resi = `<div class="form-group group-resi">
      <label class="control-label">Nomor Resi</label>
      <input type="text" name="resi" id="resi" class="form-control" required/>
      </div>`;
      if ($(this).val() == 'kirim') {
        $('.group-opsi').after(resi);
      } else {
        $('.group-resi').hide();
      }
    });


    table = $('#table').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= site_url('crud-backend/transaction/ajaxList') ?>",
        "type": "POST"
      },
      "columnDefs": [{
        "targets": [-1],
        "orderable": false,
      },
      ],

    });
  });

  function reload_table() {
    table.ajax.reload(null, false);
  }


  function edit(id, status, noresi) {
    $('.group-resi').hide();
    if (status == 'pending') {
      let select = `<option value="">--- UBAH STATUS ---</option>
      <option value="terima">Terima Pesanan</option>
      <option value="tolak">Tolak Pesanan</option>`;
      $('[name="opsi"]').html(select);
    } else if (status == 'terima') {
      let select = `<option value="">--- UBAH STATUS ---</option>
      <option value="kirim">Kirim pesanan</option>
      <option value="batal">batalkan Pesanan</option>`;
      $('[name="opsi"]').html(select);
    } else if (status == 'kirim') {
      let select = `<option value="kirim">dalam pengiriman</option>
      <option value="selesai">Pesanan Selesai</option>`;
      $('[name="opsi"]').html(select);
      let resi = `<div class="form-group group-resi">
      <label class="control-label">Nomor Resi</label>
      <input type="text" name="resi" id="resi" class="form-control" required value="`+noresi+`"/>
      </div>`;
      $('.group-opsi').after(resi);
    }
    $('#form')[0].reset(); // reset form on modals
    $('input.inputan').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('[name="id"]').val(id);

    $('#modal_form').modal('show');
  };


  function save() {

    console.log($('#form').serialize());

    // ajax adding data to database
    $.ajax({
      url: "<?= site_url('crud-backend/transaction/ajax_update') ?>",
      type: "POST",
      data: $('#form').serialize(),
      dataType: "JSON",
      cache: false,
      success: function(data) {
        if (data.status == false) {

          if (!data.err.opsi == "") {
            $('[name="opsi"]').addClass('is-invalid');
            $('[in="opsi"]').html(data.err.opsi);
          } else {
            $('[name="opsi"]').removeClass('is-invalid');
            $('[in="opsi"]').html();
          }
        } else {
          $('#modal_form').modal('hide');
          reload_table();

          iziToast.success({
            title: 'UPDATE!',
            message: 'status telah diupdate',
            position: 'topRight'
          });

        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');
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
        <form id="form" action="#" class="form-horizontal">
          <input type="hidden" value="" name="id" />
          <div class="form-body">
            <div class="form-group group-opsi">
              <label class="control-label">Opsi</label>
              <select name="opsi" id="opsi" class="form-control">
              </select>
              <div class="invalid-feedback" in="opsi"></div>
            </div>
            <div class="form-group">
              <label class="control-label">Catatan</label>
              <textarea name="note" id="note" cols="30" rows="10" class="form-control"></textarea>
              <div class="invalid-feedback" in="note"></div>
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