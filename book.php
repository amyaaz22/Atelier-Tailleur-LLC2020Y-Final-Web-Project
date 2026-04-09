<?php
session_start();
include 'header.php';
include 'db_connect.php';

$success = '';
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name  = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $email      = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone      = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $service_id = intval($_POST['service_id']);
    $appt_date  = mysqli_real_escape_string($conn, $_POST['appointment_date']);
    $notes      = mysqli_real_escape_string($conn, trim($_POST['notes']));
    $total      = floatval($_POST['total_price']);
    $user_id    = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 'NULL';

    // File upload handling
    $ref_image = '';
    if (isset($_FILES['reference_image']) && $_FILES['reference_image']['error'] === 0) {
        $allowed = ['image/jpeg','image/png','image/gif'];
        $file_type = $_FILES['reference_image']['type'];
        if (!in_array($file_type, $allowed)) {
            $error = 'Only JPG, PNG, GIF files are allowed for the reference image.';
        } else {
            $ext       = pathinfo($_FILES['reference_image']['name'], PATHINFO_EXTENSION);
            $saved     = 'upload_' . time() . '_' . rand(1000,9999) . '.' . $ext;
            $dest      = 'uploads/' . $saved;
            move_uploaded_file($_FILES['reference_image']['tmp_name'], $dest);
            $ref_image = mysqli_real_escape_string($conn, $saved);
        }
    }

    if (!$error) {
        if ($user_id === 'NULL') {
            $sql = "INSERT INTO orders (service_id, full_name, email, phone, appointment_date, notes, reference_image, total_price)
                    VALUES ($service_id, '$full_name', '$email', '$phone', '$appt_date', '$notes', '$ref_image', $total)";
        } else {
            $sql = "INSERT INTO orders (user_id, service_id, full_name, email, phone, appointment_date, notes, reference_image, total_price)
                    VALUES ($user_id, $service_id, '$full_name', '$email', '$phone', '$appt_date', '$notes', '$ref_image', $total)";
        }
        if (mysqli_query($conn, $sql)) {
            $order_id = mysqli_insert_id($conn);
            // Record upload in uploads table
            if ($ref_image) {
                $orig = mysqli_real_escape_string($conn, $_FILES['reference_image']['name']);
                mysqli_query($conn, "INSERT INTO uploads (order_id, original_name, saved_name) VALUES ($order_id, '$orig', '$ref_image')");
            }
            $success = 'Your appointment has been booked successfully! We will contact you shortly.';
        } else {
            $error = 'Booking failed. Please try again.';
        }
    }
}

// Fetch services for dropdown
$svc_result = mysqli_query($conn, "SELECT * FROM services ORDER BY name");
$preselect  = isset($_GET['service']) ? intval($_GET['service']) : 0;
?>

<div class="page-hero">
  <h1>Book an Appointment</h1>
  <p>Choose your service and schedule your fitting</p>
  <div class="breadcrumb"><a href="index.php">Home</a> / Book</div>
</div>

