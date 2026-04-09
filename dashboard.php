<?php
session_start();

// Session check — redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'header.php';
include 'db_connect.php';

$user_id = intval($_SESSION['user_id']);

// Retrieve user's orders
$orders_result = mysqli_query($conn,
    "SELECT o.*, s.name AS service_name
     FROM orders o
     LEFT JOIN services s ON o.service_id = s.id
     WHERE o.user_id = $user_id
     ORDER BY o.created_at DESC"
);
?>

<div class="page-hero">
  <h1>My Dashboard</h1>
  <div class="breadcrumb"><a href="index.php">Home</a> / Dashboard</div>
</div>

<section class="section">
  <div class="section-inner">
    <div class="dashboard-wrap">

      <p class="dash-greeting">Welcome back, <span><?= htmlspecialchars($_SESSION['full_name']) ?></span> 👋</p>

      <div style="display:flex; gap:14px; margin-bottom:28px; flex-wrap:wrap;">
        <a href="book.php" class="btn btn-primary">+ Book New Appointment</a>
        <a href="logout.php" class="btn btn-dark">Logout</a>
      </div>

      <h3 style="margin-bottom:16px;">My Bookings</h3>

      <?php if (mysqli_num_rows($orders_result) === 0): ?>
        <div class="alert alert-info">You have no bookings yet. <a href="book.php">Book your first appointment</a>.</div>
      <?php else: ?>
        <div style="overflow-x:auto;">
          <table class="orders-table">
            <thead>
              <tr>
                <th>#</th>
                <th>Service</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
                <th>Booked On</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($o = mysqli_fetch_assoc($orders_result)):
                $badge = 'badge-pending';
                if ($o['status'] === 'Confirmed')    $badge = 'badge-confirmed';
                if ($o['status'] === 'In Progress')  $badge = 'badge-inprog';
              ?>
              <tr>
                <td><?= $o['id'] ?></td>
                <td><?= htmlspecialchars($o['service_name'] ?? '—') ?></td>
                <td><?= $o['appointment_date'] ?></td>
                <td>Rs <?= number_format($o['total_price'], 2) ?></td>
                <td><span class="badge <?= $badge ?>"><?= htmlspecialchars($o['status']) ?></span></td>
                <td><?= date('d M Y', strtotime($o['created_at'])) ?></td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>

    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
