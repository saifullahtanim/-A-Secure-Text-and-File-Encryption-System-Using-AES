
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

define('UPLOAD_DIR', 'uploads/');
define('ENCRYPTION_KEY', 'my_super_secret_key_1234');
define('ENCRYPTION_METHOD', 'AES-256-CBC');

if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
}

$result = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_name = basename($_FILES['file']['name']);
    $encrypted_name = pathinfo($file_name, PATHINFO_FILENAME) . '.enc';

    $data = file_get_contents($file_tmp);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(ENCRYPTION_METHOD));
    $encrypted_data = openssl_encrypt($data, ENCRYPTION_METHOD, ENCRYPTION_KEY, 0, $iv);
    $final_data = base64_encode($iv . $encrypted_data);

    file_put_contents(UPLOAD_DIR . $encrypted_name, $final_data);

    $result = "✅ File successfully encrypted and saved as <strong>{$encrypted_name}</strong>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>File Uploaded</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #eef3fc;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            flex: 1;
        }
        footer {
            padding: 15px 0;
            background-color: #f8f9fa;
            text-align: center;
            font-size: 14px;
        }
        .footer-link {
            color: #0d6efd;
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
    <div class="bg-white p-5 shadow rounded text-center" style="width: 100%; max-width: 600px;">
        <h4 class="mb-4 text-success fw-bold">📁 File Encryption Result</h4>
        <?php if ($result): ?>
            <div class="alert alert-success"><?= $result ?></div>
        <?php else: ?>
            <div class="alert alert-danger">❌ No file uploaded. <a href="encrypt_file.php" class="text-decoration-underline">Try again</a></div>
        <?php endif; ?>
        <a href="dashboard.php" class="btn btn-outline-primary mt-3">⬅️ Back to Dashboard</a>
    </div>
</div>

<!-- Footer -->
<footer>
    Project by <span class="footer-link" data-bs-toggle="modal" data-bs-target="#devModal">Saifulla Tanim and Mim Akter</span> | Green University of Bangladesh
</footer>

<!-- Developer Modal -->
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
