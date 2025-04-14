<?php
include 'config/koneksi.php';
$data = mysqli_query($conn, "SELECT b.*, r.nama_ruangan FROM barang b LEFT JOIN ruangan r ON b.id_ruangan = r.id_ruangan");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang Inventaris</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="container">
        <h2>📦 Daftar Barang Inventaris</h2>

        <div class="nav">
            <a href="/barang/form_input.php">+ Tambah Barang</a>
            <a href="/laporan/form_hilang.php">🛑 Lapor Kehilangan</a>
            <a href="/laporan/list_hilang.php">📋 Lihat Laporan</a>
        </div>

        <div class="search-form">
            <form action="/barang/cari.php" method="get">
                <input type="text" name="q" placeholder="Cari nama atau kode barang..." required>
                <button type="submit">🔍 Cari</button>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th class="hide-mobile">No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
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
                                <td><?= htmlspecialchars($row['kode_barang']) ?></td>
                                <td>
                                    <?= htmlspecialchars($row['nama_barang']) ?>
                                    <div class="mobile-data">
                                        <div>Jumlah: <?= $row['jumlah'] ?></div>
                                        <div>Kondisi: <?= $row['kondisi'] ?></div>
                                        <div>Ruangan: <?= $row['nama_ruangan'] ?? '-' ?></div>
                                    </div>
                                </td>
                                <td class="hide-mobile"><?= $row['jumlah'] ?></td>
                                <td class="hide-mobile"><?= $row['kondisi'] ?></td>
                                <td class="hide-mobile"><?= $row['nama_ruangan'] ?? '-' ?></td>
                                <td>
                                    <div class="action-links">
                                        <a href="/barang/form_edit.php?id=<?= $row['id_barang'] ?>">Edit</a>
                                        <a href="/barang/hapus.php?id=<?= $row['id_barang'] ?>"
                                            onclick="return confirm('⚠️ Apakah Anda yakin ingin menghapus barang ini?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile;
                    else: ?>
                        <tr>
                            <td colspan="7" class="no-data">Tidak ada data barang.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
    <footer style="text-align: center; margin-top: 20px;">Copyright Kelompok 2 &copy; 2023. All rights reserved.</footer>
</body>

</html>