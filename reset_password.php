<?php
session_start();
include 'header.php';
include 'db_connect.php';

$success = '';
$error   = '';
$token   = isset($_GET['token']) ? mysqli_real_escape_string($conn, $_GET['token']) : '';
$valid   = false;
$user_id = null;

// Validate token
if ($token) {
    $now    = date('Y-m-d H:i:s');
    $result = mysqli_query($conn, "SELECT id FROM users WHERE reset_token = '$token' AND reset_expires > '$now' LIMIT 1");
    if ($result && mysqli_num_rows($result) === 1) {
        $valid   = true;
        $row     = mysqli_fetch_assoc($result);
        $user_id = $row['id'];
    } else {
        $error = 'This reset link is invalid or has expired. Please request a new one.';
    }
} else {
    $error = 'No reset token provided.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valid) {
    $password  = $_POST['password'];
    $password2 = $_POST['password2'];

    if (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $password2) {
        $error = 'Passwords do not match.';
    } else {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        mysqli_query($conn, "UPDATE users SET password = '$hashed', reset_token = NULL, reset_expires = NULL WHERE id = $user_id");
        $success = 'Your password has been updated successfully. <a href="login.php">Login now</a>.';
        $valid   = false; // hide form after success
    }
}
?>

<div class="page-hero">
  <h1>Reset Password</h1>
  <div class="breadcrumb"><a href="index.php">Home</a> / Reset Password</div>
</div>

<section class="section">
  <div class="section-inner">
    <div class="form-wrap">
      <h2>Choose a New Password</h2>

      <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="alert alert-error"><?= $error ?></div>
        <div class="form-link"><a href="forgot_password.php">Request a new reset link</a></div>
      <?php endif; ?>

      <?php if ($valid): ?>
      <form method="POST" action="reset_password.php?token=<?= htmlspecialchars($token) ?>">
        <div class="form-group">
          <label>New Password * (min. 6 characters)</label>
          <input type="password" name="password" required>
        </div>
        <div class="form-group">
          <label>Confirm New Password *</label>
          <input type="password" name="password2" required>
        </div>
        <button type="submit" class="form-submit">Update Password</button>
      </form>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
