<?php
include '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $hapus = mysqli_query($conn, "DELETE FROM barang WHERE id_barang = $id");

    if ($hapus) {
        echo "<script>alert('✅ Barang berhasil dihapus.'); window.location.href='../index.php';</script>";
    } else {
        echo "<script>alert('❌ Gagal menghapus barang.'); window.location.href='../index.php';</script>";
    }
} else {
    header('Location: ../index.php');
    exit;
}
