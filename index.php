<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h2>Inventaris Barang Laboratorium</h2>

        <div class="nav">
            <a href="barang/form_input.php">+ Tambah Barang</a>
            <a href="barang/list.php">📦 Lihat Barang</a>
            <a href="laporan/index.php">📊 Laporan</a>
        </div>

        <form action="barang/cari.php" method="get" style="margin-top: 30px;">
            <input type="text" name="q" placeholder="Cari nama atau kode barang..." required>
            <button type="submit">🔍 Cari</button>
        </form>
    </div>
</body>

</html>