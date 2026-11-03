<?php 
session_start();

require 'function.php';

if(isset($_SESSION['session_login'])){
    header('Location: admin.php');
    exit;
}

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' ");

    // cek username
    if(mysqli_num_rows($result) === 1){

        // cek password
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row['password'])){
            // set session
            $_SESSION['session_login'] = true;
            $_SESSION['username'] = $username;

            header('Location: index.php');
            exit;
        } else {
            echo "<script>
                alert('Password yang kamu masukkan salah!');
                </script>";  
        }
    } else {
        echo "<script>
            alert('Username yang kamu masukkan salah atau tidak ditemukan!');
            </script>";
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-register">

    <div class="container">
        <div class="form-card">
            <h3 style="text-align: center;"> Login </h3>

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

                <!-- Button -->
                <div class="button-group">
                    <button type="submit" name="login" class="btn btn-edit"> Login </button>
                    <a href="registrasi.php" class="btn btn-kembali"> Registrasi </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>