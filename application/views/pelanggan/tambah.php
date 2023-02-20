<?php $this->load->view('admin/template/header');?>
<?php $this->load->view('admin/template/sidebar');?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?= $title?></h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Kelola Pelanggan</a></div>
        <div class="breadcrumb-item">Tambah Pelanggan</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <form action="<?= base_url('tambah-pelanggan'); ?>" method="post">
              <div class="card-header">
                <h4>Form Tambah Pelanggan</h4>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>ID Pelanggan</label>
                  <input type="text" name="id_pel" class="form-control" value="<?= set_value('id_pel'); ?>" required="">
                  <?= form_error('id_pel', '<span class="text-danger small">', '</span>'); ?>
                </div>
                <div class="form-group">
                  <label>No. KTP</label>
                  <input type="text" name="no_ktp" class="form-control" value="<?= set_value('no_ktp'); ?>" required="">
                  <?= form_error('no_ktp', '<span class="text-danger small">', '</span>'); ?>
                </div>
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama" class="form-control" value="<?= set_value('nama'); ?>" required="">
                  <?= form_error('nama', '<span class="text-danger small">', '</span>'); ?>
                </div>
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" name="username" class="form-control" value="<?= set_value('username'); ?>" required="">
                  <?= form_error('username', '<span class="text-danger small">', '</span>'); ?>
                </div>
                <div class="form-group">
                  <label>No. HP</label>
                  <input type="text" name="no_hp" class="form-control" value="<?= set_value('no_hp'); ?>" required="">
                  <?= form_error('no_hp', '<span class="text-danger small">', '</span>'); ?>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" name="email" class="form-control" value="<?= set_value('email'); ?>" required="">
                  <?= form_error('email', '<span class="text-danger small">', '</span>'); ?>
                </div>
                <div class="form-group">
                  <label>Alamat</label>
                  <input type="text" name="alamat" class="form-control" value="<?= set_value('alamat'); ?>" required="">
                  <?= form_error('alamat', '<span class="text-danger small">', '</span>'); ?>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" name="password" class="form-control" value="<?= set_value('password'); ?>" required="">
                  <?= form_error('password', '<span class="text-danger small">', '</span>'); ?>
                </div>
                <div class="form-group">
                  <label>Konfirmasi Password</label>
                  <input type="password" name="password2" class="form-control" value="<?= set_value('password2'); ?>" required="">
                  <?= form_error('password2', '<span class="text-danger small">', '</span>'); ?>
                </div>
              </div>

              <div class="card-footer text-right">
                <a href="<?= base_url('pelanggan');?>" class="btn btn-light"><i class="fa fa-arrow-left"></i> Kembali</a>
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