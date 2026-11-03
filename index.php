<?php
session_start();
require 'function.php';

// Jika admin sudah login, otomatis masuk ke dashboard admin
if (isset($_SESSION['session_login'])) {
    header("Location: admin.php");
    exit;
}

// Pagination setup
$jumlahDataPerHalaman = 3;

if (isset($_POST["cari"])) {
    $keyword = $_POST["keyword"];
    $pengaduan = cari_data($keyword);
    $jumlahHalaman = 1;
    $halamanAktif = 1;
} else {
    $jumlahData = count(query_db("SELECT * FROM pengaduan"));
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
    $halamanAktif = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
    $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

    $pengaduan = query_db("SELECT * FROM pengaduan LIMIT $awalData, $jumlahDataPerHalaman");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Pengaduan Masyarakat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-index">
    
<div class="container">
    <!-- Header Halaman Pertama -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #eef3ff; padding-bottom: 15px;">
        <h3 style="margin: 0; color: #333;">Portal Pengaduan Masyarakat</h3>
        <div>
            <a href="login.php" class="btn btn-edit" style="margin-right: 5px;">Login Admin</a>
            <a href="registrasi.php" class="btn btn-tambah">Registrasi</a>
        </div>
    </div>

    <div class="top-bar">
        <!-- Searching -->
        <form action="" method="post" class="search-box">
            <input type="text" name="keyword" placeholder="Cari pengaduan...">
            <button type="submit" name="cari" class="btn btn-cari">Cari</button>
        </form>
    </div>

    <!-- Tabel Tampilan Umum -->
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>ID</th>
                <th>No. Pengaduan</th>
                <th>Nama Pelapor</th>
                <th>Kategori</th>
                <th>Isi Laporan</th>
                <th>Gambar</th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 1; ?>
            <?php foreach($pengaduan as $data): ?>
            <tr>
                <td><?= $nomor; ?></td>
                <td><?= $data["id"]; ?></td>
                <td><?= $data["nomor_pengaduan"]; ?></td>
                <td><?= $data["nama_pelapor"]; ?></td>
                <td><?= $data["kategori"]; ?></td>
                <td><?= $data["isi_laporan"]; ?></td>
                <td>
                    <img src="img/<?= $data['bukti_foto']; ?>" width="90" height="90">
                </td>
            </tr>
            <?php $nomor++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br><br>

    <!-- PAGINATION -->
    <div class="pagination-wrapper">
        <div class="pagination">
        <?php if($halamanAktif > 1): ?>
            <a href="?halaman=<?= $halamanAktif - 1; ?>" class="prev">&larr; Prev</a>
        <?php else: ?>
            <span class="pagination-disabled">&larr; Prev</span>
        <?php endif; ?>

        <?php for($i = 1; $i <= $jumlahHalaman; $i++): ?>
            <?php if($i == $halamanAktif): ?>
                <a href="?halaman=<?= $i; ?>" class="active"><?= $i; ?></a>
            <?php else: ?>
                <a href="?halaman=<?= $i; ?>"><?= $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if($halamanAktif < $jumlahHalaman): ?>
            <a href="?halaman=<?= $halamanAktif + 1; ?>" class="next">Next &rarr;</a>
        <?php else: ?>
            <span class="pagination-disabled">Next &rarr;</span>
        <?php endif; ?>
        </div>
    </div>

</div>
</body>
</html>