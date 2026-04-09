<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
include 'header.php';
include 'db_connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = $_POST['password'];

    if (isset($email, $password) && $email && $password) {
        $sql    = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id']   = $user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['email']     = $user['email'];
                header('Location: dashboard.php');
                exit;
            } else {
                $error = 'Incorrect password. Please try again.';
            }
        } else {
            $error = 'No account found with that email address.';
        }
    } else {
        $error = 'Please fill in all fields.';
    }
}
?>

<div class="page-hero">
  <h1>Login</h1>
  <div class="breadcrumb"><a href="index.php">Home</a> / Login</div>
</div>

<section class="section">
  <div class="section-inner">
    <div class="form-wrap">
      <h2>Welcome Back</h2>

      <?php if ($error): ?>
        <div class="alert alert-error"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST" id="loginForm">
        <div class="form-group">
          <label>Email Address *</label>
          <input type="email" name="email" required placeholder="you@example.com">
        </div>
        <div class="form-group">
          <label>Password *</label>
          <input type="password" name="password" required>
        </div>
        <button type="submit" class="form-submit">Login</button>
      </form>
      <div class="form-link">Don't have an account? <a href="register.php">Register here</a></div>
      <div class="form-link"><a href="forgot_password.php">Forgot your password?</a></div>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
