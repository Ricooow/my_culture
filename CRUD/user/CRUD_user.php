<?php
include '../../connect.php';
session_start();

// Cek apakah pengguna telah login dan memiliki peran admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header(header: "location: dashboard.php");
    exit;
}


// Ambil daftar pengguna dari database
$sql = "SELECT * FROM tb_user";
$result = mysqli_query($conn, $sql);

if (!$result) {
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
            <a href="../game/CRUD_game.php" class="link">daftar game</a>
        </div>

    </div>
    <table>
        <h3 class="table-header">daftar user</h3>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['role']); ?></td>
                <td>
                    <a href="kelola.php?id=<?php echo $row['user_id'] ?>" class="edit-btn">Edit</a>
                    <a href="hapus.php?id=<?php echo $row['user_id'] ?>" ;
                        onclick="return confirm('anda yakin ingin membatalkan?')" class="delete-btn">hapus</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>