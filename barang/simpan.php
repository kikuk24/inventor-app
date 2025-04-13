<?php
// simpan.php
// Simpan data barang ke database
include '../config/koneksi.php';

$nama = $_POST['nama'];
$kode = $_POST['kode'];
$kategori = $_POST['kategori'];
$jumlah = $_POST['jumlah'];
$ruangan_id = $_POST['ruangan_id'];

$query = "INSERT INTO barang (nama_barang, kategori, jumlah, ruangan_id)
            VALUES ('$nama',  '$kategori', '$jumlah', '$ruangan_id')";

mysqli_query($conn, $query);

header("Location: list.php");