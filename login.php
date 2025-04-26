<?php
session_start();
include("config/connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$pass'";
    $result = $con->query($sql);
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user'] = $user['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login - MyVault</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #f0f4ff, #dbe7f5);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-card {
      background: white;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.08);
      width: 100%;
      max-width: 400px;
      animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }

    .login-title {
      text-align: center;
      font-size: 22px;
      font-weight: 600;
      color: #0d6efd;
      margin-bottom: 25px;
    }

    .form-control {
      background-color: #f2f4f6;
      border: none;
      border-radius: 10px;
    }

    .btn-login {
      background-color: #0d6efd;
      border: none;
      border-radius: 12px;
      font-weight: 500;
      padding: 10px;
      transition: all 0.3s ease;
    }

    .btn-login:hover {
      background-color: #0b5ed7;
      box-shadow: 0 5px 12px rgba(13,110,253,0.3);
    }

    .form-link {
      text-align: center;
      margin-top: 15px;
    }

    .form-link a {
      color: #0d6efd;
      text-decoration: none;
    }

    .form-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="login-card">
  <div class="login-title">🔐 MyVault Login</div>

  <?php if (isset($error)): ?>
    <div class="alert alert-danger text-center py-1"><?= $error ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <input type="email" name="email" class="form-control" placeholder="Enter email" required>
    </div>
    <div class="mb-3">
      <input type="password" name="password" class="form-control" placeholder="Enter password" required>
    </div>
    <div class="d-grid">
      <button type="submit" class="btn btn-login">Login</button>
    </div>
  </form>

  <div class="form-link">
    Don't have an account? <a href="signup.php">Sign up</a>
  </div>
</div>

</body>
</html>
