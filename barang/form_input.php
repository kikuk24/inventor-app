<?php
// form_input.php
// Form tambah barang
include '../config/koneksi.php';

// Ambil daftar ruangan
$ruangan = mysqli_query($conn, "SELECT * FROM ruangan");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tambah Barang</title>
    <link rel="stylesheet" href="../assets/style.css">
    
</head>

<body>
    <div class="container">
        <h3>Tambah Barang Baru</h3>

        <form action="simpan.php" method="POST">
            <input type="text" name="nama" placeholder="Nama Barang" required>

            <input type="number" name="jumlah" placeholder="Jumlah Barang" required>

            <select name="kondisi" required>
                <option value="">Pilih Kondisi</option>
                <option value="Baik">Baik</option>
                <option value="Rusak">Rusak</option>
            </select>

            <select name="ruangan_id" required>
                <option value="">Pilih Ruangan</option>
                <?php while ($r = mysqli_fetch_assoc($ruangan)) : ?>
                    <option value="<?= $r['id_ruangan'] ?>"><?= $r['nama_ruangan'] ?></option>
                <?php endwhile; ?>
            </select>

            <button type="submit">💾 Simpan Barang</button>
        </form>

        <div style="margin-top: 20px;">
            <a href="../index.php" class="btn-back">⏪ Kembali</a>
        </div>
    </div>
</body>

</html>