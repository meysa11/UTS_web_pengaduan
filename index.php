<?php
session_start();
require 'function.php';

// Jika admin sudah login, otomatis dialihkan ke dashboard admin
if (isset($_SESSION['session_login'])) {
    header("Location: admin.php");
    exit;
}

// Pengaturan Pagination
$jumlahDataPerHalaman = 5;

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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Portal Pengaduan Masyarakat</title>

    <!-- Font Awesome Icons & Google Font -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Bootstrap 4 / SB Admin 2 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        .bg-dark-green {
            background-color: #195396 !important;
        }
        .sidebar-dark-green {
            background-color: #1b202e !important;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar Kiri -->
        <ul class="navbar-nav sidebar-dark-green sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-text mx-3">Pengaduan App</div>
            </a>

            <hr class="sidebar-divider my-0">

            <div class="sidebar-heading mt-3 text-uppercase text-xs font-weight-bold text-gray-500 px-3">
                MENU UTAMA
            </div>
            <li class="nav-item active">
                <a class="nav-link py-2" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Beranda Publik</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading text-uppercase text-xs font-weight-bold text-gray-500 px-3">
                AKUN ADMIN
            </div>
            <li class="nav-item">
                <a class="nav-link py-2 text-warning" href="login.php">
                    <i class="fas fa-fw fa-sign-in-alt"></i>
                    <span>Login Admin</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-2 text-info" href="registrasi.php">
                    <i class="fas fa-fw fa-user-plus"></i>
                    <span>Registrasi</span>
                </a>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column bg-light">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar Hijau Gelap -->
                <nav class="navbar navbar-expand navbar-dark bg-dark-green topbar mb-4 static-top shadow">

                    <!-- Navbar Brand Text di Kiri -->
                    <span class="navbar-brand font-weight-bold d-none d-md-inline-block">
                        Portal Pengaduan Masyarakat
                    </span>

                    <!-- Topbar Search Box -->
                    <form action="" method="post" class="d-none d-sm-inline-block form-inline ml-auto mr-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control bg-light border-0 small" placeholder="Cari laporan pengaduan..." aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" name="cari">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Tombol Auth di Pojok Kanan Topbar -->
                    <ul class="navbar-nav ml-auto ml-md-0">
                        <li class="nav-item mx-1">
                            <a href="login.php" class="btn btn-warning btn-sm font-weight-bold my-2">Login Admin</a>
                        </li>
                        <li class="nav-item mx-1">
                            <a href="registrasi.php" class="btn btn-outline-light btn-sm font-weight-bold my-2">Registrasi</a>
                        </li>
                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Portal Informasi Pengaduan</h1>
                    <p class="mb-4 text-muted small">Daftar laporan pengaduan masyarakat yang terdaftar secara publik.</p>

                    <!-- Data Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex align-items-center">
                            <i class="fas fa-table mr-2 text-gray-600"></i>
                            <h6 class="m-0 font-weight-bold text-gray-800">Daftar Pengaduan Masyarakat</h6>
                        </div>
                        <div class="card-body">

                            <!-- Table Area (Tanpa Tombol Tambah, Edit, Hapus) -->
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>No. Pengaduan</th>
                                            <th>Nama Pelapor</th>
                                            <th>Kategori</th>
                                            <th>Isi Laporan</th>
                                            <th>Gambar</th>
                                            <th style="width: 90px;" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $nomor = $awalData + 1; ?>
                                        <?php if(empty($pengaduan)): ?>
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">Belum ada data pengaduan.</td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php foreach($pengaduan as $data): ?>
                                        <tr>
                                            <td><?= $nomor; ?></td>
                                            <td class="font-weight-bold"><?= $data["nomor_pengaduan"]; ?></td>
                                            <td><?= $data["nama_pelapor"]; ?></td>
                                            <td><span class="badge badge-secondary px-2 py-1"><?= $data["kategori"]; ?></span></td>
                                            <td><?= $data["isi_laporan"]; ?></td>
                                            <td class="text-center">
                                                <img src="img/<?= $data['bukti_foto']; ?>" width="70" height="70" style="object-fit: cover;" class="rounded border">
                                            </td>
                                            <td class="text-center">
                                                <!-- Hanya Tombol Detail yang Tampil untuk Publik -->
                                                <a href="detail_data.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-info font-weight-bold">Detail</a>
                                            </td>
                                        </tr>
                                        <?php $nomor++; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination Bottom -->
                            <div class="d-flex justify-content-end mt-3">
                                <nav>
                                    <ul class="pagination pagination-sm m-0">
                                        <?php if($halamanAktif > 1): ?>
                                            <li class="page-item"><a class="page-link" href="?halaman=<?= $halamanAktif - 1; ?>">&laquo; Prev</a></li>
                                        <?php else: ?>
                                            <li class="page-item disabled"><span class="page-link">&laquo; Prev</span></li>
                                        <?php endif; ?>

                                        <?php for($i = 1; $i <= $jumlahHalaman; $i++): ?>
                                            <?php if($i == $halamanAktif): ?>
                                                <li class="page-item active"><a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
                                            <?php else: ?>
                                                <li class="page-item"><a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
                                            <?php endif; ?>
                                        <?php endfor; ?>

                                        <?php if($halamanAktif < $jumlahHalaman): ?>
                                            <li class="page-item"><a class="page-link" href="?halaman=<?= $halamanAktif + 1; ?>">Next &raquo;</a></li>
                                        <?php else: ?>
                                            <li class="page-item disabled"><span class="page-link">Next &raquo;</span></li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white py-3 border-top">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Portal Publik Pengaduan Masyarakat &copy; 2026</span>
                    </div>
                </div>
            </footer>

        </div>
    </div>

    <!-- Bootstrap & JS CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/js/sb-admin-2.min.js"></script>

</body>
</html>