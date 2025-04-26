<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$upload_dir = 'uploads/';
$files = [];

if (is_dir($upload_dir)) {
    $files = array_diff(scandir($upload_dir), ['.', '..']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Files</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4fa;
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

<div class="container my-5">
    <div class="bg-white p-5 shadow rounded">
        <h4 class="mb-4 text-success fw-bold">📂 Encrypted Files List</h4>

        <?php if (!empty($files)) : ?>
            <ul class="list-group">
                <?php foreach ($files as $file): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        🔒 <?= htmlspecialchars($file) ?>
                        <div class="d-flex gap-2 flex-wrap">

                            <a href="<?= $upload_dir . $file ?>" class="btn btn-sm btn-outline-primary" download>Download</a>
                            <a href="decrypt_file.php?file=<?= urlencode($file) ?>" class="btn btn-sm btn-warning text-dark">Decrypt</a>
                            <form action="delete_file.php" method="post" class="d-inline">
                                <input type="hidden" name="filename" value="<?= htmlspecialchars($file) ?>">
                                <button type="submit" class="btn btn-sm btn-danger">🗑️ Delete</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-muted">No encrypted files found.</p>
        <?php endif; ?>

        <a href="dashboard.php" class="btn btn-outline-secondary mt-4">⬅️ Back to Dashboard</a>
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

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
