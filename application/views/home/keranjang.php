<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content bg padding-y ">
  <div class="container">
    <?= form_open('checkout'); ?>
    <div class="row">
      <main class="col-sm-9">
        <div class="card">
          <table class="table table-hover shopping-cart-wrap">
            <thead class="text-muted">
              <tr>
                <th scope="col">Product</th>
                <th scope="col">Catatan</th>
                <th scope="col" width="120">Jumlah</th>
                <th scope="col" width="120">Harga</th>
                <th scope="col" class="text-right" width="200">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!$items_cart) :
              echo "<tr  ><td align='center' colspan='5'>
                           <small class='small text-muted'>Kosong</small>
                           </td></tr>"; $k = TRUE;
              else :
              ?>
              <?php  foreach ($items_cart as $item) : ?>
              <?php echo form_hidden('id_cart[]', $item->id_cart); ?>
              <?php echo form_hidden('tweight', $item->total_weight); ?>
              <?php echo form_hidden('status_tmp[]', 1); ?>
              <tr>
                <td>
                  <figure class="media">
                    <div class="img-wrap">
                      <img
                      src="<?=base_url('uploads/image/product/').$item->image_products; ?>"
                      class="img-thumbnail img-sm">
                    </div>
                    <figcaption class="media-body">
                      <h6 class="title text-truncate"><?= $item->name_products; ?> </h6>
                    </figcaption>
                  </figure>
                </td>
                <td>
                  <?= $item->note; ?>
                </td>
                <td>
                  <div class="form-group">
                    <?= $item->qty; ?>
                    <?php echo form_hidden('name', $item->qty); ?>
                    <?php echo form_hidden('idp', $item->id_product); ?>
                  </div>
                </td>
                <td>
                  <div class="price-wrap">
                    <var class="price"><?= $item->total_price ?></var>
                  </div>
                  <!-- price-wrap .// -->
                </td>
                <?php if ($item->status == 0): ?>
                <td class="text-right">
                  <a href="javascript:void(0)" class="btn btn-outline-warning" onclick="edit('<?=$item->id_cart ?>')">Edit</a>
                  <a href="<?= base_url('cart/remove_cart/').$item->id_cart ?>"
                    class="btn btn-outline-danger"> × Remove</a>
                </td>
                <?php else : ?>
                <td class="text-right">
                  <a href="<?=site_url('product/'.$item->slug_products); ?>" class="btn btn-success">Beli Lagi</a>
                  <a href="<?= base_url('cart/remove_cart/').$item->id_cart ?>"
                    class="btn btn-outline-danger"> × Remove</a>
                </td>
                <?php endif; ?>


              </tr>
              <?php
              endforeach;
              endif; ?>

            </tbody>
          </table>
        </div>
        <!-- card.// -->
      </main>
      <!-- col.// -->
      <aside class="col-sm-3 pt-4">
        <!-- Test -->
        <?= $total_weight; ?>
        <?php if ($count_cart <= 0): ?>
        <dl class="dlist-align h4">
          <dt>Total:</dt>
          <dd class="text-right"><strong>0</strong></dd>
        </dl>
        <button class="btn btn-primary btn-lg btn-block font-weight-bold mt-3" disabled>Beli</button>
        <?php else : ?>
        <dl class="dlist-align h4">
          <dt>Total:</dt>
          <dd class="text-right"><strong> <?= $total_price; ?></strong>
          </dd>

          <input type="hidden" id="anua" value="<?= $total_price ?>">
        </dl>
        <button class="btn btn-primary btn-lg btn-block font-weight-bold mt-3">Beli</button>

        <?php endif ?>

        <!-- Test end -->
        <hr>
        <figure class="itemside mb-3">
          <div class="text-wrap small text-muted">
            Harga diatas belum termasuk ongkos kirim.
          </div>
        </figure>
      </aside>
      <!-- col.// -->
    </div>
    <?=
    form_close();
    ?>
    <a href="<?= base_url() ?>"><button class="btn btn-success font-weight-bold float-right">Lanjutkan
      Belanja</button></a>
  </div>
  <!-- container .//  -->
</section>

<!-- Modal -->

<?php if ($count_cart < 0): ?>
<?php
foreach ($items_cart as $item):
?>
<div class="modal fade" id="modelEdit<?=$item->id_cart ?>" tabindex="-1" role="dialog" aria-labelledby="modelEditLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modelEditLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url() ?>keranjang/updatecart/<?=$item->id_cart ?>" method="post">
        <?php echo form_hidden('id_product', $item['id_product']); ?>
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleFormControlTextarea1">Catatan</label>
            <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="3"
              maxlength="25"><?=$item->note ?></textarea>
          </div>
          <div class="form-group">
            <label for="exampleFormControlTextarea1">Jumlah Beli</label>
            <input class="form-control" name="qty" type="number" value="<?=$item->qty ?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save
            changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php endforeach; endif ?>

<script>
  function edit(id) {

    //Ajax Load data from ajax
    $.ajax({
      url: "<?= site_url('cart/ajax_edit/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      cache: false,
      success: function(data) {
        $('[name="id"]').val(data.id_cart);
        $('[name="id_product"]').val(data.id_product);
        $('[name="qty"]').val(data.qty);
        $('[name="qty_old"]').val(data.qty);
        $('[name="note"]').val(data.note);
        $('#modal_edit').modal('show');
        $('.modal-title').html('Edit Produk dalam keranjang');

      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }


  function save() {
    $.ajax({
      url: "<?=site_url('cart/ajax_update') ?>",
      type: "POST",
      data: $('#form').serialize(),
      dataType: "JSON",
      cache: false,
      success: function(data) {
        if (data.status == false) {
          $('[name="qty"]').addClass('is-invalid');
          $('[in="qty"]').html(data.err.qty);
        } else {
          $('#modal_edit').modal('hide');
          iziToast.success({
            title: 'SUKSES!',
            message: 'telah diupdate',
            position: 'topRight'
          });
          setTimeout(function() {
            // wait for 5 secs(2)
            location.reload(); // then reload the page.(3)

          }, 2000);

        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');
      }
    });
  }
</script>


<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modelEditLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form">
        <div class="modal-body">
          <input type="hidden" name="id" value="">
          <input type="hidden" name="id_product" value="">
          <input type="hidden" name="qty_old" value="">
          <div class="form-group">
            <label for="note">Catatan</label>
            <textarea class="form-control" name="note" id="note" rows="3"
              maxlength="25"></textarea>
          </div>
          <div class="form-group">
            <label for="qty">Jumlah Beli</label>
            <input class="form-control" name="qty" type="number" id="qty" value="">
            <div class="invalid-feedback" in="qty"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btnsubmit" onclick="save()">Save
            changes</button>
        </div>
      </form>
    </div>
  </div>
</div>