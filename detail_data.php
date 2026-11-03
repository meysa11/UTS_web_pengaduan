<?php
session_start();
require 'function.php';

// Cek apakah ada parameter ID di URL
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$pengaduan = query_db("SELECT * FROM pengaduan WHERE id = $id")[0];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Detail Pengaduan - <?= $pengaduan['nomor_pengaduan']; ?></title>

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

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-text mx-3">Pengaduan App</div>
            </a>

            <hr class="sidebar-divider my-0">

            <div class="sidebar-heading mt-3 text-uppercase text-xs font-weight-bold text-gray-500 px-3">
                MENU UTAMA
            </div>
            <li class="nav-item active">
                <a class="nav-link py-2" href="<?= isset($_SESSION['session_login']) ? 'admin.php' : 'index.php'; ?>">
                    <i class="fas fa-fw fa-arrow-left"></i>
                    <span>Kembali ke Halaman Utama</span>
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
                    <span class="navbar-brand font-weight-bold d-none d-md-inline-block">
                        Detail Pengaduan Masyarakat
                    </span>

                    <ul class="navbar-nav ml-auto">
                        <?php if(isset($_SESSION['session_login'])): ?>
                            <li class="nav-item">
                                <span class="nav-link text-white font-weight-bold">Admin: <?= $_SESSION['username']; ?></span>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a href="login.php" class="btn btn-warning btn-sm font-weight-bold my-2">Login Admin</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid d-flex justify-content-center">

                    <!-- Detail Card -->
                    <div class="card shadow mb-4 style-card" style="width: 100%; max-width: 700px;">
                        <div class="card-header py-3 d-flex align-items-center bg-white border-bottom">
                            <i class="fas fa-info-circle mr-2 text-info"></i>
                            <h6 class="m-0 font-weight-bold text-gray-800">Rincian LaporanPengaduan</h6>
                        </div>
                        <div class="card-body">

                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold text-gray-700" style="width: 35%;">Nomor Pengaduan</td>
                                    <td>: <span class="font-weight-bold text-primary"><?= $pengaduan['nomor_pengaduan']; ?></span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-gray-700">Nama Pelapor</td>
                                    <td>: <?= $pengaduan['nama_pelapor']; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-gray-700">Kategori</td>
                                    <td>: <span class="badge badge-secondary px-2 py-1"><?= $pengaduan['kategori']; ?></span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-gray-700 align-top">Isi Laporan</td>
                                    <td>: <?= nl2br($pengaduan['isi_laporan']); ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-gray-700 align-top">Bukti Foto</td>
                                    <td>
                                        <div class="mt-1">
                                            <img src="img/<?= $pengaduan['bukti_foto']; ?>" alt="Bukti Foto" class="img-fluid rounded border shadow-sm" style="max-height: 300px;">
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <hr>

                            <!-- Tombol Aksi Bawah -->
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <?php if(isset($_SESSION['session_login'])): ?>
                                    <!-- Tombol Edit hanya muncul untuk Admin -->
                                    <a href="edit_data.php?id=<?= $pengaduan['id']; ?>" class="btn btn-warning text-white font-weight-bold mr-2">
                                        <i class="fas fa-edit mr-1"></i> Edit Data Ini
                                    </a>
                                    <a href="admin.php" class="btn btn-secondary font-weight-bold">
                                        Kembali ke Dashboard
                                    </a>
                                <?php else: ?>
                                    <a href="index.php" class="btn btn-warning text-white font-weight-bold">
                                        Kembali ke Beranda
                                    </a>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white py-3 border-top">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Web Pengaduan Masyarakat &copy; 2026</span>
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