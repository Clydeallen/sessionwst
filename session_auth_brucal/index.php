<?php
// index.php - Login UI
session_start();
require "db.php";

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);   // prevents session fixation
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login - SessionAuthSystem</title>
<style>
  body{font-family:Segoe UI,Arial,sans-serif;background:#eef3f7;display:flex;justify-content:center;align-items:center;min-height:100vh;margin:0}
  .card{background:#fff;padding:32px;border-radius:12px;box-shadow:0 4px 18px rgba(0,0,0,.1);width:340px;text-align:center}
  h2{margin:8px 0 4px;color:#333}
  p.sub{color:#888;font-size:14px;margin:0 0 20px}
  label{display:block;text-align:left;font-size:13px;font-weight:600;margin:12px 0 4px;color:#444}
  input{width:100%;padding:10px;border:1px solid #ccc;border-radius:6px;box-sizing:border-box}
  button{width:100%;margin-top:20px;padding:11px;background:#0d6efd;color:#fff;border:0;border-radius:6px;font-size:15px;cursor:pointer}
  button:hover{background:#0b5ed7}
  .err{background:#f8d7da;color:#842029;padding:10px;border-radius:6px;font-size:14px;margin-bottom:10px}
  a{color:#0d6efd;text-decoration:none}
  .foot{margin-top:16px;font-size:14px;color:#666}
</style>
</head>
<body>
<div class="card">
  <h2>Welcome Back</h2>
  <p class="sub">Login to your account</p>

  <?php if ($error): ?><div class="err"><?= htmlspecialchars($error) ?></div><?php endif; ?>

  <form method="POST" action="">
    <label>Username</label>
    <input type="text" name="username" placeholder="Enter username" required>
    <label>Password</label>
    <input type="password" name="password" placeholder="Enter password" required>
    <button type="submit">Login</button>
  </form>
  <div class="foot">No account yet? <a href="register.php">Register here</a></div>
</div>
</body>
</html>