<section class="section">
  <div class="section-inner">
    <div class="form-wrap" style="max-width:680px;">
      <h2>Appointment Booking</h2>

      <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="alert alert-error"><?= $error ?></div>
      <?php endif; ?>

      <!-- Step indicator -->
      <div class="steps-bar">
        <div class="step-label active" id="lbl1">1. Your Details</div>
        <div class="step-label"        id="lbl2">2. Service &amp; Date</div>
        <div class="step-label"        id="lbl3">3. Confirm</div>
      </div>

      <form method="POST" enctype="multipart/form-data" id="bookForm">

        <!-- Step 1 -->
        <div class="form-step active" id="step1">
          <div class="form-group">
            <label>Full Name *</label>
            <input type="text" name="full_name" id="bookName" required
                   value="<?= isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : '' ?>">
          </div>
          <div class="form-group">
            <label>Email Address *</label>
            <input type="email" name="email" required
                   value="<?= isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '' ?>">
          </div>
          <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone" placeholder="+230 5xxx xxxx">
          </div>
          <button type="button" class="btn btn-primary" onclick="goStep(2)" style="width:100%;">Next &rarr;</button>
        </div>

        <!-- Step 2 -->
        <div class="form-step" id="step2">
          <div class="form-group">
            <label>Service *</label>
            <select name="service_id" id="bookService" required>
              <option value="">— Select a service —</option>
              <?php
              while ($s = mysqli_fetch_assoc($svc_result)):
                $sel = ($s['id'] == $preselect) ? 'selected' : '';
              ?>
              <option value="<?= $s['id'] ?>" data-price="<?= $s['price'] ?>" data-name="<?= htmlspecialchars($s['name']) ?>" <?= $sel ?>>
                <?= htmlspecialchars($s['name']) ?> — Rs <?= number_format($s['price'],2) ?>
              </option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Quantity / Number of Pieces</label>
            <input type="number" id="bookQty" name="qty" value="1" min="1" max="10">
          </div>
          <div class="form-group">
            <label>Preferred Appointment Date *</label>
            <input type="date" name="appointment_date" required>
          </div>
          <div class="form-group">
            <label>
              <input type="checkbox" id="bookMember" name="member_discount" value="1">
              I am a returning member (10% discount)
            </label>
          </div>
          <div class="form-group">
            <label>Notes / Special Requests</label>
            <textarea name="notes" placeholder="e.g. preferred fabric, colour, measurements..."></textarea>
          </div>
          <div class="form-group">
            <label>Reference Image (optional)</label>
            <input type="file" name="reference_image" accept="image/*">
            <small style="color:var(--mid); font-size:12px;">Upload a photo of a style you like (JPG/PNG/GIF)</small>
          </div>

          <!-- Live Price Summary -->
          <div class="order-summary">
            <h4>Price Summary</h4>
            <div class="summary-row"><span>Service</span><span id="sum-service">—</span></div>
            <div class="summary-row"><span>Quantity</span><span id="sum-qty">1</span></div>
            <div class="summary-row"><span>Subtotal</span><span id="sum-subtotal">Rs 0.00</span></div>
            <div class="summary-row"><span>Member Discount</span><span id="sum-discount">None</span></div>
            <div class="summary-row"><span>Total</span><span id="sum-total">Rs 0.00</span></div>
          </div>
          <input type="hidden" name="total_price" id="bookTotal" value="0">

          <div style="display:flex; gap:12px; margin-top:18px;">
            <button type="button" class="btn btn-dark" onclick="goStep(1)" style="flex:1;">&larr; Back</button>
            <button type="button" class="btn btn-primary" onclick="goStep(3)" style="flex:2;">Review &rarr;</button>
          </div>
        </div>

        <!-- Step 3 — Confirm -->
        <div class="form-step" id="step3">
          <div class="alert alert-info">Please review your booking details below before submitting.</div>
          <div class="order-summary">
            <h4>Booking Confirmation</h4>
            <div class="summary-row"><span>Name</span><span id="conf-name">—</span></div>
            <div class="summary-row"><span>Service</span><span id="conf-service">—</span></div>
            <div class="summary-row"><span>Quantity</span><span id="conf-qty">—</span></div>
            <div class="summary-row"><span>Appointment Date</span><span id="conf-date">—</span></div>
            <div class="summary-row"><span>Member Discount</span><span id="conf-discount">—</span></div>
            <div class="summary-row"><span>Total Price</span><span id="conf-total">Rs 0.00</span></div>
          </div>
          <div style="display:flex; gap:12px; margin-top:18px;">
            <button type="button" class="btn btn-dark" onclick="goStep(2)" style="flex:1;">&larr; Back</button>
            <button type="submit" class="btn btn-primary" style="flex:2;">Confirm Booking ✓</button>
          </div>
        </div>

      </form>
    </div>
  </div>
</section>

<script>
function calcBookingTotals() {
  var $opt     = $('#bookService option:selected');
  var name     = $opt.data('name') || '—';
  var price    = parseFloat($opt.data('price')) || 0;
  var qty      = parseInt($('#bookQty').val(), 10) || 1;
  var discount = $('#bookMember').is(':checked') ? 0.1 : 0;
  var subtotal = price * qty;
  var total    = subtotal - (subtotal * discount);
  return { name: name, qty: qty, discount: discount, total: total };
}

// Override goStep to also populate step 3 confirmation fields
var origGoStep = window.goStep;
window.goStep = function(n) {
  origGoStep(n);
  if (n === 3) {
    var t        = calcBookingTotals();
    var apptDate = $('input[name="appointment_date"]').val() || '—';
    var name     = $('input[name="full_name"]').val() || '—';

    $('#conf-name').text(name);
    $('#conf-service').text(t.name);
    $('#conf-qty').text(t.qty);
    $('#conf-date').text(apptDate);
    $('#conf-discount').text(t.discount > 0 ? '10% member discount applied' : 'None');
    $('#conf-total').text('Rs ' + t.total.toFixed(2));
    $('#bookTotal').val(t.total.toFixed(2));
  }
};
</script>

<?php include 'footer.php'; ?>

