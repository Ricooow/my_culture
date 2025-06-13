<?php
    include "connect.php";
    

    if(isset($_POST["register"])){

    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    
    $query_sql = "INSERT INTO tb_user (email, username, password)
                  VALUES ('$email' , '$username', '$password')";
    
    if(mysqli_query($conn, $query_sql))
        header("location: login.php");
    else {
        echo "pendaftaran gagal : " . mysqli_error($conn);
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
            <div class="login-box">
                <form action="" method="POST">
                    <div class="login-header">
                        <header>Register</header>
                    </div>
                        <div class="input-box">
                            <input type="email" name="email" class="input-field" placeholder="email" autocomplete="off" required>
                        </div>
                        <div class="input-box">
                            <input type="text" name="username" class="input-field" placeholder="username" autocomplete="off" required>
                        </div>
                        <div class="input-box">
                            <input type="password" name="password" class="input-field" placeholder="password" autocomplete="off" required>
                        </div>
                        <div class="input-submit">

                        </div>
                        <div class="submit-btn">
                        <a href="login.html">
                            <input type="submit" name="register" placeholder="submit" class="submit-btn">
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>