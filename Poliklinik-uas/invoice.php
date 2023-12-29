<?php
// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login'])) {
    // Jika belum login, arahkan kembali ke halaman login
    header('Location: index.php?page=loginUser');
    exit;
}

include_once("koneksi.php");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
  <title>Nota Pembayaran</title>
  <style>
    body {
  font-family: sans-serif;
}

.container {
  width: 800px;
  margin: 0 auto;
}

.header {
  background-color: #000;
  color: #fff;
  padding: 10px;
}

.body {
  padding: 20px;
}

.table {
  border-collapse: collapse;
  width: 100%;
}

.table th, .table td {
  border: 1px solid #000;
  padding: 10px;
  /* margin-right: 50px; */
}

.table th {
  background-color: #ccc;
  /* margin-right: 10px; */
}

.total th, .total td {
  text-align: right;
}

.footer {
  text-align: center;
}

  </style>
</head>
<body>

<div class="container text-center">
    <div class="row justify-content-center">
        <div class="card">
            <h2>Invoice</h2>
            <table>
            <?php
                include('koneksi.php');
                date_default_timezone_set("Asia/Jakarta");
                $result = mysqli_query($mysqli, "SELECT pr.*, d.nama as 'nama_dokter', d.alamat as 'alamat_dokter', d.no_hp as 'no_hp_dokter', p.nama as 'nama_pasien', p.alamat as 'alamat_pasien', p.no_hp as 'no_hp_pasien'
                    FROM periksa pr 
                        LEFT JOIN dokter d ON (pr.id_dokter = d.id) 
                        LEFT JOIN pasien p ON (pr.id_pasien = p.id) 
                        WHERE pr.id='" . $_GET['id'] . "'");
                    $no = 1;
                    $total_invoice = 0;
                    $total_obat = 0;
                    while ($data = mysqli_fetch_array($result)) {
            ?>
            <tr>
                <th>Nomer Periksa :</th>
                <th>Tanggal Periksa :</th>
            </tr>
            <tr>
                <td><?php echo $data['id'] ?></td>
                <td><?php echo date('d-M-Y H:i:s', strtotime($data['tgl_periksa'])) ?></td>
            </tr>
            <tr>
                <th>Pasien :</th>
                <th>Dokter :</th>
            </tr>
            <tr>
                <td><?php echo $data['nama_pasien'] ?></td>
                <td><?php echo $data['nama_dokter'] ?></td>
            </tr>
            <tr>
                <td><?php echo $data['alamat_pasien'] ?></td>
                <td><?php echo $data['alamat_dokter'] ?></td>
            </tr>            
            <tr>
                <td><?php echo $data['no_hp_pasien'] ?></td>
                <td><?php echo $data['no_hp_dokter'] ?></td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <th>Harga</th>
            </tr>
            <tr>
                <td>Jasa Dokter :</td>
                <td><?php echo 'Rp ' . number_format(150000, 2, ',', '.') ?></td>
            </tr>
            <!-- <tr>
                <td>Daftar obat :</td>
            </tr> -->
            <?php
                $result_obat = mysqli_query($mysqli, "SELECT dp.*, o.nama_obat as 'nama_obat', o.harga as 'harga'
                    FROM detail_periksa dp
                    LEFT JOIN obat o ON (dp.id_obat = o.id)
                    WHERE dp.id_periksa = '" . $_GET['id'] . "'");
                while ($data_obat = mysqli_fetch_array($result_obat)) {
                    ?>
                   <tr>
                        <td><?php echo $data_obat['nama_obat'] ?></td>
                        <td><?php echo 'Rp ' . number_format($data_obat['harga'], 2, ',', '.') ?></td>
                    </tr>
                    <?php
                    $total_obat += $data_obat['harga'];
                    }
                    ?>
            <tr>
                <th>Nota Pembayaran</th>
            </tr>
            <tr>
                <td class="bg-info bg-gradient">Subtotal Obat: </td>
                <td class="bg-info bg-gradient"><?php echo 'Rp ' . number_format($total_obat, 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td class="bg-info bg-gradient">Biaya Dokter: </td>
                <td class="bg-info bg-gradient"><?php echo 'Rp ' . number_format(150000, 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td class="bg-info bg-gradient">Total Invoice: </td>
                <td class="bg-info bg-gradient"><?php echo 'Rp ' . number_format($total_obat + 150000, 2, ',', '.') ?></td>
            </tr>
            </table>
            <?php
                    }
                    ?>
        </div>
    </div>
</div>

</body>
</html>