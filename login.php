<?php

session_start();

include "connect.php"; // Pastikan koneksi database sudah benar

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Cek username di database
    $query = "SELECT * FROM tb_user WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row["password"])) {
            
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["role"] = $row["role"]; 


            if ($row["role"] == "admin") {
                header("Location: CRUD/user/CRUD_user.php");
                exit();
            } else {
                header("Location: dashboard.php");
                exit();
            }
        } else {
            echo "<script>alert('Password salah!');</script>";
        }
    } else {
        echo "<script>alert('Username tidak terdaftar!');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/pendaftaran.css">
</head>
<body>
    <main>
        <video id="bg-vid" poster="image/poster.png" autoplay mute loop>
            <source src="image/background.mp4" type="video/mp4">
        </video>
        <div class="wrapper">
            <form action="login.php" method="POST">
                <div class="login-box">
                    <div class="login-header">
                        <header>Login</header>
                    </div>
                    <div class="input-box">
                        <input type="text" name="username" class="input-field" placeholder="username" autocomplete="off" required>
                        </div>
                    <div class="input-box">
                        <input type="password" name="password" class="input-field" placeholder="password" autocomplete="off" required>
                    </div>
                    <div class="input-submit">
                        <a href="register.php">dont have account ?</a>
                    </div>
                    <div class="submit-btn">
                        <input type="submit" name="login"placeholder="submit" class="submit-btn">
                    </div>
                </div>
            </form>
        </div>
    </main>
</body>
</html>