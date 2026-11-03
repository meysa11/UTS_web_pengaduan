<?php 

// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "db_pengaduan");

function query_db($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}
	return $rows;
}

function tambah_data($data){
	global $conn;

	$nomor_pengaduan = htmlspecialchars($data['nomor_pengaduan']);
	$nama_pelapor = htmlspecialchars($data['nama_pelapor']);
	$kategori = htmlspecialchars($data['kategori']);
	$isi_laporan = htmlspecialchars($data['isi_laporan']);

	// upload gambar
	$gambar = upload_gambar($nomor_pengaduan, $nama_pelapor);
	if( !$gambar ){
		return false;
	}

	$query = "INSERT INTO pengaduan (nomor_pengaduan, nama_pelapor, kategori, isi_laporan, bukti_foto)
              VALUES ('$nomor_pengaduan', '$nama_pelapor', '$kategori', '$isi_laporan', '$gambar')";

	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

function hapus_data($id){
	global $conn;

	$query = "DELETE FROM pengaduan WHERE id = $id";

	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

function edit_data($data){
	global $conn;

	$id = $data["id"];
	$nomor_pengaduan = htmlspecialchars($data['nomor_pengaduan']);
	$nama_pelapor = htmlspecialchars($data['nama_pelapor']);
	$kategori = htmlspecialchars($data['kategori']);
	$isi_laporan = htmlspecialchars($data['isi_laporan']);
	$gambarLama = htmlspecialchars($data['gambarLama']);

	// Cek apakah user pilih gambar baru atau tidak
	if( $_FILES['gambar']['error'] === 4 ) {
		$gambar = $gambarLama;
	} else {
		$gambar = upload_gambar($nomor_pengaduan, $nama_pelapor);
	}

	if( !$gambar ){
		return false;
	}

	$query = "UPDATE pengaduan SET
			 nomor_pengaduan = '$nomor_pengaduan',
			 nama_pelapor = '$nama_pelapor',
			 kategori = '$kategori',
			 isi_laporan = '$isi_laporan',
			 bukti_foto = '$gambar'
			 WHERE id = $id";

	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

// SEARCH
function cari_data($keyword) {
	global $conn;

	$keyword = mysqli_real_escape_string($conn, $keyword);

	$query = "SELECT * FROM pengaduan
			  WHERE
			  nomor_pengaduan LIKE '%$keyword%' OR
			  nama_pelapor LIKE '%$keyword%' OR
			  kategori LIKE '%$keyword%' OR
			  isi_laporan LIKE '%$keyword%'";

	return query_db($query);
}

// fungsi untuk upload gambar
function upload_gambar($nomor_pengaduan, $nama_pelapor){

	// setting file
	$namaFile = $_FILES['gambar']['name'];
	$ukuranFile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];

	// cek apakah ada file yang diupload atau tidak oleh si user saat mengisi form
	if( $error === 4 ){
		echo "<script>
			alert('Kamu belum upload file, silakan upload file terlebih dahulu!');
			</script>";
		return false;
	}

	// cek lagi, apakah yang diupload oleh user itu file nya berupa gambar atau bukan
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if( !in_array($ekstensiGambar, $ekstensiGambarValid) ){
		echo "<script>
			alert('File yang kamu upload itu bukan jpg/jpeg/png!');
			</script>";
		return false;
	}

	// bikin aturan terkait ukuran file (maks --> 5MB)
	if( $ukuranFile > 5000000 ){
		echo "<script>
			alert('File yang kamu upload terlalu besar ukurannya!');
			</script>";
		return false;
	}

	// buat nama file baru
	$namaFileBaru = preg_replace('/[^A-Za-z0-9\-]/', '', $nomor_pengaduan . "_" . $nama_pelapor);
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;

	move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

	return $namaFileBaru;
}

// fungsi untuk registrasi
function registrasi($data){
	global $conn;

	$username = strtolower(stripslashes($data["username"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$konfirmasi_password = mysqli_real_escape_string($conn, $data["konfirmasi_password"]);

	// cek username apabila sudah ada di database atau belum
	$result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

	if(mysqli_fetch_assoc($result)){
		echo "<script>
				alert('Username sudah terdaftar! Gunakan username lainnya!');
			 </script>";
		return false;
	}

	// cek konfirmasi password
	if($password !== $konfirmasi_password ){
		echo "<script>
				alert('Konfirmasi password tidak sesuai!');
			 </script>";
		return false;
	}

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);

	mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");
	return mysqli_affected_rows($conn);
}
?>