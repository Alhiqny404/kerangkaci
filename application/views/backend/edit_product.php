<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>

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
              <h4>Menambahkan Produk</h4>
            </div>
            <div class="card-body">
              <form id="form">
                <input type="hidden" name="id_products" id="id_products">
                <input type="hidden" name="slug_products" id="slug_products">
                <input type="hidden" name="dsc" id="dsc">
                <div class="form-row">
                  <div class="form-group  col-md-8">
                    <label class="col-form-label" for="product">Nama Produk</label>
                    <input type="text" class="form-control" id="name_products" name="name_products"
                    placeholder="Nama Produk" value="" onkeyup="createTextSlug()" />
                    <div class="invalid-feedback" in="name_products"></div>
                  </div>
                  <div class="form-group col-md-4">
                    <label class="col-form-label" for="code_products">Products Code</label>
                    <input type="text" class="form-control" id="code_products" name="code_products"
                    placeholder="products code" value="<?= set_value('code_products') ?>" />
                    <div class="invalid-feedback" in="code_products"></div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-7">
                    <label class="col-form-label" for="id_categories">Category</label>
                    <select class="form-control" name="id_categories">
                      <option value="0" class="pilih-kategori">--- PILIH KATEGORI ---</option>
                    </select>
                    <div class="invalid-feedback" in="id_categories"></div>
                  </div>
                  <div class="form-group col">
                    <label class="col-form-label" for="stock">Stock</label>
                    <input type="number" class="form-control" id="stock_products" name="stock_products"
                    placeholder="0" value="<?= set_value('stock_products') ?>" />
                    <div class="invalid-feedback" in="stock_products"></div>
                  </div>
                  <div class="form-group col">
                    <label class="col-form-label" for="weight">Weight</label>
                    <input type="number" class="form-control" id="weight_products" name="weight_products"
                    placeholder="gram" value="<?= set_value('weight_products') ?>" />
                    <div class="invalid-feedback" in="weight_products"></div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-5">
                    <label class="col-form-label" for="price_products">Price Rp.</label>
                    <input type="number" class="form-control" id="price_products" name="price_products"
                    placeholder="Before Discount" value="<?= set_value('price_products') ?>" onkeyup="discount()" />
                    <div class="invalid-feedback" in="price_products"></div>
                  </div>
                  <div class="form-group col-md-2">
                    <label class="col-form-label" for="discount_products">Discount %</label>
                    <input type="number" data-toggle="tooltip"
                    title="Enter '0' if you don't have a discount" class="form-control"
                    id="discount_products" name="discount_products" placeholder="%" onkeyup="discount()" />
                    <div class="invalid-feedback" in="discount_products"></div>
                  </div>
                  <div class="form-group col-md-5">
                    <label class="col-form-label" for="price_total_products">Price Total Rp.</label>
                    <input type="number" class="form-control" readonly="" id="price_total_products"
                    name="price_total_products" placeholder="After discount"
                    value="<?= set_value('price_total_products') ?>" />
                    <div class="invalid-feedback" in="price_total_products"></div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col">
                    <label class="col-form-label">Deskripsi Produk</label>
                    <textarea class="form-control" id="description_products" name="description_products"></textarea>
                    <div class="invalid-feedback" in="description_products"></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Foto Produk</label>
                  <div class="col-sm-10">
                    <label for="image_products" style="position:absolute;">
                      <i class="fa fa-edit btn-sm btn-primary input-hero-image"><input type="file" class="d-none" id="image_products" name="image_products"></i></label>
                    <img width="40%" id="blah" class="img-thumbnail" src="<?=base_url('uploads/image/product/'.$image_products); ?>" alt="hero image">
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label" class="col-form-label text-left"></label>
                  <div class="col-12">
                    <button class="btn btn-primary" type="button"id="btnsave" name="submit" onclick="update()">Simpan Perubahan</button>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>
<?php $this->load->view('_layouts/js'); ?>

