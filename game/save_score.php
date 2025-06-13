<?php
session_start();
include "../connect.php";

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $score = isset($_POST['score']) ? intval($_POST['score']) : 0;

    // Get current points
    $sql_select = "SELECT poin FROM tb_user WHERE user_id = ?";
    $stmt_select = $conn->prepare($sql_select);
    if ($stmt_select) {
        $stmt_select->bind_param("i", $user_id);
        $stmt_select->execute();
        $stmt_select->bind_result($current_points);
        $stmt_select->fetch();
        $stmt_select->close();

        $new_points = $current_points + $score;

        // Update the poin column in tb_user table with sum of old and new points
        $sql_update = "UPDATE tb_user SET poin = ? WHERE user_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        if ($stmt_update) {
            $stmt_update->bind_param("ii", $new_points, $user_id);
            if ($stmt_update->execute()) {
                echo json_encode(['success' => true, 'new_points' => $new_points]);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to update score']);
            }
            $stmt_update->close();
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to prepare update statement']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to prepare select statement']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request method']);
}
?>
