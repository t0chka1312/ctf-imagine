<?php
session_start();
require_once 'includes/db.php';

$error = '';
$db = new DB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $start = microtime(true);
    $result = $db->query($query);
    $end = microtime(true);
    
    $delay = $end - $start;
    
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user'] = $user;
        header('Location: dashboard.php');
        exit();
    } else {
        usleep(rand(100000, 300000));
        $error = 'Invalid credentials';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Moon Security | Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php" class="logo">BLOOD MOON SECURITY</a>
            <ul class="menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="list_files.php">Vulnerabilities</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="card">
            <h1>Researcher Login</h1>
            <p>Access the vulnerability reporting system</p>
            
            <?php if ($error): ?>
                <p style="color: var(--accent-red);"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="username">Researcher ID:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Access Code:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn">Authenticate</button>
            </form>
        </div>

        <div class="card">
            <h2>Recent Vulnerabilities</h2>
            <div class="vulnerability-grid">
                <div class="vulnerability-item">
                    <img src="assets/images/vuln1.jpg" alt="Vulnerability Report">
                    <h3>Web App SQL Injection</h3>
                    <p>Critical severity</p>
                </div>
                <div class="vulnerability-item">
                    <img src="assets/images/vuln2.jpg" alt="Vulnerability Report">
                    <h3>RCE in Image Processor</h3>
                    <p>High severity</p>
                </div>
                <div class="vulnerability-item">
                    <img src="assets/images/vuln3.jpg" alt="Vulnerability Report">
                    <h3>Privilege Escalation</h3>
                    <p>Medium severity</p>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>Blood Moon Security &copy; 2023 - Protecting the digital night</p>
    </footer>
</body>
</html>