<div class="container">

  <div class="row item-content">
    <?php foreach ($products as $product): ?>

    <div class="col-md-2 col-6 mt-3 mb-3 item-content">
      <div class="item-produk ">
        <?php if ($product->stock_products > 0): ?>

        <a title="" href="<?=site_url("product/{$product->slug_products}") ?>"
          style="text-decoration: none;">
          <?php if ($product->discount_products != 0): ?>
          <span class="m-1 font-weight-bold rounded-left flag-discount shadow-sm"><?=$product->discount_products; ?>%
            Off</span>
          <?php endif; ?>

          <div class="brs-thumb-hold">
            <img src="<?=base_url('uploads/image/product/').$product->image_products; ?>" class=""
            style="width: 100%;">
          </div>
        </a>
        <div class="produk-title border-top" style="background: #FFFFFF">
          <div class="title-item text-left">
            <a href="<?=$product->id_products ?>"><?=$product->name_products ?></a>
          </div>
          <?php if ($product->discount_products > 0): ?>
          <small><del class="text-muted"><?= $product->price_products; ?></del></small>
          <span><?= $product->price_total_products; ?></span>
          <?php else : ?>
          <span><?= $product->price_total_products; ?></span>
          <?php endif ?>
          <br>
          <i class="fa fa-tag" style="margin-right: 3px; color:#0077FF;"></i><span
            style="color: #4CAF50;"><?=$product->name_categories; ?></span>
          <br>
        </div>

        <?php else : ?>
        <div class="middle">
          <div class="text">
            Stok Habis
          </div>
        </div>
        <div class="brs-thumb-hold">
          <img src="<?=base_url('uploads/image/product/').$product->image_products; ?>" class=""
          style="width: 100%; opacity: 0.5">
        </div>

        <div class="produk-title border-top" style="background: #FFFFFF">
          <div class="title-item text-left">
            <span class="o"></a>
          </div>
          <?php if ($product->discount_products > 0): ?>
          <small><del class="text-muted"><?= $product->price_products; ?></del></small>
          <span><?= $product->price_total_products; ?></span>
          <?php else : ?>
          <span><?= $product->price_total_products; ?></span>
          <?php endif ?>
          <br>
          <i class="fa fa-tag" style="margin-right: 3px; color:#0077FF;"></i><span
            style="color: #4CAF50;"><?=$product->name_categories; ?></span>
          <br>
        </div>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <div class="row">
    <div class="col">
    </div>
  </div>
</div>

<script>
  function login() {
    $.ajax({
      url: "<?= site_url('login/validate') ?>",
      type: "POST",
      data: $('#form').serialize(),
      dataType: "JSON",
      success: function(data) {
        console.log(data);
        if (data.status == false) {
          if (data.err.email == "") {
            $('[name="email"]').removeClass('is-invalid');
            $('[in="email"]').html();
          } else
          {
            $('[name="email"]').addClass('is-invalid');
            $('[in="email"]').html(data.err.email);
          }
          if (data.err.password == "") {
            $('[name="password"]').removeClass('is-invalid');
            $('[in="password"]').html();
          } else
          {
            $('[name="password"]').addClass('is-invalid');
            $('[in="password"]').html(data.err.password);
          }
        } else
        {
          window.location.href = "<?=base_url(data.url) ?>";
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');
      }
    });
  }

</script>