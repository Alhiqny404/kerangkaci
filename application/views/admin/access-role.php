<?php $this->load->view('layout/_datatables.php'); ?>


<div class="row">
  <div class="col-md-4">
    <!-- TABLE STRIPED -->
    <div class="panel">
      <div class="panel-body">
        <div class="text-right">

          <a href="<?= site_url('sistem/role'); ?>" class="add mb-4 btn btn-primary mt-3" onclick="tambah()" style="background-color: #00aaff;padding:5px 10px">Kembali</a>
        </div>
        <table class="table table-striped table-hover" id="tablerole">
          <thead>
            <tr>
              <th>No</th>
              <th>Role</th>
              <th>opsi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; foreach ($menu as $m) : ?>
            <tr>
              <td><?= $i++; ?></td>
              <td><?= $m['menu']; ?></td>
              <td>
                <div class="form-group">
                  <input id="checkbox" class="form-check-input" type="checkbox" <?= access($role['id'], $m['id']); ?> data-menu="<?= $m['id']; ?>" data-role="<?= $role['id'] ?>">
                </div>
              </td>
            </tr>
            <?php endforeach; ?>

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
    $('#tablerole').DataTable();
  });

  $('.form-check-input').on('click', function() {
    const menuId = $(this).data('menu');
    const roleId = $(this).data('role');

    $.ajax({
      url: "<?= site_url('sistem/role/changeAccess'); ?>",
      type: "post",
      data: {
        menuId: menuId,
        roleId: roleId
      },
      success: function() {
        document.location.href = "<?= base_url('sistem/role/akses/'); ?>"+roleId;
        console.log('success');
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }

    });


  });

</script>