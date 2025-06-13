<?php
include '../../connect.php';
session_start();

// Cek apakah pengguna telah login dan memiliki peran admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header(header: "location: dashboard.php");
    exit;
}


$sql_game = "SELECT * FROM tb_game";
$result_game = mysqli_query($conn, $sql_game);
$row_game = mysqli_fetch_array($result_game);

if (!$result_game) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/CRUD.css">
    <title>Admin Dashboard</title>
</head>

<body>
    <div class="header">
        <h2>Admin Dashboard</h2>
        <div class="nav">
            <a href="../../logout.php" class="link">Logout</a>
            <a href="../user/CRUD_user.php" class="link">daftar user</a>
        </div>
    </div>
    <table>
        <a href="tambah.php">tambah </a>
        <h3 class="table-header">daftar game</h3>
        <tr>
            <th>ID</th>
            <th>nama game</th>
            <th>jumlah poin</th>
            <th>deskripsi</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result_game)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id_game']); ?></td>
                <td><?php echo htmlspecialchars($row['nama_game']); ?></td>
                <td><?php echo htmlspecialchars($row['jumlah_poin']); ?></td>
                <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                <td>
                    <a href="kelola.php?id=<?php echo $row['id_game'] ?>" class="edit-btn">Edit</a>
                    <a href="hapus.php?id=<?php echo $row['id_game'] ?>" ;
                        onclick="return confirm('anda yakin ingin membatalkan?')" class="delete-btn">hapus</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>