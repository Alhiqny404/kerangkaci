<div class="container bg-white shadow-sm">
  <div class="container p-4">
    <div class="row">
      <div class="col">
        <div class="form-group">
          <?php echo form_open_multipart(''); ?>
          <?= form_hidden('id_transaction', $id_transaction); ?>
          <div class="form-group">
            <label for="accname">A/N</label>
            <input type="text" name="acc_name" class="form-control" required id="accname" placeholder="Nama">
          </div>
          <div class="form-group">
            <label for="daribank">Dari Bank</label>
            <select class="form-control" id="daribank" required name="code_bank">
              <option value="">--- PILIH BANK ---</option>
              <?php foreach ($banks as $bank) : ?>
              <option value="<?=$bank->code ?>"><?=$bank->name ?></option>
              <?php endforeach; ?>

            </select>
          </div>
          <div class="form-group">
            <label for="norek">No.Rek</label>
            <input type="text" name="norek" class="form-control" required id="norek" placeholder="Nama">
          </div>
          <div class="form-group">
            <label for="banktujuan">Bank tujuan</label>
            <select class="form-control" id="banktujuan" required name="dest_rek">
              <option value="" disabled selected>Pilih Bank Tujuan</option>
              <option value="BCA">BCA</option>
              <option value="Mandiri">Mandiri</option>
            </select>
          </div>
          <div class="form-group">
            <div class="align-self-center ">
              <div class="custom-file">
                <input type="file" class="form-control" id="image" name="image">
              </div>
            </div>
          </div>
          <div class="form-group">
            <button type="submit" name="submit">KIRIM BUKTI PEMBAYARAN</button>
          </div>
        </form>
      </div>
    </div>
    <div class="col">
      <h2>SILAHKAN BAYAR KE :</h2>
      <h3>BCA : 3992349 / Uwong <br> MANDIRI : 49924 / Jelma</h3>
    </div>
  </div>
</div>
</div>