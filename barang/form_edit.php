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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        /* Responsive styles for form */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: sans-serif;
            background-color: #f7f7f7;
            line-height: 1.6;
            padding: 16px;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
            font-size: 1.5rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 100%;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
        }

        input::placeholder {
            color: #aaa;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 12px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .btn-back {
            display: inline-block;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 4px;
            font-size: 0.9rem;
            transition: background-color 0.3s;
            text-align: center;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }

        /* Error message styling */
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            text-align: center;
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .container {
                padding: 15px;
            }

            h3 {
                font-size: 1.3rem;
            }

            input, select, button {
                padding: 10px;
                font-size: 0.95rem;
            }
        }

        @media (min-width: 768px) {
            body {
                padding: 30px;
            }

            .container {
                padding: 30px;
            }

            h3 {
                font-size: 1.8rem;
                margin-bottom: 30px;
            }

            button {
                padding: 12px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>✏️ Edit Barang</h3>

        <form action="update.php" method="POST">
            <input type="hidden" name="id" value="<?= $barang['id_barang'] ?>">

            <input type="text" name="nama" value="<?= htmlspecialchars($barang['nama_barang']) ?>" placeholder="Nama Barang" required>

            <input type="number" name="jumlah" value="<?= $barang['jumlah'] ?>" placeholder="Jumlah Barang" required>

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