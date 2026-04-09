<?php
// header.php — included at the top of every page
$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atelier Tailleur</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<header class="site-header">
  <div class="header-inner">
    <a href="index.php" class="logo">
      <img src="images/logo.png" alt="Atelier Tailleur" style="height:48px; width:auto;">
    </a>
    <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">&#9776;</button>
    <nav class="main-nav" id="mainNav">
      <a href="index.php"     class="<?= $current=='index.php'     ? 'active':'' ?>">Home</a>
      <a href="about.php"     class="<?= $current=='about.php'     ? 'active':'' ?>">About</a>
      <a href="services.php"  class="<?= $current=='services.php'  ? 'active':'' ?>">Services</a>
      <a href="portfolio.php" class="<?= $current=='portfolio.php' ? 'active':'' ?>">Portfolio</a>
      <a href="book.php"      class="<?= $current=='book.php'      ? 'active':'' ?>">Book</a>
      <a href="contact.php"   class="<?= $current=='contact.php'   ? 'active':'' ?>">Contact</a>
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="dashboard.php" class="<?= $current=='dashboard.php' ? 'active':'' ?>">Dashboard</a>
        <a href="logout.php" class="btn-nav">Logout</a>
      <?php else: ?>
        <a href="login.php"    class="<?= $current=='login.php'    ? 'active':'' ?>">Login</a>
        <a href="register.php" class="btn-nav">Register</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
