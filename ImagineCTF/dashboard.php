<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Moon Security | Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php" class="logo">BLOOD MOON SECURITY</a>
            <ul class="menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="upload.php">Report Vulnerability</a></li>
                <li><a href="?logout=1">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="card">
            <h1>Researcher Dashboard</h1>
            <p>Welcome back, <?= htmlspecialchars($user['username']) ?></p>
            
            <?php if ($user['username'] === 'admin'): ?>
                <div class="admin-panel">
                    <h2>Administrator Tools</h2>
                    <a href="upload.php" class="btn">Upload Vulnerability Report</a>
                    
                    <!-- Listado interno de archivos (solo para admin) -->
                    <h3>Your Recent Reports</h3>
                    <?php
                    $uploadDir = 'uploads/';
                    $files = scandir($uploadDir);
                    $files = array_diff($files, ['.', '..']);
                    
                    if (count($files) > 0): ?>
                        <ul class="file-list">
                            <?php foreach ($files as $file): ?>
                                <li>
                                    <a href="<?= htmlspecialchars($uploadDir . $file) ?>">
                                        <?= htmlspecialchars($file) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No reports submitted yet.</p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p>You don't have administrative privileges to submit vulnerability reports.</p>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <p>Blood Moon Security &copy; 2023 - Protecting the digital night</p>
    </footer>
    
    <?php
    if (isset($_GET['logout'])) {
        session_destroy();
        header('Location: index.php');
        exit();
    }
    ?>
</body>
</html>