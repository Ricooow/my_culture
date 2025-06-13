<?php
session_start();
include "../connect.php";
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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Game Dashboard</title>
    <link rel="stylesheet" href="../css/game_dashboard.css" />
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
    <main>
        <video id="bg-vid" poster="../image/poster.png" autoplay muted loop>
            <source src="../image/background.mp4" type="video/mp4" />
        </video>
        <div class="big-wrapper">
            <header>
                <div class="container">
                    <div class="logo">
                        <a href="#">
                            <img src="../image/logo.png" alt="logo" />
                        </a>
                        <h3>My Culture</h3>
                    </div>
                </div>
                <nav class="profile">
                    <img src="<?php echo htmlspecialchars($row['photo_profile']); ?>" alt="<?php echo htmlspecialchars($row['photo_profile']); ?>" height="25px" class="foto-profile" />
                    <h1><a href="../profile.php"><?php echo htmlspecialchars($_SESSION['username']); ?></a></h1>
                    <div class="poin-container">
                        <i class='bx bx-trophy'></i>    
                        <p><?php echo htmlspecialchars($row['poin']); ?></p>
                    </div>
                </nav>
            </header>

            <section class="text">
                <div class="heading-text">
                    <h2>
                        Selamat datang <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </h2>
                    <p>
                        JAWAB QUIZZ, DAPATKAN POIN DAN TUKARKAN DENGAN <span>HADIAH MENARIK</span>
                    </p>
                </div>
            </section>
            <section>
                <div class="menu">
                    <p class="heading-menu">Temukan hal menarik</p>
                    <div class="activity-back">
                        <a href="../dashboard.php" class="activity-back-btn">
                            <i class="bi bi-chevron-left"></i>
                            <h1 class="menu-tittle">Activity</h1>
                        </a>
                    </div>
                    <div class="menu-box">
                        <div class="box">
                            <img src="../image/sports_esports.png" alt="esport" />
                            <div class="inner-box">
                                <p>jawab quizz dengan benar untuk mendapat poin</p>
                                <a href="../game/game.php" class="box-btn">klik disini</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <hr />
            <section class="footer">
                <div class="footer-logo">
                    <img src="../image/logo.png" alt="logo" />
                    <h1>My Culture</h1>
                </div>

                <p class="footer-text">
                    my culture akan membantu pelestarian budaya di indonesia dengan cara yang modern
                </p>

                <div class="copyright">
                    <p>Copyright &copy; 2023 My Culture. All rights reserved.</p>
                    <div class="social-media">  
                        <a href="#"><i class="bx bxl-instagram"></i></a>
                        <a href="#"><i class="bx bxl-twitter"></i></a>
                        <a href="#"><i class="bx bxl-youtube"></i></a>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>

</html>