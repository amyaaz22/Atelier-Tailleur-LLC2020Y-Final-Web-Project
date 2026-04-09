<?php
session_start();
// Simple admin access check — in real use, add an admin role to users table
// For now: only accessible when directly accessed (no session check shown for simplicity in coursework)
include '../db_connect.php';

// Handle status update (UPDATE operation)
if (isset($_POST['update_status'])) {
    $order_id  = intval($_POST['order_id']);
    $new_status = mysqli_real_escape_string($conn, $_POST['new_status']);
    mysqli_query($conn, "UPDATE orders SET status = '$new_status' WHERE id = $order_id");
    header('Location: admin.php?tab=orders&msg=updated');
    exit;
}

// Handle delete order
if (isset($_GET['delete_order'])) {
    $id = intval($_GET['delete_order']);
    mysqli_query($conn, "DELETE FROM orders WHERE id = $id");
    header('Location: admin.php?tab=orders&msg=deleted');
    exit;
}

// Handle delete enquiry
if (isset($_GET['delete_enquiry'])) {
    $id = intval($_GET['delete_enquiry']);
    mysqli_query($conn, "DELETE FROM enquiries WHERE id = $id");
    header('Location: admin.php?tab=enquiries&msg=deleted');
    exit;
}

$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'orders';

// Retrieve data
$orders     = mysqli_query($conn, "SELECT o.*, s.name AS svc FROM orders o LEFT JOIN services s ON o.service_id=s.id ORDER BY o.created_at DESC");
$users      = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC");
$enquiries  = mysqli_query($conn, "SELECT * FROM enquiries ORDER BY submitted_at DESC");
$services   = mysqli_query($conn, "SELECT * FROM services ORDER BY name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Admin Panel — Atelier Tailleur</title>
  <link rel="stylesheet" href="../style.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<header class="site-header">
  <div class="header-inner">
    <a href="../index.php" class="logo">Atelier <span>Tailleur</span> <span style="font-size:12px; color:var(--gold); margin-left:8px;">[ADMIN]</span></a>
    <nav class="main-nav">
      <a href="../index.php">← Back to Site</a>
    </nav>
  </div>
</header>

<section class="section">
  <div class="section-inner">
    <div class="admin-wrap">
      <h2 style="margin-bottom:20px;">Admin Panel</h2>

      <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success">Action completed successfully.</div>
      <?php endif; ?>

      <!-- Tab buttons (jQuery) -->
      <div class="tab-btns">
        <button class="tab-btn <?= $active_tab==='orders'    ?'active':'' ?>" data-tab="orders">Orders</button>
        <button class="tab-btn <?= $active_tab==='users'     ?'active':'' ?>" data-tab="users">Users</button>
        <button class="tab-btn <?= $active_tab==='enquiries' ?'active':'' ?>" data-tab="enquiries">Enquiries</button>
        <button class="tab-btn <?= $active_tab==='services'  ?'active':'' ?>" data-tab="services">Services</button>
      </div>

      <!-- Orders Tab -->
      <div class="admin-panel" id="panel-orders" style="<?= $active_tab!=='orders' ?'display:none':'' ?>">
        <h3 style="margin-bottom:12px;">All Orders</h3>
        <div style="overflow-x:auto;">
        <table class="admin-table">
          <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Service</th><th>Date</th><th>Total</th><th>Status</th><th>Actions</th></tr></thead>
          <tbody>
          <?php while ($o = mysqli_fetch_assoc($orders)): ?>
          <tr>
            <td><?= $o['id'] ?></td>
            <td><?= htmlspecialchars($o['full_name']) ?></td>
            <td><?= htmlspecialchars($o['email']) ?></td>
            <td><?= htmlspecialchars($o['svc'] ?? '—') ?></td>
            <td><?= $o['appointment_date'] ?></td>
            <td>Rs <?= number_format($o['total_price'],2) ?></td>
            <td>
              <form method="POST" style="display:inline;">
                <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                <select name="new_status" style="font-size:12px; padding:3px 6px; border:1px solid var(--border); border-radius:4px;">
                  <?php foreach(['Pending','Confirmed','In Progress','Completed','Cancelled'] as $st): ?>
                    <option <?= $o['status']===$st?'selected':'' ?>><?= $st ?></option>
                  <?php endforeach; ?>
                </select>
                <button name="update_status" class="btn btn-sm btn-primary" style="margin-left:4px;">Update</button>
              </form>
            </td>
            <td>
              <a href="?delete_order=<?= $o['id'] ?>&tab=orders"
                 onclick="return confirm('Delete this order?')"
                 class="btn btn-sm" style="background:var(--red); color:#fff; border:none;">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
        </div>
      </div>

      <!-- Users Tab -->
      <div class="admin-panel" id="panel-users" style="<?= $active_tab!=='users' ?'display:none':'' ?>">
        <h3 style="margin-bottom:12px;">Registered Users</h3>
        <div style="overflow-x:auto;">
        <table class="admin-table">
          <thead><tr><th>#</th><th>Full Name</th><th>Email</th><th>Phone</th><th>Joined</th></tr></thead>
          <tbody>
          <?php while ($u = mysqli_fetch_assoc($users)): ?>
          <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['full_name']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= htmlspecialchars($u['phone']) ?></td>
            <td><?= date('d M Y', strtotime($u['created_at'])) ?></td>
          </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
        </div>
      </div>

      <!-- Enquiries Tab -->
      <div class="admin-panel" id="panel-enquiries" style="<?= $active_tab!=='enquiries' ?'display:none':'' ?>">
        <h3 style="margin-bottom:12px;">Contact Enquiries</h3>
        <div style="overflow-x:auto;">
        <table class="admin-table">
          <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Date</th><th>Action</th></tr></thead>
          <tbody>
          <?php while ($e = mysqli_fetch_assoc($enquiries)): ?>
          <tr>
            <td><?= $e['id'] ?></td>
            <td><?= htmlspecialchars($e['full_name']) ?></td>
            <td><?= htmlspecialchars($e['email']) ?></td>
            <td><?= htmlspecialchars($e['subject']) ?></td>
            <td style="max-width:200px;"><?= htmlspecialchars(substr($e['message'],0,80)) ?>...</td>
            <td><?= date('d M Y', strtotime($e['submitted_at'])) ?></td>
            <td><a href="?delete_enquiry=<?= $e['id'] ?>&tab=enquiries"
                   onclick="return confirm('Delete this enquiry?')"
                   class="btn btn-sm" style="background:var(--red);color:#fff;border:none;">Delete</a></td>
          </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
        </div>
      </div>

      <!-- Services Tab -->
      <div class="admin-panel" id="panel-services" style="<?= $active_tab!=='services' ?'display:none':'' ?>">
        <h3 style="margin-bottom:12px;">Services</h3>
        <div style="overflow-x:auto;">
        <table class="admin-table">
          <thead><tr><th>#</th><th>Name</th><th>Category</th><th>Price</th><th>Description</th></tr></thead>
          <tbody>
          <?php while ($s = mysqli_fetch_assoc($services)): ?>
          <tr>
            <td><?= $s['id'] ?></td>
            <td><?= htmlspecialchars($s['name']) ?></td>
            <td><?= htmlspecialchars($s['category']) ?></td>
            <td>Rs <?= number_format($s['price'],2) ?></td>
            <td><?= htmlspecialchars(substr($s['description'],0,60)) ?>...</td>
          </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
$(document).ready(function(){
  $('.tab-btn').on('click', function(){
    $('.tab-btn').removeClass('active');
    $(this).addClass('active');
    var t = $(this).data('tab');
    $('.admin-panel').hide();
    $('#panel-' + t).show();
  });
});
</script>

</body>
</html>
