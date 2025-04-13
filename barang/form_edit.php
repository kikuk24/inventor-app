<?php
include '../config/koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<p>ID Barang tidak ditemukan.</p>";
    exit;
}

// Ambil data barang yang akan diedit
$query = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang = $id");
$barang = mysqli_fetch_assoc($query);

// Ambil daftar ruangan
$ruangan = mysqli_query($conn, "SELECT * FROM ruangan");

if (!$barang) {
    echo "<p>Barang tidak ditemukan.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Barang</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <div class="container">
        <h3>✏️ Edit Barang</h3>

        <form action="update.php" method="POST">
            <input type="hidden" name="id" value="<?= $barang['id_barang'] ?>">

            <input type="text" name="nama" value="<?= htmlspecialchars($barang['nama_barang']) ?>" required>

            <input type="number" name="jumlah" value="<?= $barang['jumlah'] ?>" required>

            <select name="kondisi" required>
                <option value="">Pilih Kondisi</option>
                <option value="Baik" <?= $barang['kondisi'] == 'Baik' ? 'selected' : '' ?>>Baik</option>
                <option value="Rusak" <?= $barang['kondisi'] == 'Rusak' ? 'selected' : '' ?>>Rusak</option>
            </select>

            <select name="ruangan_id" required>
                <option value="">Pilih Ruangan</option>
                <?php while ($r = mysqli_fetch_assoc($ruangan)) : ?>
                    <option value="<?= $r['id_ruangan'] ?>" <?= $r['id_ruangan'] == $barang['id_ruangan'] ? 'selected' : '' ?>>
                        <?= $r['nama_ruangan'] ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <button type="submit">💾 Simpan Perubahan</button>
        </form>

        <div style="margin-top: 20px;">
            <a href="../index.php" class="btn-back">⏪ Kembali</a>
        </div>
    </div>
</body>

</html>
