<?php $this->load->view('admin/template/header');?>
<?php $this->load->view('admin/template/sidebar');?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?= $title?></h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Kelola Tagihan</a></div>
        <div class="breadcrumb-item">Tambah Tagihan</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <form action="<?= base_url('tambah-tagihan'); ?>" method="post" enctype="multipart/form-data">
              <div class="card-header">
                <h4>Form Tambah Tagihan</h4>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>Tanggal Tagihan</label>
                  <input type="date" name="tgl_tagihan" class="form-control" value="<?= set_value('tgl_tagihan', date('Y-m-d') )?>" readonly>
                  <?= form_error('tgl_tagihan', '<span class="text-danger small">', '</span>'); ?>
                </div>
                <div class="form-group">
                  <label>Masukan ID Pelanggan</label>
                  <input type="text" name="id_pel" class="form-control" id="pelanggan" value="<?= set_value('id_pel') ?>">
                  <?= form_error('id_pel', '<span class="text-danger small">', '</span>'); ?>
                </div>
                <div class="form-group">
                  <label>Masukan No. Meter</label>
                  <input type="number" name="no_meter" class="form-control" value="<?= set_value('no_meter') ?>">
                  <?= form_error('no_meter', '<span class="text-danger small">', '</span>'); ?>
                </div>
                <div class="form-group">
                  <label>Upload Bukti Meter</label>
                  <input type="file" accept="image/*" capture="camera" name="bukti_meter" class="form-control" required="">
                </div>
              </div>

              <div class="card-footer text-right">
                <button type="reset" class="btn btn-danger"><i class="fa fa-sync"></i> Reset</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
  
<?php $this->load->view('admin/template/footer');?>