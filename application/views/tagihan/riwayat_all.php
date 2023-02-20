<?php $this->load->view('admin/template/header');?>
<?php $this->load->view('admin/template/sidebar');?>
<!-- Main Content -->
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
              <h4>Riwayat Tagihan</h4>
              
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="datatables-user">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Nama</th>
                      <th>Tanggal</th>
                      <th>No. Meter</th>
                      <th>Pemakaian Bulan Ini</th>
                      <th>Tagihan</th>
                      <th>Tanggal Bayar</th>
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
                      <td><?= date('d F Y', strtotime($u['tgl_tagihan']));?></td>
                      <td><?= $u['no_meter'];?></td>
                      <td><?= $u['jml_meter_bulan_ini'];?></td>
                      <td><?= "Rp ".number_format($u['tagihan'], 2, ',', '.');?></td>
                      <td><?= date('d F Y', strtotime($u['tgl_bayar']));?></td>
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
                        <a href="<?= base_url('cetak-tagihan/'.$u['id_tagihan']);?>" target="_blank" class="btn btn-info"><i class="fa fa-print"></i> Cetak</a>
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