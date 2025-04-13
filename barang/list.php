<?php
include '../config/koneksi.php';
$data = mysqli_query($conn, "SELECT b.*, r.nama_ruangan FROM barang b LEFT JOIN ruangan r ON b.id_ruangan = r.id_ruangan");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Daftar Barang</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:hover {
            background-color: #f0f8ff;
        }

        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <h2>📦 Daftar Barang Inventaris</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Kondisi</th>
                <th>Ruangan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            while ($row = mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                    <td><?= $row['jumlah'] ?></td>
                    <td><?= $row['kondisi'] ?></td>
                    <td><?= $row['nama_ruangan'] ?? '-' ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>

</html>