<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
include 'header.php';
include 'db_connect.php';

$success = '';
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $email     = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone     = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $password  = $_POST['password'];
    $password2 = $_POST['password2'];

    if (!$full_name || !$email || !$password) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $password2) {
        $error = 'Passwords do not match.';
    } else {
        // Check if email already exists
        $check = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
        if (mysqli_num_rows($check) > 0) {
            $error = 'An account with this email already exists.';
        } else {
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO users (full_name, email, password, phone)
                    VALUES ('$full_name', '$email', '$hashed', '$phone')";
            if (mysqli_query($conn, $sql)) {
                $success = 'Account created successfully! You can now log in.';
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>

<div class="page-hero">
  <h1>Create an Account</h1>
  <div class="breadcrumb"><a href="index.php">Home</a> / Register</div>
</div>

<section class="section">
  <div class="section-inner">
    <div class="form-wrap">
      <h2>Register</h2>

      <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?> <a href="login.php">Login here</a></div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="alert alert-error"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST" id="registerForm">
        <div class="form-group">
          <label>Full Name *</label>
          <input type="text" name="full_name" id="reg_name" required placeholder="Your full name">
        </div>
        <div class="form-group">
          <label>Email Address *</label>
          <input type="email" name="email" required placeholder="you@example.com">
        </div>
        <div class="form-group">
          <label>Phone Number</label>
          <input type="text" name="phone" placeholder="+230 5xxx xxxx">
        </div>
        <div class="form-group">
          <label>Password * (min. 6 characters)</label>
          <input type="password" name="password" id="reg_password" required>
        </div>
        <div class="form-group">
          <label>Confirm Password *</label>
          <input type="password" name="password2" id="reg_password2" required>
          <div class="form-error" id="pass-mismatch">Passwords do not match.</div>
        </div>
        <button type="submit" class="form-submit">Create Account</button>
      </form>
      <div class="form-link">Already have an account? <a href="login.php">Login</a></div>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
