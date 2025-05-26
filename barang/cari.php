<?php
include '../config/koneksi.php';

// Ambil filter
$q = $_GET['q'] ?? '';
$kondisi = $_GET['kondisi'] ?? '';
$ruangan = $_GET['ruangan'] ?? '';

$qSafe = '%' . mysqli_real_escape_string($conn, $q) . '%';
$where = [];

if (!empty($q)) {
    $where[] = "(b.nama_barang LIKE '$qSafe' OR b.kode_barang LIKE '$qSafe')";
}
if (!empty($kondisi)) {
    $where[] = "b.kondisi = '" . mysqli_real_escape_string($conn, $kondisi) . "'";
}
if (!empty($ruangan)) {
    $where[] = "b.id_ruangan = " . (int)$ruangan;
}

$whereSql = '';
if (!empty($where)) {
    $whereSql = 'WHERE ' . implode(' AND ', $where);
}

// Ambil data barang beserta info hilangnya jika ada
$data = mysqli_query($conn, "
    SELECT b.*, r.nama_ruangan, bh.keterangan AS keterangan_hilang, bh.tanggal_lapor 
    FROM barang b
    LEFT JOIN ruangan r ON b.id_ruangan = r.id_ruangan
    LEFT JOIN barang_hilang bh ON bh.id_barang = b.id_barang
    $whereSql
    ORDER BY b.id_barang DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Barang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <div class="container">
        <h2>📦 Data Barang</h2>

        <div class="search-form">
            <form action="cari.php" method="get" class="search-form">
                <input type="text" name="q" placeholder="Cari nama atau kode barang..." value="<?= htmlspecialchars($q) ?>">
                <select name="kondisi">
                    <option value="">Semua Kondisi</option>
                    <option value="Baik" <?= $kondisi === 'Baik' ? 'selected' : '' ?>>Baik</option>
                    <option value="Rusak" <?= $kondisi === 'Rusak' ? 'selected' : '' ?>>Rusak</option>
                </select>
                <select name="ruangan">
                    <option value="">Semua Ruangan</option>
                    <?php
                    $ruanganList = mysqli_query($conn, "SELECT * FROM ruangan");
                    while ($r = mysqli_fetch_assoc($ruanganList)) {
                        $selected = $ruangan == $r['id_ruangan'] ? 'selected' : '';
                        echo "<option value='{$r['id_ruangan']}' $selected>{$r['nama_ruangan']}</option>";
                    }
                    ?>
                </select>
                <button type="submit">🔍 Cari</button>
            </form>
        </div>

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
                        <th>Status</th>
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
                                        <div>Status: <?php if ($row['tanggal_lapor']): ?>
                                        Hilang pada <?= date('d M Y', strtotime($row['tanggal_lapor'])) ?><br>
                                        <small><?= $row['keterangan_hilang'] ?></small>
                                    <?php else: ?>
                                        ✅ Aman
                                    <?php endif; ?></div>
                                    </div>
                                </td>
                                <td><?= $row['kode_barang'] ?></td>
                                <td class="hide-mobile"><?= $row['jumlah'] ?></td>
                                <td class="hide-mobile"><?= $row['kondisi'] ?></td>
                                <td class="hide-mobile"><?= $row['nama_ruangan'] ?? '-' ?></td>
                                <td class="hide-mobile"><?php if ($row['tanggal_lapor']): ?>
                                        Hilang pada <?= date('d M Y', strtotime($row['tanggal_lapor'])) ?><br>
                                        <small><?= $row['keterangan_hilang'] ?></small>
                                    <?php else: ?>
                                        ✅ Aman
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="action-links">
                                        <a href="form_edit.php?id=<?= $row['id_barang'] ?>">Edit</a>
                                        <a href="hapus.php?id=<?= $row['id_barang'] ?>" onclick="return confirm('Yakin hapus barang ini?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile;
                    else: ?>
                        <tr>
                            <td colspan="8" class="no-results">Tidak ada data barang ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <a href="/" class="btn-back">⏪ Kembali</a>
    </div>
</body>

</html>