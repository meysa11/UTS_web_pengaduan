<?php 
session_start();

// Hapus semua variabel session
$_SESSION = [];
session_unset();
session_destroy();

// Tampilkan alert 
echo "<script>
    alert('Kamu sudah logout!');
    document.location.href = 'index.php';
</script>";
exit;
?>