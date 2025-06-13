<?php
include "../../connect.php";
session_start();

if (!isset($_GET['id'])) {
    header("Location: CRUD_user.php");
    exit();
}

$id = $_GET["id"];
$sql = "SELECT * FROM tb_user WHERE user_id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
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
    <a href="../user/CRUD_user.php">Kembali</a>
    <h1>Edit User</h1>
    <form action="proses.php" method="POST">
        <input type="text" name="user_id" value="<?= $row['user_id'] ?>">
        <input type="text" name="username" id="username" placeholder="username" value="<?= $row['username'] ?>"
            required>
        <input type="email" name="email" id="email" placeholder="email" value="<?= $row['email'] ?>" required>
        <input type="text" name="password" id="password" placeholder="password (leave blank to keep current password)"
            value="">
        <select name="role" id="role" required>
            <option value="user" <?php if ($row['role'] == 'user')
                echo 'Selected'; ?>>User</option>
            <option value="admin" <?php if ($row['role'] == 'admin')
                echo 'Selected'; ?>>Admin</option>
        </select>
        <button type="submit" name="simpan">Ubah Data</button>
    </form>
</body>
    
</html>