<script>

  $(document).ready(function() {

    edit("<?=$id_product ?>");

    $.ajax({
      url: "<?=site_url('crud-backend/product/category_ajax') ?>",
      type: 'post',
      dataType: 'json',
      cache: false,
      success: function(data) {
        let kategori;
        let id_categories = "<?=$id_categories ?>";
        console.log(id_categories);
        $.each(data, function(k, v) {
          kategori += '<option value="'+v.id_categories+'">'+v.name_categories+'</option>';
        });
        $('.pilih-kategori').after(kategori);
        $('[name="id_categories"]').val(id_categories);
      }
    });
    CKEDITOR.replace('description_products').on('key', function() {
      let description_products = CKEDITOR.instances['description_products'].getData();
      $('[name="dsc"]').val(description_products);
    });
  });


  function createTextSlug() {
    var name_products = $('[name="name_products"]').val();
    $('[name="slug_products"]').val(generateSlug(name_products));
  }
  function generateSlug(text) {
    return text.toString().toLowerCase()
    .replace(/^-+/,
      '')
    .replace(/-+$/,
      '')
    .replace(/\s+/g,
      '-')
    .replace(/\-\-+/g,
      '-')
    .replace(/[^\w\-]+/g,
      '');
  }


  function discount() {
    let price = $('[name="price_products"]').val();
    let discount = $('[name="discount_products"]').val();
    let process = price / 100 * discount;
    let total = price - process;
    $('[name="price_total_products"]').val(total);
  }


  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#blah').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#image_products").change(function() {
    readURL(this);
  });


  function edit(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').empty();

    //Ajax Load data from ajax
    $.ajax({
      url: "<?= site_url('crud-backend/product/ajax_edit/') ?>" + id,
      type: "POST",
      dataType: "JSON",
      cache: false,
      success: function(data) {
        $('[name="id_products"]').val(data.id_products);
        $('[name="name_products"]').val(data.name_products);
        $('[name="code_products"]').val(data.code_products);
        $('[name="id_categories"]').val(data.id_categories);
        $('[name="stock_products"]').val(data.stock_products);
        $('[name="weight_products"]').val(data.weight_products);
        $('[name="price_products"]').val(data.price_products);
        $('[name="discount_products"]').val(data.discount_products);
        $('[name="price_total_products"]').val(data.price_total_products);
        CKEDITOR.instances['description_products'].setData(data.description_products);
        $('[name="dsc"]').val(data.description_products);
        //  $('#blah').attr('src', "<?=base_url('uploads/image/product/'); ?>"+data.image_products);


      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }


  function update() {
    $("#btnsave").prop("disabled", true);
    $('#btnsave').html('proses...');
    let form = $('#form')[0];
    let dataForm = new FormData(form);

    let name_products = $('[name="name_products"]').val();
    let code_products = $('[name="code_products"]').val();
    let id_categories = $('[name="id_categories"]').val();
    let stock_products = $('[name="stock_products"]').val();
    let weight_products = $('[name="weight_products"]').val();
    let price_products = $('[name="price_products"]').val();
    let discount_products = $('[name="discount_products"]').val();
    let price_total_products = $('[name="price_total_products"]').val();
    let description_products = CKEDITOR.instances['description_products'].getData();

    $.ajax({
      enctype: 'multipart/form-data',
      url: "<?= site_url('crud-backend/product/update'); ?>",
      type: "post",
      data: dataForm,
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      success: function(data) {
        console.log(data);
        $('#btnsave').html('Tambahkan');
        $("#btnsave").prop("disabled", false);
        if (data.status == false) {
          console.log(data.err.image_products);
          if (!data.err.image_products == "") {
            iziToast.error({
              title: 'Upload belum Selesai!!',
              message: data.err.image_products,
              position: 'topRight'
            });
          }


          if (!data.err.name_products == "") {
            $('[name="name_products"]').addClass('is-invalid');
            $('[in="name_products"]').html(data.err.name_products);
          } else {
            $('[name="name_products"]').removeClass('is-invalid');
            $('[in="name_products"]').html();
          }
          if (!data.err.code_products == "") {
            $('[name="code_products"]').addClass('is-invalid');
            $('[in="code_products"]').html(data.err.code_products);
          } else {
            $('[name="code_products"]').removeClass('is-invalid');
            $('[in="code_products"]').html();
          }
          if (!data.err.id_categories == "") {
            $('[name="id_categories"]').addClass('is-invalid');
            $('[in="id_categories"]').html(data.err.id_categories);
          } else {
            $('[name="id_categories"]').removeClass('is-invalid');
            $('[in="id_categories"]').html();
          }
          if (!data.err.stock_products == "") {
            $('[name="stock_products"]').addClass('is-invalid');
            $('[in="stock_products"]').html(data.err.stock_products);
          } else {
            $('[name="stock_products"]').removeClass('is-invalid');
            $('[in="stock_products"]').html();
          }
          if (!data.err.weight_products == "") {
            $('[name="weight_products"]').addClass('is-invalid');
            $('[in="weight_products"]').html(data.err.weight_products);
          } else {
            $('[name="weight_products"]').removeClass('is-invalid');
            $('[in="weight_products"]').html();
          }
          if (!data.err.price_products == "") {
            $('[name="price_products"]').addClass('is-invalid');
            $('[in="price_products"]').html(data.err.price_products);
          } else {
            $('[name="price_products"]').removeClass('is-invalid');
            $('[in="price_products"]').html();
          }
          if (!data.err.price_total_products == "") {
            $('[name="price_total_products"]').addClass('is-invalid');
            $('[in="price_total_products"]').html(data.err.price_total_products);
          } else {
            $('[name="price_total_products"]').removeClass('is-invalid');
            $('[in="price_total_products"]').html();
          }
          if (!data.err.dsc == "") {
            $('[name="description_products"]').addClass('is-invalid');
            $('[in="description_products"]').html(data.err.dsc);
          } else {
            $('[name="description_products"]').removeClass('is-invalid');
            $('[in="description_products"]').html();
          }
        } else
        {
          $('.form-control').removeClass('is-invalid');
          $('.invalid-feedback').empty();
          iziToast.success({
            title: 'BERHASIL!',
            message: 'produk berhasil diupdate!',
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