<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['username'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image'])) {
        require_once 'includes/imagick-upload.php';
        
        try {
            $uploader = new ImageUploader();
            $filename = $uploader->process($_FILES['image']);
            $success = "Vulnerability report uploaded successfully. <br>";
            $success .= "<strong>URL:</strong> <code>uploads/{$filename}</code>";
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Moon Security | Upload Report</title>
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
            <h1>Submit Vulnerability Report</h1>
            <div class="notice">
                <strong>Important:</strong> 
                <ul>
                    <li>Only <code>.png</code>, <code>.jpg</code>, and <code>.gif</code> files are allowed.</li>
                    <li>Reports are automatically processed by our ImageMagick system.</li>
                    <li>All files are stored privately in <code>/uploads/</code>.</li>
                </ul>
            </div>
            
            <?php if ($error): ?>
                <div class="alert error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert success">
                    <?= $success ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="image">Select Image:</label>
                    <input type="file" id="image" name="image" accept="image/png, image/jpeg, image/gif" required>
                </div>
                <button type="submit" class="btn">Upload Report</button>
            </form>
        </div>
    </div>

    <footer>
        <p>Blood Moon Security &copy; 2023 - Protecting the digital night</p>
    </footer>
</body>
</html>