<?php
include '../config/koneksi.php';
$data = mysqli_query($conn, "
    SELECT h.*, b.nama_barang, b.kode_barang 
    FROM barang_hilang h
    JOIN barang b ON h.id_barang = b.id_barang
    ORDER BY h.tanggal_lapor DESC
");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Laporan Barang Hilang</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <div class="container">
        <h2>📋 Daftar Laporan Barang Hilang</h2>

        <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Kode</th>
                    <th>Tanggal Lapor</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($data)) :
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                        <td><?= $row['kode_barang'] ?></td>
                        <td><?= $row['tanggal_lapor'] ?></td>
                        <td><?= htmlspecialchars($row['keterangan']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        </div>

        <a href="../index.php" class="btn-back">⏪ Kembali</a>
    </div>
</body>

</html>