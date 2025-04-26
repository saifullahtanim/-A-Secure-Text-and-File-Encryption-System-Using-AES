<?php
session_start();
include("includes/decryption.php");

if (!isset($_GET['file'])) {
    die("No file specified.");
}

$filename = basename($_GET['file']);
$filepath = "uploads/" . $filename;

if (!file_exists($filepath)) {
    die("❌ File not found.");
}

$decryptedData = decryptFileContent($filepath);
if (!$decryptedData) {
    die("❌ Decryption failed. Please check your encryption key.");
}

$realName = pathinfo($filename, PATHINFO_FILENAME); // e.g. image.jpg
$ext = pathinfo($realName, PATHINFO_EXTENSION);
$basename = pathinfo($realName, PATHINFO_FILENAME);

$tempDir = "temp";
if (!is_dir($tempDir)) mkdir($tempDir);
$tempfile = $tempDir . "/" . $basename . "." . $ext;
file_put_contents($tempfile, $decryptedData);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Decrypted Preview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fef9e7;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            flex: 1;
        }
        .preview-box {
            max-width: 700px;
            margin: auto;
            margin-top: 60px;
        }
    </style>
</head>
<body>

<div class="container preview-box">
    <div class="bg-white p-5 shadow rounded">
        <h4 class="text-success fw-bold mb-4">✅ Decrypted File Preview</h4>

        <?php if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])): ?>
            <img src="<?= $tempfile ?>" class="img-fluid rounded border" alt="Decrypted Image">

        <?php elseif (in_array($ext, ['mp4', 'webm'])): ?>
            <video controls class="w-100 rounded border">
                <source src="<?= $tempfile ?>" type="video/<?= $ext ?>">
                Your browser does not support the video tag.
            </video>

        <?php elseif (in_array($ext, ['txt', 'csv', 'log', 'html'])): ?>
            <pre class="bg-light p-3 rounded border"><?= htmlspecialchars($decryptedData) ?></pre>

        <?php else: ?>
            <div class="alert alert-info">
                This file cannot be previewed.<br>
                <a href="<?= $tempfile ?>" download class="btn btn-primary mt-2">Download File</a>
            </div>
        <?php endif; ?>

        <a href="dashboard.php" class="btn btn-outline-secondary mt-4">⬅️ Back to Dashboard</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
