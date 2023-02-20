<?php $this->load->view('template/header');?>
<?php $this->load->view('template/sidebar');?>
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
              <h4>Data Tagihan</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="datatables-user">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Nama</th>
                      <th>Tanggal</th>
                      <th>No. Meter (Terakhir)</th>
                      <th>Pemakaian Bulan Kemarin</th>
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
                      <td><?= $u['tgl_tagihan'];?></td>
                      <td><?= $u['no_meter'];?></td>
                      <td><?= $u['jml_meter_bulan_kemarin'];?></td>
                      <td><?= $u['jml_meter_bulan_ini'];?></td>
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
                        <?php if($u['status_tagihan'] == 'BL' && empty($u['bukti_pembayaran'])):?>
                          <button class="btn btn-success" id="pay-button<?= $u['id_tagihan'] ?>"><i class="fa fa-upload"></i> Bayar</button>
                        <?php elseif($u['status_tagihan'] == 'Transaksi sedang diproses'):?>
                          <button class="btn btn-success" id="pay-button<?= $u['id_tagihan'] ?>"><i class="fa fa-upload"></i> Ubah Cara Pembayaran</button>
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



<?php foreach($tagihan as $u):?>
<form id="payment-form<?= $u['id_tagihan'] ?>" method="post" action="<?= base_url()?>Tagihan/finish">
  <input type="hidden" name="id_tagihan" value="<?= $u['id_tagihan'] ?>">
  <input type="hidden" name="result_type" id="result-type" value=""></div>
  <input type="hidden" name="result_data" id="result-data" value=""></div>
</form>
<?php endforeach;?>

<?php foreach($tagihan as $u):?>
  <script type="text/javascript">
    
    $('#pay-button<?= $u['id_tagihan'] ?>').click(function (event) {
      event.preventDefault();
      $(this).attr("disabled", "disabled");
    
    $.ajax({
      url: '<?= base_url()?>Tagihan/token',
      cache: false,
      type: "POST",
      data: {id_tagihan: <?= $u['id_tagihan'] ?>},

      success: function(data) {
        //location = data;

        console.log('token = '+data);
        
        var resultType = document.getElementById('result-type');
        var resultData = document.getElementById('result-data');

        function changeResult(type,data){
          $("#result-type").val(type);
          $("#result-data").val(JSON.stringify(data));
          //resultType.innerHTML = type;
          //resultData.innerHTML = JSON.stringify(data);
        }

        snap.pay(data, {
          
          onSuccess: function(result){
            changeResult('success', result);
            console.log(result.status_message);
            console.log(result);
            $("#payment-form<?= $u['id_tagihan'] ?>").submit();
          },
          onPending: function(result){
            changeResult('pending', result);
            console.log(result.status_message);
            $("#payment-form<?= $u['id_tagihan'] ?>").submit();
          },
          onError: function(result){
            changeResult('error', result);
            console.log(result.status_message);
            $("#payment-form<?= $u['id_tagihan'] ?>").submit();
          }
        });
      }
    });
  });

  </script> 
<?php endforeach;?>

<?php $this->load->view('template/footer');?>