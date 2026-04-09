<?php
session_start();
include 'header.php';
include 'db_connect.php';

// Fetch 3 featured services from DB
$result = mysqli_query($conn, "SELECT * FROM services LIMIT 3");
?>

<!-- Hero Section -->
<section class="hero" style="background-image: url('images/headerbanner.jpg'); background-size: cover; background-position: center; position: relative;">
  <div style="position:absolute; inset:0; background:rgba(20,18,8,0.62);"></div>
  <div style="position:relative; z-index:1;">
    <h1>Crafted for <span>You</span></h1>
    <p>Bespoke tailoring and alterations made with passion, precision and the finest fabrics in Mauritius.</p>
    <div class="btn-group">
      <a href="services.php" class="btn btn-primary">Our Services</a>
      <a href="book.php"     class="btn btn-outline">Book Appointment</a>
    </div>
  </div>
</section>

<!-- Featured Services -->
<section class="section bg-cream">
  <div class="section-inner">
    <div class="section-title">
      <h2>Our Services</h2>
      <p>From bespoke suits to expert alterations</p>
      <div class="line"></div>
    </div>
    <div class="cards-grid">
      <?php
      $imgs = [
        'Suits'       => 'images/mensuit.webp',
        'Gowns'       => 'images/eveninggown.avif',
        'Bridal'      => 'images/weddingdress.webp',
        'Casual'      => 'images/trouseralteration.webp',
        'Alterations' => 'images/shirtalteration.jpg'
      ];
      while ($s = mysqli_fetch_assoc($result)):
        $img = isset($imgs[$s['category']]) ? $imgs[$s['category']] : null;
      ?>
      <div class="card reveal">
        <div class="card-img" style="padding:0; overflow:hidden;">
          <?php if ($img): ?>
            <img src="<?= $img ?>" alt="<?= htmlspecialchars($s['name']) ?>" style="width:100%; height:100%; object-fit:cover;">
          <?php else: ?>✂️<?php endif; ?>
        </div>
        <div class="card-body">
          <h3><?= htmlspecialchars($s['name']) ?></h3>
          <p><?= htmlspecialchars($s['description']) ?></p>
          <div class="card-price">Rs <?= number_format($s['price'], 2) ?></div>
          <a href="book.php" class="btn btn-dark btn-sm mt-8">Book Now</a>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
    <div class="text-center mt-24">
      <a href="services.php" class="btn btn-primary">View All Services</a>
    </div>
  </div>
</section>

<!-- Why Choose Us -->
<section class="section">
  <div class="section-inner">
    <div class="section-title">
      <h2>Why Choose Us</h2>
      <div class="line"></div>
    </div>
    <div class="cards-grid">
      <div class="card reveal" style="text-align:center; padding: 24px;">
        <div style="height:160px; overflow:hidden; border-radius:6px; margin-bottom:16px;">
          <img src="images/mensuit.webp" alt="Experience" style="width:100%; height:100%; object-fit:cover;">
        </div>
        <h3>25+ Years Experience</h3>
        <p>Over two decades of crafting bespoke garments for discerning clients across Mauritius.</p>
      </div>
      <div class="card reveal" style="text-align:center; padding: 24px;">
        <div style="height:160px; overflow:hidden; border-radius:6px; margin-bottom:16px;">
          <img src="images/shirtalteration.jpg" alt="Premium Fabrics" style="width:100%; height:100%; object-fit:cover;">
        </div>
        <h3>Premium Fabrics</h3>
        <p>We source only the finest local and imported fabrics for every creation.</p>
      </div>
      <div class="card reveal" style="text-align:center; padding: 24px;">
        <div style="height:160px; overflow:hidden; border-radius:6px; margin-bottom:16px;">
          <img src="images/trouseralteration.webp" alt="Perfect Fit" style="width:100%; height:100%; object-fit:cover;">
        </div>
        <h3>Perfect Fit Guarantee</h3>
        <p>We offer bespoke adjustments until your garment fits flawlessly.</p>
      </div>
    </div>
  </div>
</section>

<!-- About Teaser -->
<section class="section bg-cream">
  <div class="section-inner" style="display:grid; grid-template-columns:1fr 1fr; gap:48px; align-items:center;">
    <div class="reveal" style="border-radius:8px; overflow:hidden; height:320px;">
      <img src="images/headerbanner.jpg" alt="Our craft" style="width:100%; height:100%; object-fit:cover;">
    </div>
    <div class="reveal">
      <div class="section-label" style="color:var(--gold); font-size:11px; letter-spacing:0.1em; text-transform:uppercase; margin-bottom:8px;">Our Story</div>
      <h2 style="margin-bottom:14px;">25 Years of Craftsmanship</h2>
      <p style="color:var(--mid); margin-bottom:14px;">Founded in 2000, Atelier Tailleur has been crafting bespoke garments with passion and precision. Every stitch tells a story — yours.</p>
      <a href="about.php" class="btn btn-dark">Learn More</a>
    </div>
  </div>
</section>
<section style="background: var(--dark); color: var(--cream); text-align:center; padding: 60px 24px;">
  <h2 style="margin-bottom:12px; color: var(--gold);">Ready to Get Started?</h2>
  <p style="margin-bottom:24px; opacity:0.75;">Book your consultation today and experience tailoring done right.</p>
  <a href="book.php" class="btn btn-primary">Book an Appointment</a>
</section>

<?php include 'footer.php'; ?>
