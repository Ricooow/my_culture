<?php
include "../../connect.php";
session_start();

if (isset($_POST['simpan'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($password == '') {
        // If no password is provided, keep the old password
        $query = "SELECT password FROM tb_user WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $password = $row['password'];
    } else {
        // Hash password if provided
        $password = password_hash($password, PASSWORD_DEFAULT);
    }

    // Update data
    $sql = "UPDATE tb_user SET username='$username', email='$email', password='$password', role='$role' WHERE user_id='$user_id'";
    // var_dump($sql);
    // die();

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data berhasil disimpan'); window.location.href = 'CRUD_game.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>