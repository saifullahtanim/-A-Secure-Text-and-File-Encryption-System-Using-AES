<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

include("config/connect.php");

// Fetch encrypted texts
$sql = "SELECT * FROM credentials ORDER BY id DESC";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        .profile-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .short-text {
            font-weight: bold;
            color: #2c3e50;
            cursor: pointer;
        }
        .delete-btn {
            margin-left: 10px;
        }
    </style>
</head>
<body style="background-color: #f0f4fa;">

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>👋 Welcome to MyVault </h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <!-- ✅ Centered and Neat Action Buttons -->
    <div class="d-flex justify-content-center gap-3 flex-wrap mb-4">
        <a href="encrypt_text.php" class="btn btn-outline-primary px-3 py-2 fw-semibold rounded-2">➕ Encrypt Text</a>
        <a href="decrypt_text.php" class="btn btn-outline-warning px-3 py-2 fw-semibold rounded-2">🛠️ Decrypt Text</a>
        <a href="encrypt_file.php" class="btn btn-outline-dark px-3 py-2 fw-semibold rounded-2">📁 Encrypt File</a>
        <a href="view_files.php" class="btn btn-outline-success px-3 py-2 fw-semibold rounded-2">📂 View Files</a>
    </div>

    <!-- 🔐 Encrypted Texts -->
    <div class="card p-4">
        <h5 class="mb-3 text-primary fw-bold">🔐 Your Encrypted Texts</h5>
        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $text = $row['text'];
                $created = $row['created_at'];
                $formattedTime = date("d-m-Y h:i:s A", strtotime($created));// ✅ 12-hour format
                $shortText = substr($text, 0, 6) . "****" . substr($text, -6);
                $elementId = "key-$id";
                echo "<div class='p-3 mb-3 bg-light rounded'>";
                echo "<div class='d-flex justify-content-between align-items-center'>";
                echo "<div class='d-flex align-items-center'>";
                echo "<span class='short-text' title='$text' id='$elementId'>$shortText</span>";
                echo "<button class='btn btn-sm btn-outline-secondary ms-2' onclick=\"copyToClipboard('$elementId')\">📋</button>";
                echo "</div>";
                echo "<form method='post' action='delete_text.php'>";
                echo "<input type='hidden' name='text_id' value='$id'>";
                echo "<button type='submit' class='btn btn-sm btn-danger delete-btn'>🗑️ Delete</button>";
                echo "</form>";
                echo "</div>";
                echo "<small class='text-muted'>Saved: $formattedTime</small>";
                echo "</div>";
            }
        } else {
            echo "<p>No texts saved yet.</p>";
        }
        ?>
    </div>

    <!-- 📁 Uploaded Encrypted Files -->
    <div class="card p-4 mt-4">
        <h5 class="mb-3 text-primary fw-bold">📁 Uploaded Encrypted Files</h5>
        <?php
        $upload_dir = 'uploads/';
        if (is_dir($upload_dir)) {
            $files = array_diff(scandir($upload_dir), ['.', '..']);
            if (count($files) > 0) {
                echo "<ul class='list-group'>";
                foreach ($files as $file) {
                    echo "<li class='list-group-item'>🔒 $file</li>";
                }
                echo "</ul>";
            } else {
                echo "<p class='text-muted'>No encrypted files uploaded yet.</p>";
            }
        } else {
            echo "<p class='text-danger'>Upload folder not found!</p>";
        }
        ?>
    </div>
</div>

<!-- Footer & Modal -->
<footer class="text-center py-3 bg-light">
    Project by <span class="text-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#devModal" style="cursor: pointer;">Saifulla Tanim and Mim Akter</span> | Green University of Bangladesh
</footer>

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

<!-- Bootstrap JS + Clipboard Function -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function copyToClipboard(elementId) {
    const text = document.getElementById(elementId).getAttribute('title');
    navigator.clipboard.writeText(text).then(() => {
        alert("✅ Encrypted key copied!");
    }).catch(err => {
        console.error("❌ Failed to copy:", err);
    });
}
</script>
</body>
</html>
