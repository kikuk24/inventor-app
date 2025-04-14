<?php
include '../config/koneksi.php';
$barang = mysqli_query($conn, "SELECT * FROM barang ORDER BY nama_barang");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Lapor Barang Hilang</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <div class="container">
        <h3>🛑 Lapor Barang Hilang</h3>

        <form class="form" action="simpan_laporan.php" method="POST">
            <select name="barang_id" required>
                <option value="">Pilih Barang</option>
                <?php while ($b = mysqli_fetch_assoc($barang)) : ?>
                    <option value="<?= $b['id_barang'] ?>"><?= $b['nama_barang'] ?> (<?= $b['kode_barang'] ?>)</option>
                <?php endwhile; ?>
            </select>

            <textarea name="keterangan" rows="4" placeholder="Keterangan (misal: hilang saat praktik, dll)" required></textarea>
            <button type="submit">🚨 Laporkan</button>
        </form>

        <div style="margin-top: 20px;">
            <a href="../index.php" class="btn-back">⏪ Kembali</a>
        </div>
    </div>
</body>

</html>