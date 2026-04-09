<?php
session_start();
include 'header.php';
include 'db_connect.php';

$success = '';
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));

    if (!$email) {
        $error = 'Please enter your email address.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $result = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email' LIMIT 1");
        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            // Generate a simple token and store it with expiry
            $token   = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

            mysqli_query($conn, "UPDATE users SET reset_token = '$token', reset_expires = '$expires' WHERE id = {$user['id']}");

            // In a real system this link would be emailed — here we show it on screen for demo
            $reset_link = "reset_password.php?token=$token";
            $success = "A password reset link has been generated. <br><br>
                        <strong>Demo note:</strong> In a live system this would be emailed to <em>$email</em>.<br>
                        For demo purposes, click the link below:<br><br>
                        <a href='$reset_link' class='btn btn-primary btn-sm'>Reset My Password</a>";
        } else {
            // Don't reveal whether email exists — generic message
            $success = 'If an account with that email exists, a reset link has been sent.';
        }
    }
}
?>

<div class="page-hero">
  <h1>Forgot Password</h1>
  <div class="breadcrumb"><a href="index.php">Home</a> / <a href="login.php">Login</a> / Forgot Password</div>
</div>

<section class="section">
  <div class="section-inner">
    <div class="form-wrap">
      <h2>Reset Your Password</h2>
      <p style="color:var(--mid); font-size:13px; margin-bottom:20px; text-align:center;">Enter your registered email address and we'll send you a reset link.</p>

      <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="alert alert-error"><?= $error ?></div>
      <?php endif; ?>

      <?php if (!$success): ?>
      <form method="POST">
        <div class="form-group">
          <label>Email Address *</label>
          <input type="email" name="email" required placeholder="you@example.com">
        </div>
        <button type="submit" class="form-submit">Send Reset Link</button>
      </form>
      <?php endif; ?>

      <div class="form-link"><a href="login.php">&larr; Back to Login</a></div>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
