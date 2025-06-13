<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    include "../connect.php";

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'User not logged in']);
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $reward_id = isset($_POST['reward_id']) ? intval($_POST['reward_id']) : 0;

    // memastikan apakah poin cukup?
    $sql_check = "SELECT poin FROM tb_user WHERE user_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $user_id);
    $stmt_check->execute();
    $stmt_check->bind_result($current_points);
    $stmt_check->fetch();
    $stmt_check->close();

    // mengambil harga hadiah
    $sql_reward = "SELECT harga_hadiah FROM tb_hadiah WHERE reward_id = ?";
    $stmt_reward = $conn->prepare($sql_reward);
    $stmt_reward->bind_param("i", $reward_id);
    $stmt_reward->execute();
    $stmt_reward->bind_result($reward_price);
    $stmt_reward->fetch();
    $stmt_reward->close();

    if ($current_points >= $reward_price) {
        // pengurangan poin
        $new_points = $current_points - $reward_price;
        $sql_update = "UPDATE tb_user SET poin = ? WHERE user_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ii", $new_points, $user_id);

        if ($stmt_update->execute()) {
            $stmt_update->close();

            //query untuk memasukkan data penukaran
            $sql_insert = "INSERT INTO tb_penukaran (reward_id, poin_used, user_id) VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("iii", $reward_id, $reward_price, $user_id);
            $stmt_insert->execute();
            $stmt_insert->close();

            echo "<script>alert('Points successfully updated and reward redeemed.'); window.location.href = '../penukaran/';</script>";
        } else {
            echo "<script>alert('Failed to update points.'); window.location.href = '../penukaran/';</script>";
        }
    } else {
        echo "<script>alert('Not enough points.'); window.location.href = '../penukaran/';</script>";
    }
} else {
    echo "<script>Invalid request method.'); window.location.href = '../penukaran/';</script>";
}

?>