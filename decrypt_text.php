<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
include("config/connect.php");

// ✅ decryptText() function define করছি
function decryptText($data, $key = 'your-secret-key-123') {
    $raw = base64_decode($data);
    $method = "AES-256-CBC";
    $iv = substr($raw, 0, 16);
    $ciphertext = substr($raw, 16);
    return openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv);
}

$decrypted_text = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $text = $_POST['text'];
    $decrypted_text = decryptText($text);
    $_SESSION['decrypted_text'] = $decrypted_text;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Decrypt Text</title>
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
        footer {
            padding: 15px 0;
            background-color: #fff8dc;
            text-align: center;
            font-size: 14px;
        }
        .footer-link {
            color: #f39c12;
            font-weight: 600;
            cursor: pointer;
        }
        .footer-link:hover {
            text-decoration: underline;
        }
        .profile-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

<div class="container d-flex flex-column align-items-center justify-content-center my-5">
    <div class="bg-white p-5 shadow rounded" style="width: 100%; max-width: 600px;">
        <h4 class="mb-4 fw-bold text-warning">🛠️ Decrypt Your Text</h4>
        <form method="POST">
            <div class="mb-3">
                <label for="text" class="form-label">Enter your encrypted text:</label>
                <textarea class="form-control" name="text" rows="5" required></textarea>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-warning text-dark">Decrypt</button>
                <a href="dashboard.php" class="btn btn-outline-secondary">⬅️ Back to Dashboard</a>
            </div>
        </form>

        <?php if (!empty($decrypted_text)) : ?>
        <div class="mt-4 alert alert-success">
            <strong>Decrypted Result:</strong><br>
            <?= htmlspecialchars($decrypted_text) ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- ✅ Footer -->
<footer>
    Project by <span class="footer-link" data-bs-toggle="modal" data-bs-target="#devModal">Saifulla Tanim and Mim Akter</span> | Green University of Bangladesh
</footer>

<!-- ✅ Developer Modal -->
<div class="modal fade" id="devModal" tabindex="-1" aria-labelledby="devModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="devModalLabel">👨‍💻 Developer Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <div class="row justify-content-center g-5">
          <div class="col-md-4">
            <img src="saifulla.jpg" class="profile-img mb-2" alt="Saifulla Tanim">
            <h6 class="fw-bold">Saifulla Tanim</h6>
            <p>ID: 222002014<br>Dept: CSE</p>
          </div>
          <div class="col-md-4">
            <img src="mim.jpg" class="profile-img mb-2" alt="Mim Akter">
            <h6 class="fw-bold">Mim Akter</h6>
            <p>ID: 222002104<br>Dept: CSE</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
