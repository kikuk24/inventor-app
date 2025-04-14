<?php
include '../config/koneksi.php';

$barang_id = $_POST['barang_id'];
$keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
$tanggal = date('Y-m-d');

mysqli_query($conn, "INSERT INTO barang_hilang (id_barang, tanggal_lapor, keterangan)
VALUES ('$barang_id', '$tanggal', '$keterangan')");

header("Location: list_hilang.php");
exit;
