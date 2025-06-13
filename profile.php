<?php
session_start();
include "connect.php";
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $stmt = $conn->prepare("SELECT * FROM tb_user WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        // Handle case where user is not found
        header("Location: ../login.php");
        exit();
    }
} else {
    // Redirect to login if user_id is not set
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/profile.css">
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
    <section class="big-wrapper">
        <a href="dashboard.php" class="activity-back-btn">
            <i class="bi bi-chevron-left"></i>
        </a>
        <div class="content">
            <form action="" method="POST">
                <h2>Update Profile</h2>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username"
                    value="<?php echo htmlspecialchars($row['username']); ?>" required class="input-field">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>"
                    required class="input-field">

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="" required class="input-field"
                    placeholder="Leave blank to keep current password">

                <button type="submit" name="update">Update</button>
            </form>
            <?php
            if (isset($_POST['update'])) {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                // Update user profile in the database
                $stmt = $conn->prepare("UPDATE tb_user SET username = ?, email = ?, password = ? WHERE user_id = ?");
                $stmt->bind_param("sssi", $username, $email, password_hash($password, PASSWORD_DEFAULT), $user_id);
                if ($stmt->execute()) {
                    echo "<p>Profile updated successfully!</p>";
                    header("Location: dashboard.php"); // Redirect to the same page to see changes
                } else {
                    echo "<p>Error updating profile: " . mysqli_error($conn) . "</p>";
                    header("Location: dashboard.php");
                }
            }
            ?>
        </div>
    </section>
</body>
</html>