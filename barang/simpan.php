<?php
// simpan.php
// Simpan data barang ke database
include '../config/koneksi.php';

$nama = $_POST['nama'];
$kondisi = $_POST['kondisi'];
$jumlah = $_POST['jumlah'];
$ruangan_id = $_POST['ruangan_id'];

function generateKodeBarang($conn)
{
    $query = "SELECT MAX(id_barang) as max_id FROM barang";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    $maxId = isset($data['max_id']) ? (int)$data['max_id'] + 1 : 1;
    return "BRG" . str_pad($maxId, 4, '0', STR_PAD_LEFT);
}

$kode_barang = generateKodeBarang($conn);

$query = "INSERT INTO barang (nama_barang, kondisi, kode_barang, jumlah, id_ruangan)
            VALUES ('$nama',  '$kondisi', '$kode_barang', '$jumlah', '$ruangan_id')";

mysqli_query($conn, $query);

header("Location: ../index.php");
