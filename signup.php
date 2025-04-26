<?php
include("config/connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $sql = "INSERT INTO users (name, email, password, user_type) VALUES ('$name', '$email', '$pass', 'user')";
    if ($con->query($sql)) {
        header("Location: login.php");
        exit();
    } else {
        $error = "❌ Signup failed. Try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Signup - MyVault</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #cfe2ff, #e2eafc);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
      padding: 0;
    }

    .signup-box {
      background: #ffffff;
      padding: 40px 30px;
      border-radius: 18px;
      box-shadow: 0 12px 28px rgba(0,0,0,0.08);
      width: 100%;
      max-width: 420px;
      animation: slideFade 0.5s ease-in-out;
    }

    @keyframes slideFade {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .signup-title {
      font-size: 24px;
      font-weight: 600;
      color: #0d6efd;
      text-align: center;
      margin-bottom: 25px;
    }

    .form-control {
      background: #f1f3f5;
      border: 1px solid #dee2e6;
      border-radius: 10px;
      padding: 12px;
      font-size: 15px;
    }

    .form-control:focus {
      border-color: #0d6efd;
      box-shadow: 0 0 0 0.15rem rgba(13,110,253,0.2);
    }

    .btn-signup {
      background-color: #0d6efd;
      border: none;
      border-radius: 12px;
      font-weight: 500;
      padding: 12px;
      color: #fff;
      font-size: 16px;
      transition: all 0.3s ease-in-out;
    }

    .btn-signup:hover {
      background-color: #0b5ed7;
      box-shadow: 0 8px 20px rgba(13,110,253,0.3);
    }

    .form-link {
      margin-top: 15px;
      text-align: center;
      font-size: 14px;
    }

    .form-link a {
      color: #0d6efd;
      text-decoration: none;
      font-weight: 500;
    }

    .form-link a:hover {
      text-decoration: underline;
    }

    .alert {
      font-size: 14px;
      padding: 8px 10px;
    }
  </style>
</head>
<body>

  <div class="signup-box">
    <div class="signup-title">📝 Create Your Account</div>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <input type="text" name="name" class="form-control" placeholder="Your full name" required>
      </div>
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Your email address" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Create a password" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-signup">Sign up</button>
      </div>
    </form>

    <div class="form-link mt-3">
      Already have an account? <a href="login.php">Login</a>
    </div>
  </div>

</body>
</html>
