<?php
include "../../connect.php";


if (isset($_POST["submit"])) {

    $nama_game = $_POST["nama_game"];
    $jumlah_poin = $_POST["jumlah_poin"];
    $deskripsi = $_POST["deskripsi"];

    // Siapkan query untuk memasukkan data
    $sql = "INSERT INTO tb_game (nama_game, jumlah_poin, deskripsi) VALUES ('$nama_game', '$jumlah_poin', '$deskripsi')";

    // Eksekusi query
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Game berhasil ditambahkan!'); window.location.href = 'CRUD_game.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/tambah.css">
</head>

<body>
    <form action="" method="POST">
        <div class="form">
            <header class="login-header">Tambah Game Baru</header>
            <div class="input-box">
                <input type="text" name="nama_game" class="input-field" placeholder="masukan nama game"
                    autocomplete="off" required>
            </div>
            <div class="input-box">
                <input type="text" name="jumlah_poin" class="input-field" placeholder="masukan jumlah poin"
                    autocomplete="off" required>
            </div>
            <div class="input-box">
                <input type="text" name="deskripsi" class="input-field" placeholder="deskripsi" autocomplete="off"
                    required>
            </div>
            <div class="input-submit">
                <input type="submit" name="submit" value="submit" placeholder="submit" class="submit-btn">
            </div>
        </div>
    </form>
</body>

</html>