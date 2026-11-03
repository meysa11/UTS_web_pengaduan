<?php
session_start();
if (!isset($_SESSION['session_login'])) {
    header("Location: login.php");
    exit;
}

require 'function.php';

// Jumlah data yang ditampilkan per halaman
$jumlahDataPerHalaman = 3;

// Jumlah seluruh data
$jumlahData = count(query_db("SELECT * FROM pengaduan"));

// Hitung jumlah halaman
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

// Halaman aktif
$halamanAktif = isset($_GET["halaman"]) ? (int) $_GET["halaman"] : 1;

// Menentukan awal data
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

// Ambil data pengaduan berdasarkan pagination
$pengaduan = query_db("SELECT * FROM pengaduan LIMIT $awalData, $jumlahDataPerHalaman");

if(isset($_POST["cari"])){
    $keyword = $_POST["keyword"];
    $pengaduan = cari_data($keyword);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin Pengaduan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-index">
    
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Dashboard Admin Pengaduan</h3>
        <a href="logout.php" class="btn btn-hapus">Logout (<?= $_SESSION['username']; ?>)</a>
    </div>

    <div class="top-bar">
        <!-- Searching -->
        <form action="" method="post" class="search-box">
            <input type="text" name="keyword" placeholder="Cari pengaduan...">
            <button type="submit" name="cari" class="btn btn-cari">Cari</button>
        </form>

        <!-- Tambah Data -->
        <a href="tambah_data.php" class="btn btn-tambah">+ Tambah Data</a>
    </div>

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
                <th>Aksi</th>
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
                <td 
                    style="white-space: nowrap;">
                    <a href="edit_data.php?id=<?= $data['id'] ?>" class="btn btn-edit">Edit</a>
                    <a href="hapus_data.php?id=<?= $data['id'] ?>" class="btn btn-hapus" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
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