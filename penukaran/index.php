<?php
session_start();
include "../connect.php";

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? '';

$query = "SELECT 
    reward_id,
    nama_hadiah,
    deskripsi,
    harga_hadiah
    FROM tb_hadiah";
$result = mysqli_query($conn, $query);

$query_poin = "SELECT poin FROM tb_user WHERE user_id = ?";
$stmt = $conn->prepare($query_poin);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result_poin = $stmt->get_result();
$poin = $result_poin->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Penukaran Hadiah</title>
    <link rel="stylesheet" href="../css/penukaran.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
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
                        <a href="../dashboard.php">
                            <img src="../image/logo.png" alt="logo" />
                        </a>
                        <h3>My Culture</h3>
                    </div>
                </div>
                <nav class="profile">
                    <img src="../image/def.png" height="25px" class="foto-profile" />
                    <h1><a href="../profile.php"><?php echo htmlspecialchars($username); ?></a></h1>
                    <div class="poin-container">
                        <i class='bx bx-trophy'></i>    
                        <p><?php echo htmlspecialchars($poin['poin']); ?></p>
                    </div>
                </nav>
            </header>

            <section class="text">
                <div class="heading-text">
                    <h2>Daftar <span>Hadiah</span></h2>
                    <p>Temukan hadiah menarik yang bisa Anda tukarkan dengan poin.</p>
                </div>
            </section>

            <section class="menu-section">
                <div class="menu">
                    <a href="../dashboard.php" class="back-dashboard">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                    <div class="menu-box">
                        <?php if ($result && mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <div class="box">
                                    <h2><?php echo htmlspecialchars($row['nama_hadiah']); ?></h2>
                                    <p><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                                    <p class="harga">Harga: <?php echo htmlspecialchars($row['harga_hadiah']); ?> poin</p>
                                    <form action="proses_penukaran.php" method="POST">
                                        <input type="hidden" name="reward_id" value="<?php echo htmlspecialchars($row['reward_id']); ?>">
                                        <button type="submit" class="btn-tukar">Tukar Hadiah</button>
                                    </form>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>Tidak ada hadiah tersedia saat ini.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <hr />

            <section class="footer">
                <div class="footer-logo">
                    <img src="../image/logo.png" alt="logo" />
                    <h1>My Culture</h1>
                </div>
                <p class="footer-text">My Culture akan membantu pelestarian budaya di Indonesia dengan cara yang modern</p>
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
