<?php $this->load->view('layout/_datatables.php'); ?>


<div class="row">
  <div class="col-md-10">
    <!-- TABLE STRIPED -->
    <div class="panel">
      <div class="panel-body">
        <div class="text-right">
          <a href="<?=site_url('sistem/menu');?>" class="add btn btn-primary btn-sm">Kembali</a>
        </div>
        <br><br>
        <table class="table table-striped table-hover table-sm" id="table">
          <thead>
            <tr>
              <th>Urutan</th>
              <th>Menu</th>
              <th>opsi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($menu as $m) : ?>
              <tr>
                <td><?=$m['urutan']?></td>
                <td><?=$m['menu']?></td>
                <td>
                  <button class="btn btn-sm btn-success" onclick="naikan(<?=$m['id']?>,<?=$m['urutan']?>)">Naikan</button>
                  <button class="btn btn-sm btn-danger" onclick="turunkan(<?=$m['id']?>,<?=$m['urutan']?>)">Turunkan</button>
                </td>
              </tr>
            <?php endforeach ?>
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

    table = $('#table').DataTable();
  });

  function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
  }

  function naikan(id,urutan)
  {
    alert("menu dengan ID : " + id + "mempunyai urutan ke " + urutan);
  }

  function turunkan(id,urutan)
  {
    
  }



</script>

