<?php
$id_pelanggan = $this->session->userdata('id_pelanggan');
$get_user = $this->db->get_where('tb_pelanggan', ['id_pelanggan' => $id_pelanggan])->row_array();
$get_tagihan = $this->db->get_where('tb_tagihan', ['status' => 'BL', 'id_pelanggan' => $id_pelanggan, 'tgl_bayar' => null])->result_array();
$cek_tagihan = $this->db->get_where('tb_tagihan', ['status' => 'BL', 'id_pelanggan' => $id_pelanggan, 'tgl_bayar' => null])->num_rows();
?>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <ul class="navbar-nav mr-auto">
          <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg <?= $cek_tagihan > 0 ? 'beep' : ''; ?>"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Notifications
              </div>
              <div class="dropdown-list-content dropdown-list-icons">
                <?php foreach ($get_tagihan as $key): 
                  $bulan = date('F', strtotime($key['tgl_tagihan']));
                  ?>
                  <a href="<?= base_url('tagihan') ?>" class="dropdown-item">
                    <div class="dropdown-item-icon bg-info text-white">
                      <i class="fas fa-bell"></i>
                    </div>
                    <div class="dropdown-item-desc">
                      Pelanggan Yth. Silahkan untuk melakukan Pembayaran Tagihan bulan <?= $bulan ?>
                      <div class="time"><?= $key['tgl_tagihan'] ?></div>
                    </div>
                  </a>
                <?php endforeach; ?>
              </div>
              <div class="dropdown-footer text-center">
                <a href="<?= base_url('tagihan') ?>">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li>
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="<?= base_url('assets/img/profile/user.png'); ?>" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block"><?= $get_user['nama'] ?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="<?= base_url('setting-pelanggan');?>" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Edit Akun
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item has-icon text-danger" data-confirm="Logout|Anda yakin ingin keluar?" data-confirm-yes="document.location.href='<?= base_url('logout'); ?>';"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
          </li>
        </ul>
      </nav>

      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="#">JarGas</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">JG</a>
          </div>
          
          <ul class="sidebar-menu">
            <li class="menu-header">Menu</li>
            <li class="<?= $title == 'Dashboard' ? 'active' : ''; ?>"><a class="nav-link" href="<?= base_url('dashboard');?>"><i class="fas fa-circle"></i> <span>Dashboard</span></a></li>   

            <li class="menu-header">Transaksi</li>

            <li class="<?= $title == 'Data Tagihan' ? 'active' : ''; ?>"><a class="nav-link" href="<?= base_url('tagihan');?>"><i class="fas fa-circle"></i> <span>Data Tagihan</span></a></li> 
            <li class="<?= $title == 'Riwayat Tagihan' ? 'active' : ''; ?>"><a class="nav-link" href="<?= base_url('riwayat-tagihan');?>"><i class="fas fa-circle"></i> <span>Riwayat Tagihan</span></a></li> 
          </ul>

          <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <button class="btn btn-danger btn-lg btn-block btn-icon-split" data-confirm="Logout|Anda yakin ingin keluar?" data-confirm-yes="document.location.href='<?= base_url('logout'); ?>';"><i class="fa fa-sign-out-alt"></i> Logout</button>
          </div>
        </aside>
      </div>
      