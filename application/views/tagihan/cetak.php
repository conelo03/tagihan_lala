<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        * {
            font-size: 8px;
            font-family: 'Times New Roman';
        }

        td,
        th,
        tr,
        table {
            border-top: 1px solid black;
            border-collapse: collapse;
        }

        td.description,
        th.description {
            width: 75px;
            max-width: 75px;
        }

        td.quantity,
        th.quantity {
            width: 20px;
            max-width: 20px;
            word-break: break-all;
        }

        td.price,
        th.price {
            width: 60px;
            max-width: 60px;
            word-break: break-all;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: 200px;
            max-width: 200px;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        @media print {

            .hidden-print,
            .hidden-print * {
                display: none !important;
            }
        }
    </style>
    <title>Cetak Struk</title>
</head>

<body>
    <div class="ticket">
        <!-- <img src="<?= base_url() ?>/assets/images/logo2.png" alt="Logo"> -->
        <p class="centered">Struk pelunasan Tagihan Jaringan gas PT. SEA
            <br>Subang</p>
        <br>
        <table width="100%">
            <tr>
                <td>Nama Pelangan</td>
                <td>:</td>
                <td><?= $nama ?></td>
            </tr>
            <tr>
                <td>No. HP</td>
                <td>:</td>
                <td><?= $no_hp ?></td>
            </tr>
        </table>
        <br>
        <h3>Untuk Pembayaran :</h3>
        <table>
            <thead>
                <tr>
                    <th class="description">Deskripsi</th>
                    <th class="description">Bulan</th>
                    <th class="price">Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="description"><?= 'Tagihan Gas' ?></td>
                    <td class="description"><?= $bulan?></td>
                    <td class="price"><?= $tagihan ?></td>
                </tr>
            </tbody>
        </table>
        <br>
        <p class="centered">Terima kasih atas pembayarannya!
            <br>POWERED By Jargas</p>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>