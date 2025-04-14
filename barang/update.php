<?php
include '../config/koneksi.php';

$id = $_POST['id'];
$nama = $_POST['nama'];
$jumlah = $_POST['jumlah'];
$kondisi = $_POST['kondisi'];
$ruangan_id = $_POST['ruangan_id'];

$query = "UPDATE barang SET 
    nama_barang = '$nama',
    jumlah = $jumlah,
    kondisi = '$kondisi',
    id_ruangan = $ruangan_id
    WHERE id_barang = $id";

$result = mysqli_query($conn, $query);

if ($result) {
    echo "<script>alert('✅ Data barang berhasil diperbarui'); window.location.href = '../index.php';</script>";
} else {
    echo "<script>alert('❌ Gagal memperbarui data barang'); history.back();</script>";
}
