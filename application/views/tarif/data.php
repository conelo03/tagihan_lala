<?php $this->load->view('admin/template/header');?>
<?php $this->load->view('admin/template/sidebar');?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?= $title?></h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Kelola Tarif</a></div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Data Tarif</h4>
              <div class="card-header-action">
                <a href="<?= base_url('tambah-tarif');?>" class="btn btn-info"><i class="fa fa-plus"></i> Tambah Data</a>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="datatables-user">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Tarif</th>
                      <th>Status</th>
                      <th class="text-center" style="width: 300px;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1; 
                    foreach($tarif as $u):?>
                    <tr>
                      <td class="text-center"><?= $no++;?></td>
                      <td><?= "Rp ".number_format($u['tarif'], 2, ',', '.')." / m<sup>3</sup>";?></td>
                      <td>
                        <?php if($u['status'] == '1'):?>
                          <span class="badge badge-success">Aktif</span>
                        <?php elseif($u['status'] == '0'):?>
                          <span class="badge badge-danger">Tidak Aktif</span>
                        <?php endif;?>
                      </td>
                      <td class="text-center">
                        <a href="<?= base_url('edit-tarif/'.$u['id_tarif']);?>" class="btn btn-info"><i class="fa fa-edit"></i> Edit</a>
                        <button class="btn btn-danger" data-confirm="Anda yakin ingin menghapus data ini?|Data yang sudah dihapus tidak akan kembali." data-confirm-yes="document.location.href='<?= base_url('hapus-tarif/'.$u['id_tarif']); ?>';"><i class="fa fa-trash"></i> Delete</button>
                        <?php if($u['status'] == '1'):?>
                          <button class="btn btn-light" data-confirm="Anda yakin ingin menonaktifkan Tarif ini?" data-confirm-yes="document.location.href='<?= base_url('status-tarif/'.$u['id_tarif'].'/0'); ?>';"><i class="fa fa-times"></i> Non-Aktifkan</button>
                        <?php elseif($u['status'] == '0'):?>
                          <button class="btn btn-success" data-confirm="Anda yakin ingin mengaktifkan Tarif ini?" data-confirm-yes="document.location.href='<?= base_url('status-tarif/'.$u['id_tarif'].'/1'); ?>';"><i class="fa fa-check"></i> Aktifkan</button>
                        <?php endif;?>
                      </td>
                    </tr>
                    <?php endforeach;?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php $this->load->view('admin/template/footer');?>