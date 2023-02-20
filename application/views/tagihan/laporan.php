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
              <h4>Grafik Tagihan</h4>
            </div>
            <div class="card-body">
              <div class="chart-area">
                  <canvas id="myAreaChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section">

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Laporan Tagihan</h4>
            </div>
            <div class="card-body">
              <form action="<?= base_url('laporan-tagihan') ?>" method="post">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <select class="form-control" name="tgl_tagihan">
                        <option disabled="" selected="">--Pilih Bulan--</option>
                        <?php foreach($bulan as $p):?>
                          <option value="<?= date('Y-m', strtotime($p['tgl_tagihan'])) ?>" <?= set_value('tgl_tagihan') == date('Y-m', strtotime($p['tgl_tagihan'])) ? 'selected' : ''; ?>><?= date('F Y', strtotime($p['tgl_tagihan'])) ?></option>
                        <?php endforeach; ?>
                      </select>
                      <?= form_error('tgl_tagihan', '<span class="text-danger small">', '</span>'); ?>
                    </div>
                  </div>
                  <div class="col-md-6"> 
                    <button type="submit" class="btn btn-info mr-2" formtarget="_blank"><i class="fa fa-print"></i> Cetak</button>
                  </div>
                </div>
              </form>      
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
                        <?php if($u['status_tagihan'] == 'BL'):?>
                          <span class="badge badge-danger">Belum Bayar</span>
                        <?php elseif($u['status_tagihan'] == 'Transaksi sedang diproses'):?>
                          <span class="badge badge-info">Transaksi sedang diproses</span>
                        <?php elseif($u['status_tagihan'] == 'Transaksi berhasil'):?>
                          <span class="badge badge-success">Transaksi berhasil</span>
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