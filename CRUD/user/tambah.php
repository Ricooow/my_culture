<?php
include "../../connect.php";


if (!isset($_GET['id'])) {
    header("Location: CRUD_user.php");
    exit();
}

$id = $_GET["id"];

$sql = "SELECT * FROM tb_game WHERE id_game = '$id'";
$result = mysqli_query($conn, $sql);




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/tambah.css">
</head>

<body>
    <form action="" method="POST" enctype="multipart/form-data" class="form">
        <header class="login-header">Tambah user baru</header>
        <div class="input-box">
            <input type="text" name="nama_game" class="input-field" placeholder="masukan nama game" autocomplete="off"
                required>
        </div>
        <div class="input-box">
            <input type="text" name="jumlah_poin" class="input-field" placeholder="masukan jumlah poin"
                autocomplete="off" required>
        </div>
        <div class="input-box">
            <input type="file" name="foto" class="input-field" placeholder="masukan foto" autocomplete="off" required>
        </div>
        <div class="input-submit">
            <input type="submit" name="submit" value="submit" placeholder="submit" class="submit-btn">
        </div>
    </form>
</body>

</html>