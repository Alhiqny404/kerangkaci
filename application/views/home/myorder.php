<div class="container bg-white shadow-sm">
  <div class="p-4">
    <table class="table table-sm" id="tabel-order">
      <thead>
        <tr>
          <th scope="col">ID ORDER</th>
          <th scope="col">Penerima</th>
          <th scope="col">Total Bayar</th>
          <th scope="col">Tanggal Order</th>
          <th scope="col">Status</th>
          <th scope="col">opsi</th>
        </tr>
      </thead>
      <tbody>

        <?php
        if (!empty($orders)) :
        foreach ($orders as $order) : ?>
        <tr>
          <td><a href="<?= base_url('myorder/').$order->id_transaction ?>"><?= $order->id_transaction ?></a></td>
          <td><?= json_decode($order->recipient_data)->customer->name ?></td>
          <td><?= $order->total_pay ?></td>
          <td><?= date('d-m-Y', $order->created_at) ?></td>
          <?php if ($order->status == 'new'): ?>
          <td>Belum Bayar</td>
          <?php elseif ($order->status == 'pending') : ?>
          <td>Menunggu Konfirmasi</td>
          <?php elseif ($order->status == 'terima') : ?>
          <td>Menunggu Pengiriman</td>
          <?php elseif ($order->status == 'tolak') : ?>
          <td>Pesanan Ditolak</td>
          <?php elseif ($order->status == 'kirim') : ?>
          <td>Dalam Pengiriman</td>
          <?php elseif ($order->status == 'selesai') : ?>
          <td>Telah diterima</td>
          <?php endif; ?>
          <?php if ($order->status == 'new') : ?>
          <td>
            <a href="<?=site_url('pay/'.$order->id_transaction) ?>" class="btn btn-sm btn-warning">bayar</a>
            <a href="" class="btn btn-sm btn-danger">batalkan pesanan</a>
          </td>
          <?php elseif ($order->status == 'pending') : ?>
          <td>
            <a href="" class="btn btn-sm btn-warning">Lihat Bukti Pembayaran</a>
          </td>
          <?php elseif ($order->status == 'tolak') : ?>
          <td>
            <a href="" class="btn btn-sm btn-danger">Lihat Alasan</a>
          </td>
          <?php elseif ($order->status == 'terima') : ?>
          <td>
            <a href="" class="btn btn-sm btn-info">Detail Pesanan</a>
          </td
          <?php elseif ($order->status == 'kirim') : ?>
          <td>
          <a href="" class="btn btn-sm btn-success">Lacak Pesanan</a>
          <a href="" class="btn btn-sm btn-info">Pesanan Diterima</a>
        </td>
        <?php endif; ?>
      </tr>
      <?php endforeach; ?>
      <?php else : ?>
      <tr>
        <td colspan="6">BELUM ADA RIWAYAT PEMBELIAN</td>
      </tr>
      <?php endif;
      ?>

    </tbody>
  </table>

</div>
</div>
<div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="uploadTitle"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="uploadTitle">Bukti Pembayaran</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<?php echo form_open_multipart(''); ?>
<?= form_hidden('id_user', $this->session->userdata('id_user')) ?>
<?= form_hidden('id_order',); ?>
<div class="modal-body">
<div class="form-group">
<label for="accname">A/N</label>
<input type="text" name="acc_name" class="form-control" required id="accname" placeholder="Nama">
</div>
<div class="form-group">
<label for="daribank">Dari Bank</label>
<select class="form-control" id="daribank" required name="code_bank">
<?php foreach ($banks as $bank) {
?>
<option value="<?=$bank->code ?>"><?=$bank->name ?></option>
<?php
} ?>

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
<input type="file" class="custom-file-input" id="image" name="image">
<label class="custom-file-label" for="image" required>Choose file</label>
</div>
</div>

</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
<button type="submit" class="btn btn-primary" name="upload" value="upload">Upload</button>
</div>
</form>
</div>
</div>
</div>