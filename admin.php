<?php
session_start();
// Proteksi Halaman: Wajib Login
if (!isset($_SESSION['session_login'])) {
    header("Location: login.php");
    exit;
}

require 'function.php';

// Pengaturan Pagination
$jumlahDataPerHalaman = 5;

if (isset($_POST["cari"])) {
    $keyword = $_POST["keyword"];
    $pengaduan = cari_data($keyword);
    $jumlahHalaman = 1;
    $halamanAktif = 1;
    $awalData = 0; 
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
    <title>Dashboard Pengelola - Pengaduan Masyarakat</title>

    <!-- Font Awesome Icons & Google Font -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Bootstrap 4 / SB Admin 2 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        /* Penyesuaian Warna Hijau Tua Gelap Seperti di Gambar Referensi */
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

        <!-- Sidebar Kiri (Dark Green Sidebar) -->
        <ul class="navbar-nav sidebar-dark-green sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin.php">
                <div class="sidebar-brand-text mx-3">Pengaduan Home</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <div class="sidebar-heading mt-3 text-uppercase text-xs font-weight-bold text-gray-500 px-3">
                Menu Utama
            </div>
            <li class="nav-item active">
                <a class="nav-link py-2" href="admin.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <div class="sidebar-heading text-uppercase text-xs font-weight-bold text-gray-500 px-3">
                Data Pengaduan
            </div>
            <li class="nav-item">
                <a class="nav-link py-2" href="admin.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Kelola Pengaduan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-2 text-danger" href="logout.php">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column bg-light">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar Hijau Gelap Sesuai Gambar -->
                <nav class="navbar navbar-expand navbar-dark bg-dark-green topbar mb-4 static-top shadow">

                    <!-- Navbar Brand Text di Kiri Topbar -->
                    <span class="navbar-brand font-weight-bold d-none d-md-inline-block">
                        Pengaduan Masyarakat
                    </span>

                    <!-- Topbar Search Box -->
                    <form action="" method="post" class="d-none d-sm-inline-block form-inline ml-auto mr-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" name="cari">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar / Profile Info -->
                    <ul class="navbar-nav ml-auto ml-md-0">
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                                <span class="mr-2 d-none d-lg-inline text-white small text-capitalize">
                                    <?= $_SESSION['username']; ?>
                                </span>
                                <i class="fas fa-user-circle fa-lg text-white"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                                <a class="dropdown-item text-danger" href="logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Dashboard Pengelola</h1>
                    <p class="mb-4 text-muted small">Dashboard</p>

                    <!-- DataTales Card (Sesuai Tampilan Gambar Referensi) -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex align-items-center">
                            <i class="fas fa-table mr-2 text-gray-600"></i>
                            <h6 class="m-0 font-weight-bold text-gray-800">Kelola Data Pengaduan Masyarakat</h6>
                        </div>
                        <div class="card-body">

                            <!-- Tombol + Tambah Data -->
                            <div class="mb-3">
                                <a href="tambah_data.php" class="btn btn-primary font-weight-bold">
                                    + Tambah Data
                                </a>
                            </div>

                            <!-- Table Area -->
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>No. Pengaduan</th>
                                            <th>Nama Pelapor</th>
                                            <th>Kategori</th>
                                            <th>Isi Laporan</th>
                                            <th>Gambar</th>
                                            <th style="width: 170px;">Aksi</th>
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
                                            <td style="white-space: nowrap;">
                                                <a href="detail_data.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-info font-weight-bold">Detail</a>
                                                <a href="edit_data.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-warning text-white font-weight-bold">Edit</a>
                                                <a href="hapus_data.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-danger font-weight-bold" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
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
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white py-3 border-top">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Logged in as: <strong><?= $_SESSION['username']; ?></strong> | Web Pengaduan Masyarakat</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap & JS CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/js/sb-admin-2.min.js"></script>

</body>
</html>