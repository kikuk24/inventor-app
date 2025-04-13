<?php
// form_input.php
// Form tambah barang
include '../config/koneksi.php';

// Ambil daftar ruangan
$ruangan = mysqli_query($conn, "SELECT * FROM ruangan");
?>

<link rel="stylesheet" href="../assets/style.css">
<div class="container">
    <h3>Tambah Barang Baru</h3>

    <form action="simpan.php" method="POST">
        <input type="text" name="nama" placeholder="Nama Barang" required>
        <!-- <input type="text" name="kode" placeholder="Kode Unik" required> -->
        <input type="text" name="kategori" placeholder="Kategori (misal: PC, Kabel, dll)" required>
        <input type="number" name="jumlah" placeholder="Jumlah Barang" required>

        <select name="ruangan_id" required>
            <option value="">Pilih Ruangan</option>
            <?php while ($r = mysqli_fetch_assoc($ruangan)) : ?>
                <option value="<?= $r['id_ruangan'] ?>"><?= $r['nama_ruangan'] ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">💾 Simpan Barang</button>
    </form>
</div>