<?php
include "../../connect.php";
session_start();

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM tb_game WHERE id_game = '$id'");
echo "<script>alert('Data berhasil dihapus');</script>";
header("Location: CRUD_game.php");

?>