<?php
session_start();
include 'header.php';
?>

<div class="page-hero">
  <h1>About Us</h1>
  <p>Our story, our craft, our passion</p>
  <div class="breadcrumb"><a href="index.php">Home</a> / About</div>
</div>

<section class="section">
  <div class="section-inner">
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items:center;">
      <div class="reveal">
        <div style="border-radius:8px; overflow:hidden; height:360px;">
          <img src="images/headerbanner.jpg" alt="Our Atelier" style="width:100%; height:100%; object-fit:cover;">
        </div>
      </div>
      <div class="reveal">
        <h2 style="margin-bottom:16px;">Master Tailors <span style="color:var(--gold)">Since 2000</span></h2>
        <p style="color:var(--mid); margin-bottom:14px;">Atelier Tailleur was founded with a simple belief — every garment should be as unique as the person wearing it. Based in Pailles, Port Louis, Mauritius, we have been crafting bespoke clothing for over 25 years.</p>
        <p style="color:var(--mid); margin-bottom:14px;">From hand-stitched suits to delicate bridal wear, our master tailors bring decades of combined experience to every piece they create.</p>
        <a href="book.php" class="btn btn-primary">Book a Consultation</a>
      </div>
    </div>
  </div>
</section>

<section class="section bg-cream">
  <div class="section-inner">
    <div class="section-title">
      <h2>Our Journey</h2>
      <div class="line"></div>
    </div>
    <div style="max-width:600px; margin:0 auto;" class="reveal">
      <div class="timeline">
        <div class="tl-item">
          <div class="tl-dot"></div>
          <h4>2000 — Founded</h4>
          <p>Atelier Tailleur opened its first studio in Pailles, Port Louis with a team of three tailors.</p>
        </div>
        <div class="tl-item">
          <div class="tl-dot"></div>
          <h4>2005 — Expanded Services</h4>
          <p>Added bridal and evening wear to our portfolio, attracting clients from across the island.</p>
        </div>
        <div class="tl-item">
          <div class="tl-dot"></div>
          <h4>2012 — Upscaled Production</h4>
          <p>Expanded our studio with new equipment and a larger team to meet growing demand across the island.</p>
        </div>
        <div class="tl-item">
          <div class="tl-dot"></div>
          <h4>2024 — Online Booking</h4>
          <p>Launched our online booking platform so clients can schedule fittings from anywhere.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Team Section -->
<section class="section">
  <div class="section-inner">
    <div class="section-title">
      <h2>Meet the Team</h2>
      <div class="line"></div>
    </div>
    <div class="cards-grid">
      <div class="card reveal" style="text-align:center; padding:28px;">
        <div style="height:160px; overflow:hidden; border-radius:6px; margin-bottom:14px;">
          <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop&crop=face" alt="Moosan Aumeer" style="width:100%; height:100%; object-fit:cover;">
        </div>
        <h3>Moosan Aumeer</h3>
        <p style="color:var(--gold); font-size:13px; margin-bottom:8px;">Head Tailor &amp; Founder</p>
        <p>30 years of bespoke tailoring experience across Europe and the Indian Ocean.</p>
      </div>
      <div class="card reveal" style="text-align:center; padding:28px;">
        <div style="height:160px; overflow:hidden; border-radius:6px; margin-bottom:14px;">
          <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=400&fit=crop&crop=face" alt="Tahera Beekharry" style="width:100%; height:100%; object-fit:cover;">
        </div>
        <h3>Tahera Beekharry</h3>
        <p style="color:var(--gold); font-size:13px; margin-bottom:8px;">Women's Dress Specialist</p>
        <p>Expert in bridal gowns and haute couture with a passion for detail and fabric.</p>
      </div>
      <div class="card reveal" style="text-align:center; padding:28px;">
        <div style="height:160px; overflow:hidden; border-radius:6px; margin-bottom:14px;">
          <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=400&fit=crop&crop=face" alt="Amyaaz Aumeer" style="width:100%; height:100%; object-fit:cover;">
        </div>
        <h3>Amyaaz Aumeer</h3>
        <p style="color:var(--gold); font-size:13px; margin-bottom:8px;">Operations Manager</p>
        <p>Ensures every client experience runs smoothly from booking to final fitting.</p>
      </div>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
