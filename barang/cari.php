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
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian</title>
    <link rel="stylesheet" href="../assets/style.css">

</head>

<body>
    <div class="container">
        <h2>🔍 Hasil Pencarian: <em><?= htmlspecialchars($q) ?></em></h2>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th class="hide-mobile">No</th>
                        <th>Nama Barang</th>
                        <th>Kode</th>
                        <th class="hide-mobile">Jumlah</th>
                        <th class="hide-mobile">Kondisi</th>
                        <th class="hide-mobile">Ruangan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if (mysqli_num_rows($data) > 0):
                        while ($row = mysqli_fetch_assoc($data)): ?>
                            <tr>
                                <td class="hide-mobile"><?= $no++ ?></td>
                                <td>
                                    <?= htmlspecialchars($row['nama_barang']) ?>
                                    <div class="mobile-data">
                                        <div>Jumlah: <?= $row['jumlah'] ?></div>
                                        <div>Kondisi: <?= $row['kondisi'] ?></div>
                                        <div>Ruangan: <?= $row['nama_ruangan'] ?? '-' ?></div>
                                    </div>
                                </td>
                                <td><?= $row['kode_barang'] ?></td>
                                <td class="hide-mobile"><?= $row['jumlah'] ?></td>
                                <td class="hide-mobile"><?= $row['kondisi'] ?></td>
                                <td class="hide-mobile"><?= $row['nama_ruangan'] ?? '-' ?></td>
                                <td>
                                    <div class="action-links">
                                        <a href="form_edit.php?id=<?= $row['id_barang'] ?>">Edit</a>
                                        <a href="hapus.php?id=<?= $row['id_barang'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile;
                    else: ?>
                        <tr>
                            <td colspan="7" class="no-results">Tidak ada hasil untuk pencarian ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <a href="/" class="btn-back">⏪ Kembali ke Beranda</a>
    </div>
</body>

</html>