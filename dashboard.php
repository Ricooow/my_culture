<?php
session_start();
include "connect.php";
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
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
        header("Location: login.php");
        exit();
    }
} else {
    // Redirect to login if user_id is not set
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<body>
    <main>
        <video id="bg-vid" poster="image/poster.png" autoplay mute loop>
            <source src="image/background.mp4" type="video/mp4">
        </video>
        <div class="big-wrapper">
            <header>
                <div class="container">
                    <div class="logo">
                        <a href="dashboard.php">
                            <img src="image/logo.png" alt="logo">
                        </a>
                        <h3>
                            My Culture
                        </h3>
                    </div>
                </div>
                <nav class="profile">
                    <img src="<?php echo htmlspecialchars($row['photo_profile']); ?>" height="25px" class="foto-profile">
                    <h1><a href="profile.php"><?php echo $_SESSION['username'];?></a></h1>
                    <a href="logout.php" class="logout-btn">Logout</a>
                </nav>
            </header>
                    
            <section class="text">
                <div class="heading-text">
                    <h2>
                        Selamat datang <span><?php echo $_SESSION['username'];?></span>
                    </h2>
                    <p>
                        MARI KITA <span>LESTARIKAN</span> KEBUDAYAAN INDONESIA DAN DAPATKAN <span>HADIAH MENARIK</span>
                    </p>
                </div>
            </section>
            <section>
                <div class="menu">
                        <p class="heading-menu">Temukan hal menarik</p>
                        <h1 class="menu-tittle">Activity</h1>
                    <div class="menu-box">
                        <div class="box box-1">
                            <img src="./image/sports_esports.png" alt="esport">
                            <p>mainkan game sederhana untuk mendapat poin</p>
                            <a href="game/game_dashboard.php" class="box-btn">klik disini</a>
                        </div>
                        <div class="box box-2">
                            <img src="./image/change_circle.png" alt="esport">
                            <p>tukarankan poin anda dengan hadiah</p>
                            <a href="./penukaran/" class="box-btn">klik disini</a>
                        </div>
                        <div class="box box-3">
                            <img src="./image/pending.png" alt="esport">
                            <p>lihat konten kebudayaan lainya</p>
                            <a href="CRUD/artikel/index.php" class="box-btn">klik disini</a>
                        </div>
                    </div>
                </div>
            </section>
            <section class="riwayat">
                <div class="menu">
                    <p class="heading-menu">Riwayat Penukaran</p>
                    <h1 class="menu-tittle">Hadiah yang Sudah Ditukar</h1>
                    <div class="menu-box menu-voucher">
                    <?php
                    $sql = "SELECT h.nama_hadiah, h.deskripsi, p.poin_used 
                            FROM tb_penukaran p 
                            JOIN tb_hadiah h ON p.reward_id = h.reward_id 
                            WHERE p.user_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0):
                        while ($row = $result->fetch_assoc()):
                    ?>
                        <div class="box">
                            <h3><?= htmlspecialchars($row['nama_hadiah']) ?></h3>
                            <p><?= htmlspecialchars($row['deskripsi']) ?></p>
                            <span><strong>Poin Digunakan:</strong> <?= $row['poin_used'] ?></span>
                        </div>
                    <?php 
                        endwhile;
                    else: 
                    ?>
                        <p style="margin-top: 1rem;">Belum ada penukaran hadiah.</p>
                    <?php endif; ?>
                    </div>
                </div>
            </section>
            
            <hr>
            <section class="footer">
                    <div class="footer-logo">
                        <img src="image/logo.png" alt="error">
                        <h1>My Culture</h1>
                    </div>

                    <p class="footer-text">my culture akan membantu pelestarian budaya di indonesia dengan cara yang modern</p>
                
                <div class="copyright">
                    <p>Copyright &copy; 2023 My Culture. All rights reserved.</p>
                    <div class="social-media">
                        <a href="#"><i class='bx bxl-facebook'></i></a>
                        <a href="#"><i class='bx bxl-instagram'></i></a>
                        <a href="#"><i class='bx bxl-twitter'></i></a>
                        <a href="#"><i class='bx bxl-youtube'></i></a>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>