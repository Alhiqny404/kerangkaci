<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content bg padding-y-sm">
  <div class="container">
    <div class="row ">
      <div class="col-md-9 ">
        <div class="row pt-3 pb-3 rounded shadow-sm bg-white">
          <div class="col-md-4">
            <img src="<?=base_url('uploads/image/product/').$product->image_products; ?>" style="max-height: 350px"
            class="img-fluid img-thumbnail" alt="gambar product<?= $product->name_products; ?>">
          </div>
          <div class="col-md-8">
            <h3 class="border-bottom pb-2 pt-2 mb-4 font-weight-bold">
              <?= $product->name_products; ?>
            </h3>
            <div>
              <?php if ($product->discount_products > 0): ?>
              <div>
                <del class="text-muted"><?= $product->price_products; ?></del>
              </div>
              <span class="font-weight-bold text-danger text-lg"><?= $product->price_total_products; ?></span>
              <div class="p-2 mt-2 mb-4 bg-primary text-white font-weight-bold">
                <i>Diskon
                  <?= $product->discount_products ?>%</i>
              </div>
              <?php else : ?>
              <div class="font-weight-bold mb-4 text-danger text-lg">
                <?= $product->price_total_products; ?>
              </div>
              <?php endif ?>
            </div>
            <div class="text-secondary">
              <h6>Berat: <span class="font-weight-bold"><?= $product->weight_products ?></span> gram</h6>
            </div>
            <div class="text-secondary">
              <h6>Stok tersisa: <span class="font-weight-bold"><?= $product->stock_products ?></span> pcs!</h6>
            </div>
            <div class="product">
              <form id="form">
                <div class="form-row mb-4">
                  <div class="col-md-4 form-group">
                    <label for="qty">Masukkan Jumlah yang akan dibeli</label>
                    <input type="number" id="qty" name="qty" class="form-control" max="<?= $product->stock_products ?>">
                    <div class="invalid-feedback" in="qty"></div>
                  </div>
                </div>
                <?= form_hidden('id_product', $product->id_products); ?>
                <?= form_hidden('price', $product->price_total_products); ?>
                <?= form_hidden('weight', $product->weight_products); ?>
                <?= form_hidden('stock', $product->stock_products); ?>
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Catatan</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" name="note"
                    placeholder="Catatan detail pembelian" rows="3" maxlength="100"></textarea>
                </div>
                <button type="button" id="btnsubmit" onclick="add_cart()"
                  class="btn btn-success btn-lg btn-block mb-2 add-cart"><i class="fa fa-cart-plus"
                    aria-hidden="true"></i>
                  Tambah ke
                  keranjang</button>
              </form>
              <a href="" class="btn btn-light font-weight-bold shadow-sm"><i
                class=" fab text-success fa-whatsapp"></i> Chat Admin</a>
            </div>
            <div class="mr-4 mt-2 float-right">
              <i class="fas fa-shield-alt text-danger "></i> Jaminan 100%
              Aman
            </div>
          </div>
        </div>
        <div class="row ">
          <div class="shadow-sm mt-4 bg-white col-12 p-4">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                  aria-controls="home" aria-selected="true">Deskripsi</a>
              </li>                                        </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <?= $product->description_products ?>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              ...
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
              ...
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 mt-4">
      <div class="shadow-sm p-3 mt-4 bg-white" id="cart_tmpss">
      </div>

      <div class="shadow-sm p-3 mt-4 bg-white">
        <span class="bg-primary text-white p-3 mb-2 text-center	font-weight-bold"
          style="display:block;">Pembayaran</span>
        <div class="bank border-bottom">
          <table align="center">
            <tr align="center">
              <th align="center">
                <img src="<?= base_url('assets/img/mandiri.png') ?>"
                style="max-height: 350px" class="img-fluid " alt=""></th>
            </tr>
            <tr>
              <td align="center"><span style="">108-000-6985-429/Anu</span></td>
            </tr>
            <tr>
              <th align="center">
                <img src="<?= base_url('assets/img/bca.png') ?>"
                style="max-height: 350px" class="img-fluid mt-3" alt=""></th>
            </tr>
            <tr>
              <td align="center"><span>108-000-6985-429/Anu</span></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="container mt-4 p-3 shadow-sm bg-white">
        <h4 class="text-center">Bagikan Produk Ini</h4>
        <div class="social text-center">
          <a href="#" id="share-fb" class="sharer button"><i class="fab fa-2x fa-facebook-square"></i></a>
          <a href="#" id="share-tw" class="sharer button"><i class="fab fa-2x fa-twitter-square"></i></a>
          <a href="#" id="share-li" class="sharer button"><i class="fab fa-2x fa-linkedin-square"></i></a>
          <a href="#" id="share-gp" class="sharer button"><i
            class="fab fa-2x fa-google-plus-square"></i></a>
          <a href="#" id="share-em" class="sharer button"><i class="fa fa-2x fa-envelope-square"></i></a>

        </div>

      </div>
    </div>
  </div>
</div>
</section>
<!-- ========================= SECTION CONTENT .END// ========================= -->
<script>

function add_cart() {
let form = $('#form').serialize();
let session = "<?= $this->session->userdata('email'); ?>";
if (session == "") {
iziToast.error({
title: 'GAGAL!',
message: 'Anda belum Login',
position: 'topRight'
});
} else {
$.ajax({
url: "<?=site_url('home/add_cart') ?>",
type: "post",
dataType: "json",
data: form,
cache: false,
success: function(data) {
console.log(data);
if (data.status == false) {
if (!data.err.qty == "") {
$('[name="qty"]').addClass('is-invalid');
$('[in="qty"]').html(data.err.qty);
} else {
$('[name="qty"]').removeClass('is-invalid');
$('[in="qty"]').html();
}
} else {
$('[name="qty"]').removeClass('is-invalid');
$('[name="qty"]').val('');
$('[in="qty"]').html();
$.ajax({
url: "<?=site_url('home/count_cart') ?>",
type: 'get',
success: function(data) {
$('.count_cart').html(data);
}
})

iziToast.success({
title: 'SUKSES!',
message: 'produk masuk keranjang',
position: 'topRight'
});
}
}
});
}



}
</script>