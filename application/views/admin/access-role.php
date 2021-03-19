
<script src="<?= base_url()?>/assets/js/jquery.min.js"></script>

 <!-- Page Heading -->
<h3 class="page-title"><?=$title;?></h3>
        
      
<div class="row">
  <div class="col-md-4">
  <!-- TABLE STRIPED -->
    <div class="panel">
      <div class="panel-heading" style="display: flex;justify-content: space-between;">
        <h3 class="panel-title">Akses Roles</h3>
        <a href="<?= base_url('admin/role');?>" class="add mb-4 btn btn-primary mt-3" onclick="tambah()" style="background-color: #00aaff;padding:5px 10px">Kembali</a>
      </div>
      <div class="panel-body">
        <table class="table table-striped table-hover">
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
                <td><?= $i++;?></td>
                <td><?= $m['menu'];?></td>
                <td>
                  <div class="form-group">
                    <input  id="checkbox" class="form-check-input" type="checkbox" <?= access($role['id'],$m['id']);?> data-menu="<?= $m['id'];?>" data-role="<?= $role['id']?>">
                  </div>
                </td>
              </tr>
            <?php endforeach;?>
            
          </tbody>
        </table>
      </div>
    </div>
    <!-- END TABLE STRIPED -->
  </div>
</div>


        <script src="<?=base_url()?>assets/js/sweetalert.min.js"></script>
        
        <script>
          
          $('.form-check-input').on('click',function(){
            const menuId = $(this).data('menu');
            const roleId = $(this).data('role');
            
            $.ajax({
              url : "<?= base_url('admin/changeAccess');?>",
              type : "post",
              data : {
                menuId:menuId,
                roleId:roleId
              },
              success:function(){
                document.location.href = "<?= base_url('admin/access_role/');?>"+roleId;
                console.log('success');
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }

            });
            
            // $.ajax({
              
            //   url: "<?= base_url('admin/changeAccess')?>",
            //   type: 'post',
            //   data: {
            //     menuId:menuId,
            //     roleId:roleId
            //   },
            //   success:function()
            //   {
            //     document.location.href = "<?= base_url('admin/access_role/');?>"+roleId;
            //     alert('success');
            //   }
            //   error: function (jqXHR, textStatus, errorThrown)
            //   {
            //       alert('Error get data from ajax');
            //   }
              
            // });
            
          });
          
        </script>
        
  
    