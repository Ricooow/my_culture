<?php
session_start();
include "../../connect.php";

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM tb_user WHERE user_id = '$id'");
echo "<script>alert('Data berhasil dihapus');</script>";
header("Location: CRUD_user.php");

?>