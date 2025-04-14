<?php
include '../config/koneksi.php';

$q = $_GET['q'] ?? '';
$qSafe = '%' . $q . '%';

$data = mysqli_query($conn, "
    SELECT b.*, r.nama_ruangan 
    FROM barang b 
    LEFT JOIN ruangan r ON b.id_ruangan = r.id_ruangan
    WHERE b.nama_barang LIKE '$qSafe' OR b.kode_barang LIKE '$qSafe'
    ORDER BY b.id_barang DESC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Hasil Pencarian</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
        }

        h2 {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 8px;
            width: 300px;
            margin-right: 10px;
        }

        button {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
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

        .btn-back {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: white;
            background-color: #555;
            padding: 8px 16px;
            border-radius: 6px;
        }
    </style>
</head>

<body>
    <h2>🔍 Hasil Pencarian: <em><?= htmlspecialchars($q) ?></em></h2>

    <table class="wrapper">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kode</th>
                <th>Jumlah</th>
                <th>Kondisi</th>
                <th>Ruangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if (mysqli_num_rows($data) > 0):
                while ($row = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                        <td><?= $row['kode_barang'] ?></td>
                        <td><?= $row['jumlah'] ?></td>
                        <td><?= $row['kondisi'] ?></td>
                        <td><?= $row['nama_ruangan'] ?? '-' ?></td>
                    </tr>
                <?php endwhile;
            else: ?>
                <tr>
                    <td colspan="6" style="text-align:center;">Tidak ada hasil untuk pencarian ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="list.php" class="btn-back">⏪ Kembali ke Beranda</a>
</body>

</html>