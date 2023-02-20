<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title?></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-2">
        <div class="mt-2">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title mb-4 text-center"><?= 'Laporan Tagihan Penggunaan Gas PT. Subang Energi Abadi' ?></h3>
                            <table class="table table-striped table-bordered">
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
                                    $total = 0;
                                    foreach($tagihan as $u):
                                        $total += $u['tagihan'];
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $no++;?></td>
                                        <td><?= $u['nama'];?></td>
                                        <td><?= date('d F Y', strtotime($u['tgl_tagihan']));?></td>
                                        <td><?= $u['no_meter'];?></td>
                                        <td><?= $u['jml_meter_bulan_ini'];?></td>
                                        <td><?= "Rp ".number_format($u['tagihan'], 2, ',', '.');?></td>
                                        <td><?= date('d F Y', strtotime($u['tgl_bayar']));?></td>
                                        <td>
                                        <?php if($u['status'] == 'BL'):?>
                                          <span class="badge badge-danger">Belum Bayar</span>
                                        <?php elseif($u['status'] == 'Transaksi sedang diproses'):?>
                                          <span class="badge badge-info">Transaksi sedang diproses</span>
                                        <?php elseif($u['status'] == 'Transaksi berhasil'):?>
                                          <span class="badge badge-success">Transaksi berhasil</span>
                                        <?php endif;?>
                                      </td>
                                    </tr>
                                    <?php endforeach;?>
                                    <tr>
                                        <td colspan="5" class="text-center">TOTAL</td>
                                        <td><?= "Rp ".number_format($total, 2, ',', '.') ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>
