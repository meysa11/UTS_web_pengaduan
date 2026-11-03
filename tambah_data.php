<?php
session_start();
if (!isset($_SESSION['session_login'])) {
    header("Location: login.php");
    exit;
}

require "function.php";

if(isset($_POST['submit'])){
    if(tambah_data($_POST) > 0){
        echo "<script>
         alert('Data berhasil ditambahkan');
         document.location.href = 'admin.php';
     </script>";
    } else {
        echo "<script>
        alert('Data gagal ditambahkan');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Pengaduan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-form">

<div class="container">
    <div class="form-card">
        <h3>Tambah Data Pengaduan</h3>

        <form action="" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="nomor_pengaduan">Nomor Pengaduan</label>
                <input type="text" name="nomor_pengaduan" placeholder="Masukkan nomor pengaduan" required>
            </div>

            <div class="form-group">
                <label for="nama_pelapor">Nama Pelapor</label>
                <input type="text" name="nama_pelapor" placeholder="Masukkan nama pelapor" required>
            </div>

            <!-- Bagian Kategori Diganti Menjadi Dropdown / Option -->
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
                <textarea name="isi_laporan" rows="4" placeholder="Masukkan isi laporan" required></textarea>
            </div>

            <div class="form-group">
                <label for="gambar">Gambar Bukti</label>
                <input type="file" name="gambar" required>
            </div>

            <div class="button-group">
                <button type="submit" name="submit" class="btn btn-tambah"> Tambah Data </button>
                <a href="admin.php" class="btn btn-kembali"> Kembali </a>
            </div>

        </form>
    </div>
</div>

</body>
</html>