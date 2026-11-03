<?php 
require 'function.php';

if(isset($_POST["register"])){
    
    if(registrasi($_POST) > 0){
        echo "<script>
                alert('User baru berhasil ditambahkan!');
                document.location.href = 'login.php';
             </script>";
    } else {
        echo mysqli_error($conn);
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-register">

    <div class="container">
        <div class="form-card">
            <h3 style="text-align: center;"> Registrasi </h3>

            <form action="" method="post">
                <!-- Username -->
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" placeholder="Masukkan username" required>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password"> Password </label>
                    <input type="password" name="password" placeholder="Masukkan password" required>
                </div>

                <!-- Konfirmasi Password -->
                <div class="form-group">
                    <label for="konfirmasi_password"> Konfirmasi Password </label>
                    <input type="password" name="konfirmasi_password" placeholder="Masukkan kembali password" required>
                </div>

                <!-- Button -->
                <div class="button-group">
                    <button type="submit" name="register" class="btn btn-edit"> Registrasi </button>
                    <a href="login.php" class="btn btn-kembali"> Login </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>