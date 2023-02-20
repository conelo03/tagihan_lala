      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2020 <div class="bullet"></div> Dibuat dan Dikembangkan oleh <a href="#">Jargas</a>
        </div>
        <div class="footer-right">
          Version 1.1
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="<?= base_url(); ?>assets/js/stisla.js"></script>

  <!-- JS Libraies -->
  <script src="<?= base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url().'assets/vendor/izitoast/js/iziToast.min.js'?>"></script>

  <!-- Template JS File -->
  <script src="<?= base_url(); ?>assets/js/scripts.js"></script>
  <script src="<?= base_url(); ?>assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
  <script src="<?= base_url(); ?>assets/js/page/index-0.js"></script>
  <script type="text/javascript" src="<?php echo base_url().'assets/vendor/jquery-ui/jquery-ui.min.js'?>"></script>
  <script src="<?= base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>

<script src="<?= base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>

  <script type="text/javascript">
      // Set new default font family and font color to mimic Bootstrap's default styling
      Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = '#858796';

      function number_format(number, decimals, dec_point, thousands_sep) {
        // *     example: number_format(1234.56, 2, ',', ' ');
        // *     return: '1 234,56'
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
          prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
          sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
          dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
          s = '',
          toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
          };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
          s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
          s[1] = s[1] || '';
          s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
      }


      var ctx = document.getElementById("myAreaChart");
      var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: <?= $arr_bulan ?>,
          datasets: [{
            label: "Total Tagihan",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgba(78, 115, 223, 1)",
            pointRadius: 4,
            pointBackgroundColor: "rgba(78, 115, 223, 1)",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: <?= $arr_jml_tagihan ?>,
          }],
        },
        options: {
          maintainAspectRatio: false,
          layout: {
            padding: {
              left: 10,
              right: 25,
              top: 25,
              bottom: 0
            }
          },
          scales: {
            xAxes: [{
              time: {
                unit: 'date'
              },
              gridLines: {
                display: false,
                drawBorder: false
              },
              ticks: {
                maxTicksLimit: 7
              }
            }],
            yAxes: [{
              ticks: {
                maxTicksLimit: 5,
                padding: 10,
                // Include a dollar sign in the ticks
                callback: function(value, index, values) {
                  return value;
                }
              },
              gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
              }
            }],
          },
          legend: {
            display: false
          },
          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
              label: function(tooltipItem, chart) {
                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                return datasetLabel + ': Rp ' + number_format(tooltipItem.yLabel);
              }
            }
          }
        }
      });

  </script>
  <script type="text/javascript">
      $(document).ready(function(){
          $("#pelanggan").autocomplete({
            source: "<?php echo site_url('Pelanggan/get_autocomplete/?');?>"
          });
      });
  </script>
  <script type="text/javascript">
    $(document).ready( function () {
      $('#tagihan').selectpicker({
        search : true,
      });
      $('#barang').selectpicker({
        search : true,
      });
      $('#datatables-user').DataTable({
        "ordering": false,
      });
      $('#datatables-pegawai').DataTable({
        "ordering": false,
      });
      $('#datatables-jabatan').DataTable({
        "ordering": false,
      });
      $('#datatables-bidang').DataTable({
        "ordering": false,
      });
      $('#datatables-golongan').DataTable({
        "ordering": false,
      });
      $('#datatables-cuti').DataTable({
        "ordering": false,
      });
      $('#datatables-izin').DataTable({
        "ordering": false,
      });
    });

  </script>
  <?php if($this->session->flashdata('msg')=='success'):?>
    <script type="text/javascript">
      iziToast.success({
          title: 'Sukses!',
          message: 'Data berhasil disimpan!',
          position: 'topCenter', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
      });
    </script>
  <?php elseif($this->session->flashdata('msg')=='error'):?>
    <script type="text/javascript">
      iziToast.error({
          title: 'Gagal!',
          message: 'Data gagal disimpan!',
          position: 'topCenter', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
      });
    </script>
  <?php elseif($this->session->flashdata('msg')=='pembayaran-success'):?>
    <script type="text/javascript">
      iziToast.success({
          title: 'Sukses!',
          message: 'Pemabayaran Berhasil!',
          position: 'topCenter', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
      });
    </script>
  <?php elseif($this->session->flashdata('msg')=='edit'):?>
    <script type="text/javascript">
      iziToast.info({
          title: 'Sukses!',
          message: 'Data berhasil diedit!',
          position: 'topCenter', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
      });
    </script>
  <?php elseif($this->session->flashdata('msg')=='hapus'):?>
    <script type="text/javascript">
      iziToast.success({
          title: 'Sukses!',
          message: 'Data berhasil dihapus!',
          position: 'topCenter', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
      });
    </script>
  <?php elseif($this->session->flashdata('msg')=='password-salah'):?>
    <script type="text/javascript">
      iziToast.error({
          title: 'Gagal!',
          message: 'Password Lama Salah!',
          position: 'topCenter', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
      });
    </script>
  <?php elseif($this->session->flashdata('msg')=='verifikasi'):?>
    <script type="text/javascript">
      iziToast.success({
          title: 'Sukses!',
          message: 'Data berhasil diverifikasi!',
          position: 'topCenter', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
      });
    </script>
  <?php endif; ?>
</body>
</html>
