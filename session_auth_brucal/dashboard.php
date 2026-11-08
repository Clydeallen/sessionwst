<?php
// dashboard.php - protected page
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$username = htmlspecialchars($_SESSION['username']);
$userId   = (int) $_SESSION['user_id'];
$sid      = session_id();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard - SessionAuthSystem</title>
<style>
  body{font-family:Segoe UI,Arial,sans-serif;margin:0;background:#eef3f7;color:#333}
  nav{background:#212529;color:#fff;display:flex;justify-content:space-between;align-items:center;padding:12px 40px}
  nav .left a{color:#fff;text-decoration:none;margin-right:20px}
  nav .left a.brand{font-weight:bold}
  nav .right span{margin-right:14px}
  nav .logout{background:#dc3545;color:#fff;padding:6px 12px;border-radius:6px;text-decoration:none}
  .hero{padding:60px 40px 30px}
  .hero h1{color:#0d6efd;font-size:40px;margin:0 0 10px}
  .hero p{color:#777}
  .btn{display:inline-block;background:#0d6efd;color:#fff;padding:10px 18px;border-radius:6px;text-decoration:none}
  .grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:24px;padding:30px 40px}
  .box{padding:24px;border:2px solid #0d6efd;border-radius:12px;box-shadow:0 6px 20px rgba(0,0,0,.18)}
  .box h3{margin:0 0 16px}
  .hero-card{background:#f8fbff;border-color:#b6d4fe;color:#176b87}
  .status-card,.user-card{background:#f8fbff;border-color:#b6d4fe}
  .status-card,.user-card{color:#176b87}
  .status-card h3,.user-card h3{color:#176b87}
  .session-card{background:#fffdf5;border-color:#ffe69c;color:#765600}
  .session-card h3{color:#765600}
  .sid,.status-card code,.session-card code{color:#b42318}
  .sid{font-family:monospace;word-break:break-all}
  .small{font-size:12px;color:#665000}
  .ticker{overflow:hidden;margin:0 40px 32px;padding:14px 0;color:#000}
  .ticker p{width:max-content;margin:0;white-space:nowrap;animation:scroll-message 18s linear infinite}
  @keyframes scroll-message{from{transform:translateX(100vw)}to{transform:translateX(-100%)}}
  @media(max-width:600px){.hero{padding:40px 24px 20px}.grid{padding:24px}.ticker{margin:0 24px 24px}}
  @media(prefers-reduced-motion:reduce){.ticker p{width:auto;padding:0 16px;white-space:normal;animation:none}}
</style>
</head>
<body>
<nav>
  <div class="left">
    <a class="brand" href="dashboard.php">SessionAuthSystem</a>
    <a href="dashboard.php">Dashboard</a>
  </div>
  <div class="right">
    <span>👤 <?= $username ?></span>
    <a class="logout" href="logout.php">Logout</a>
  </div>
</nav>

<div class="hero">
  <div class="box hero-card">
    <h1>Welcome, <?= $username ?>!</h1>
    <p>This page is protected and only visible to logged-in users.</p>
    <a class="btn" href="#details">Explore Dashboard</a>
  </div>
</div>

<div class="grid" id="details">
  <div class="box status-card">
    <h3>🛡️ Account Status</h3>
    <p>Your session is active and protected against Session Fixation using <code>session_regenerate_id()</code>.</p>
  </div>
  <div class="box user-card">
    <h3>👤 User Details</h3>
    <p><b>User ID:</b> <?= $userId ?></p>
    <p><b>Username:</b> <?= $username ?></p>
  </div>
  <div class="box session-card">
    <h3>🔑 Active Session ID</h3>
    <p><b>Current Session ID:</b></p>
    <p class="sid"><?= htmlspecialchars($sid) ?></p>
    <p class="small">Generated after login call to <code>session_regenerate_id()</code></p>
  </div>
</div>
<div class="ticker" aria-label="Dashboard information">
  <p>This is a demo dashboard. You can log in to see session regeneration in action.</p>
</div>
</body>
</html>
