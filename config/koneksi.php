<?php
// koneksi.php - by Kikuk's style
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'inventaris_lab';

$conn = mysqli_connect($host, $user, $pass);

if (!$conn) {
    die("<h3>❌ Gagal koneksi ke MySQL Server</h3>");
}

// --- Cek database ada atau tidak
$dbList = mysqli_query($conn, "SHOW DATABASES");
$found = false;

while ($db = mysqli_fetch_assoc($dbList)) {
    if ($db['Database'] === $dbname) {
        $found = true;
        break;
    }
}

// --- Kalau belum ada, tampilkan tombol buat
if (!$found) {
    echo "<div style='font-family:sans-serif; padding:20px'>";
    echo "<h2>⚠️ Database <code>$dbname</code> belum ditemukan.</h2>";
    echo "<form method='post'>";
    echo "<button name='buat_db' style='padding:10px 20px; background:#007bff; color:white; border:none; border-radius:6px; cursor:pointer'>+ Buat Database & Tabel</button>";
    echo "</form>";
    echo "</div>";

    if (isset($_POST['buat_db'])) {
        $createDb = mysqli_query($conn, "CREATE DATABASE $dbname");
        if ($createDb) {
            mysqli_select_db($conn, $dbname);

            // --- Buat tabel ruangan
            $sql1 = "CREATE TABLE IF NOT EXISTS ruangan (
        id_ruangan INT AUTO_INCREMENT PRIMARY KEY,
        nama_ruangan VARCHAR(100) NOT NULL
        )";
            mysqli_query($conn, $sql1);
            //--- Tambah data ruangan default
            $sql1 = "INSERT INTO ruangan (nama_ruangan) VALUES ('HI-101'), ('HI-102'), ('HI-103'), ('HI-201'), ('HI-202'), ('HI-203'), ('HI-301'), ('HI-302'), ('HI-303')";
            mysqli_query($conn, $sql1);

            // --- Buat tabel barang
            $sql2 = "CREATE TABLE IF NOT EXISTS barang (
        id_barang INT AUTO_INCREMENT PRIMARY KEY,
        nama_barang VARCHAR(100) NOT NULL,
        kode_barang VARCHAR(50) NOT NULL,
        UNIQUE (kode_barang),
        jumlah INT NOT NULL,
        kondisi ENUM('Baik','Rusak') NOT NULL,
        id_ruangan INT,
        FOREIGN KEY (id_ruangan) REFERENCES ruangan(id_ruangan)
        )";
            mysqli_query($conn, $sql2);

            //--- Buat tabel barang_hilang
            $sql2 = "CREATE TABLE IF NOT EXISTS barang_hilang (
            id INT AUTO_INCREMENT PRIMARY KEY,
            id_barang INT NOT NULL,
            tanggal_lapor DATE NOT NULL,
            keterangan TEXT,
            FOREIGN KEY (id_barang) REFERENCES barang(id_barang)
)";
            mysqli_query($conn, $sql2);
            echo "<script>alert('✅ Database & tabel berhasil dibuat!'); location.reload();</script>";
        } else {
            echo "<p>❌ Gagal membuat database: " . mysqli_error($conn) . "</p>";
        }
    }

    exit;
}

// --- Kalau DB sudah ada, langsung konek
mysqli_select_db($conn, $dbname);

// --- Tambahan: auto-cek & buat tabel kalau belum ada (untuk backup)
mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS ruangan (
  id_ruangan INT AUTO_INCREMENT PRIMARY KEY,
  nama_ruangan VARCHAR(100) NOT NULL
)");

mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS barang (
  id_barang INT AUTO_INCREMENT PRIMARY KEY,
  nama_barang VARCHAR(100) NOT NULL,
  jumlah INT NOT NULL,
  kondisi ENUM('Baik','Rusak') NOT NULL,
  id_ruangan INT,
  FOREIGN KEY (id_ruangan) REFERENCES ruangan(id_ruangan)
)");
