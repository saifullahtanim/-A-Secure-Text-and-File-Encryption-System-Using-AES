<?php
include("includes/encryption.php");

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $originalName = $_FILES['file']['name'];
    $tmpPath = $_FILES['file']['tmp_name'];

    $encryptedData = encryptFileContent($tmpPath);

    $encryptedPath = "uploads/" . $originalName . ".enc";
    file_put_contents($encryptedPath, $encryptedData);
    $message = "✅ File encrypted and saved as: <code>$encryptedPath</code>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Encrypt File</title>
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
        .custom-box {
            max-width: 600px;
            margin: auto;
            margin-top: 60px;
        }
    </style>
</head>
<body>

<div class="container custom-box">
    <div class="bg-white p-5 shadow rounded">
        <h4 class="mb-4 text-primary fw-bold">🔐 Encrypt a File</h4>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="file" class="form-label">Choose file to encrypt:</label>
                <input type="file" class="form-control" name="file" required>
            </div>
            <button type="submit" class="btn btn-primary">Encrypt & Save</button>
            <a href="dashboard.php" class="btn btn-outline-secondary ms-2">⬅️ Back to Dashboard</a>
        </form>
    </div>
</div>

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
