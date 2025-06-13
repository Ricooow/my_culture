<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "db_ukl";

    $conn = new mysqli ($host, $user, $pass, $db);

    if (mysqli_connect_error()) {
        die("koneksi gagal: " . mysqli_connect_error());
    }

?>