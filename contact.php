<?php
session_start();
include 'header.php';
include 'db_connect.php';

$success = '';
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $email     = mysqli_real_escape_string($conn, trim($_POST['email']));
    $subject   = mysqli_real_escape_string($conn, trim($_POST['subject']));
    $message   = mysqli_real_escape_string($conn, trim($_POST['message']));

    if (isset($full_name, $email, $message) && $full_name && $email && $message) {
        $sql = "INSERT INTO enquiries (full_name, email, subject, message)
                VALUES ('$full_name', '$email', '$subject', '$message')";
        if (mysqli_query($conn, $sql)) {
            $success = 'Thank you! Your message has been received. We will reply within 24 hours.';
        } else {
            $error = 'Could not send your message. Please try again.';
        }
    } else {
        $error = 'Please fill in all required fields.';
    }
}
?>

<div class="page-hero">
  <h1>Contact Us</h1>
  <p>We'd love to hear from you</p>
  <div class="breadcrumb"><a href="index.php">Home</a> / Contact</div>
</div>

<section class="section">
  <div class="section-inner" style="display:grid; grid-template-columns:1fr 1fr; gap:48px; align-items:start;">

    <!-- Contact Info -->
    <div class="reveal">
      <h2 style="margin-bottom:24px;">Get in Touch</h2>
      <div style="display:flex; flex-direction:column; gap:18px;">
        <div style="display:flex; gap:14px; align-items:flex-start;">
          <span style="font-size:28px;">📍</span>
          <div>
            <h4>Address</h4>
            <p style="color:var(--mid);">Impasse Bonnefin, Pailles, Port Louis, Mauritius</p>
          </div>
        </div>
        <div style="display:flex; gap:14px; align-items:flex-start;">
          <span style="font-size:28px;">📞</span>
          <div>
            <h4>Phone</h4>
            <p style="color:var(--mid);">+230 5803 3539</p>
          </div>
        </div>
        <div style="display:flex; gap:14px; align-items:flex-start;">
          <span style="font-size:28px;">✉️</span>
          <div>
            <h4>Email</h4>
            <p style="color:var(--mid);">info@ateliertailleur.mu</p>
          </div>
        </div>
        <div style="display:flex; gap:14px; align-items:flex-start;">
          <span style="font-size:28px;">🕐</span>
          <div>
            <h4>Opening Hours</h4>
            <p style="color:var(--mid);">Mon – Sat: 9:00 AM – 6:00 PM</p>
            <p style="color:var(--mid);">Sunday: Closed</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Contact Form -->
    <div class="reveal">
      <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="alert alert-error"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST" id="contactForm" style="background:var(--white); border:1px solid var(--border); border-radius:8px; padding:32px; box-shadow:var(--shadow);">
        <h3 style="margin-bottom:20px;">Send us a Message</h3>
        <div class="form-group">
          <label>Full Name *</label>
          <input type="text" name="full_name" required placeholder="Your name">
          <div class="form-error">Name is required.</div>
        </div>
        <div class="form-group">
          <label>Email Address *</label>
          <input type="email" name="email" required placeholder="you@example.com">
          <div class="form-error">Email is required.</div>
        </div>
        <div class="form-group">
          <label>Subject</label>
          <input type="text" name="subject" placeholder="e.g. Pricing enquiry">
        </div>
        <div class="form-group">
          <label>Message *</label>
          <textarea name="message" required placeholder="Your message here..."></textarea>
          <div class="form-error">Message is required.</div>
        </div>
        <button type="submit" class="form-submit">Send Message</button>
      </form>
    </div>

  </div>
</section>

<?php include 'footer.php'; ?>
