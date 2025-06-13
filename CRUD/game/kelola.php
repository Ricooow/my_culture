<?php
include "../../connect.php";
session_start();

if (!isset($_GET['id'])) {
    header("Location: CRUD_game.php");
    exit();
}

$id = $_GET["id"];
$sql = "SELECT * FROM tb_game WHERE id_game = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_array($result);

?>

<?php

if (isset($_POST['simpan'])) {
    $nama_game = $_POST['nama_game'];
    $poin = $_POST['poin'];
    $deskripsi = $_POST['deskripsi'];
    $id_game = $_POST['id_game'];
    $foto = $_FILES['foto']['name'];

    // Handle file upload
    if (!empty($foto)) {
        $target_file = basename($foto);
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
    } else {
        $target_file = $row['foto'];
    }

    // Use prepared statement for the update
    $sql_update = "UPDATE tb_game SET nama_game=?, jumlah_poin=?, deskripsi=?, foto=? WHERE id_game=?";
    $stmt_update = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "ssssi", $nama_game, $poin, $deskripsi, $target_file, $id_game);

    if (mysqli_stmt_execute($stmt_update)) {
        echo "<script>alert('Data berhasil disimpan'); window.location.href = 'CRUD_game.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_stmt_error($stmt_update) . "');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="">
</head>

<body>
    <section class="big-wrapper">
        <a href="../user/CRUD_user.php">Kembali</a>
        <h1>Edit game</h1>
        <div class="content">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="text" name="nama_game" id="gamename" placeholder="gamename"
                    value="<?= $row['nama_game'] ?>" required>
                <input type="text" name="poin" id="poin" placeholder="email" value="<?= $row['jumlah_poin'] ?>" required>
                <input type="text" name="deskripsi" id="deskripsi" placeholder="deskripsi"
                    value="<?= $row['deskripsi'] ?>" required>
                <input type="file" name="foto" id="foto">
                <input type="hidden" name="id_game" value="<?= $row['id_game'] ?>">
                <button type="submit" name="simpan">Ubah Data</button>
            </form>
        </div>
    </section>
</body>

</html>