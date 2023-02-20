<?php $this->load->view('admin/template/header');?>
<?php $this->load->view('admin/template/sidebar');?>
<!-- Main Content -->
<?php if(is_teknisi()): ?>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?= $title?></h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Kelola Tagihan</a></div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Data Tagihan</h4>
              <div class="card-header-action">
                
                  <a href="<?= base_url('tambah-tagihan ');?>" class="btn btn-info"><i class="fa fa-plus"></i> Tambah Data</a>
                
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="datatables-user">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Nama</th>
                      <th>Nama Teknisi</th>
                      <th>Tanggal</th>
                      <th>No. Meter (Terakhir)</th>
                      <th>Pemakaian Bulan Kemarin</th>
                      <th>Pemakaian Bulan Ini</th>
                      <th class="text-center" style="width: 200px;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1; 
                    foreach($tagihan as $u):?>
                    <tr>
                      <td class="text-center"><?= $no++;?></td>
                      <td><?= $u['nama'];?></td>
                      <td><?= $u['teknisi'];?></td>
                      <td><?= $u['tgl_tagihan'];?></td>
                      <td><?= $u['no_meter'];?> m<sup>3</sup></td>
                      <td><?= $u['jml_meter_bulan_kemarin'];?> m<sup>3</sup></td>
                      <td><?= $u['jml_meter_bulan_ini'];?> m<sup>3</sup></td>
                      <td class="text-center">

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
<?php else:?>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?= $title?></h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Kelola Tagihan</a></div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Data Tagihan</h4>
              <div class="card-header-action">
                
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="datatables-user">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Nama</th>
                      <th>Nama Teknisi</th>
                      <th>Tanggal</th>
                      <th>No. Meter (Terakhir)</th>
                      <th>Pemakaian Bulan Ini</th>
                      <th>Tagihan</th>
                      <th>Status</th>
                      <th class="text-center" style="width: 200px;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1; 
                    foreach($tagihan as $u):?>
                    <tr>
                      <td class="text-center"><?= $no++;?></td>
                      <td><?= $u['nama'];?></td>
                      <td><?= $u['teknisi'];?></td>
                      <td><?= $u['tgl_tagihan'];?></td>
                      <td><?= $u['no_meter'];?> m<sup>3</sup></td>
                      <td><?= $u['jml_meter_bulan_ini'];?> m<sup>3</sup></td>
                      <td><?= "Rp ".number_format($u['tagihan'], 2, ',', '.');?></td>
                      <td>
                        <?php if($u['status_tagihan'] == 'BL' && empty($u['bukti_pembayaran'])):?>
                          <span class="badge badge-danger">Belum Bayar</span>
                        <?php elseif($u['status_tagihan'] == 'Transaksi sedang diproses'):?>
                          <span class="badge badge-info">Transaksi sedang diproses</span>
                        <?php elseif($u['status_tagihan'] == 'Transaksi berhasil'):?>
                          <span class="badge badge-success">Transaksi berhasil</span>
                        <?php endif;?>
                      </td>
                      <td class="text-center">

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
<?php endif;?>


<?php foreach($tagihan as $u):?>
<div class="modal fade" tabindex="-1" role="dialog" id="konfirmasi<?= $u['id_tagihan'] ?>">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Bukti Pembayaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('konfirmasi-bukti-pembayaran'); ?>" method="post">
      <div class="modal-body">
        <div class="form-group">
          <input type="hidden" name="id_tagihan" value="<?= $u['id_tagihan'] ?>" class="form-control" required="" />
          <img src="<?= base_url('assets/upload_bukti_pembayaran/'.$u['bukti_pembayaran']) ?>">
        </div>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Konfirmasi</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php endforeach;?>
<?php $this->load->view('admin/template/footer');?>