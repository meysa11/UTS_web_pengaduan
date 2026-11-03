<?php
session_start();
if (!isset($_SESSION['session_login'])) {
    header("Location: login.php");
    exit;
}

require 'function.php';

$id = $_GET["id"];

$pengaduan = query_db("SELECT * FROM pengaduan WHERE id = $id")[0];

if (isset($_POST["submit"])){
    if (edit_data($_POST) > 0) {
        echo "<script>
            alert('Data berhasil diubah');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal diubah atau tidak ada perubahan');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pengaduan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-form">

<div class="container">
    <div class="form-card">
        <h3>Edit Data Pengaduan</h3>

        <form action="" method="post" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $pengaduan['id']; ?>">
            <input type="hidden" name="gambarLama" value="<?= $pengaduan['bukti_foto']; ?>">

            <div class="form-group">
                <label for="nomor_pengaduan">Nomor Pengaduan</label>
                <input type="text" name="nomor_pengaduan" value="<?= $pengaduan["nomor_pengaduan"]; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="nama_pelapor">Nama Pelapor</label>
                <input type="text" name="nama_pelapor" value="<?= $pengaduan["nama_pelapor"]; ?>" required>
            </div>

            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select name="kategori" id="kategori" required style="width: 100%; padding: 10px 12px; border: 1px solid #d7dce5; border-radius: 6px; font-size: 14px; outline: none; background-color: white;">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Fasilitas">Fasilitas</option>
                    <option value="Keamanan">Keamanan</option>
                    <option value="Pelayanan">Pelayanan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="isi_laporan">Isi Laporan</label>
                <textarea name="isi_laporan" rows="4" required><?= $pengaduan["isi_laporan"]; ?></textarea>
            </div>

            <div class="form-group">
                <label for="gambar">Gambar Bukti</label>
                <input type="file" name="gambar">
                <br><br>
                <img src="img/<?= $pengaduan["bukti_foto"]; ?>" width="200" height="200">
            </div>

            <div class="button-group">
                <button type="submit" name="submit" class="btn btn-edit"> Edit data </button>
                <a href="index.php" class="btn btn-kembali"> Kembali </a>
            </div>

        </form>
    </div>
</div>

</body>
</html>