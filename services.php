<?php
session_start();
include 'header.php';
include 'db_connect.php';

$result = mysqli_query($conn, "SELECT * FROM services ORDER BY category, name");
$services = [];
while ($row = mysqli_fetch_assoc($result)) {
    $services[] = $row;
}
?>

<div class="page-hero">
  <h1>Our Services</h1>
  <p>Tailored to perfection — browse our full range</p>
  <div class="breadcrumb"><a href="index.php">Home</a> / Services</div>
</div>

<section class="section">
  <div class="section-inner">

    <!-- JS Filter bar -->
    <div class="filter-bar">
      <button class="filter-btn active" data-filter="all">All</button>
      <button class="filter-btn" data-filter="Suits">Suits</button>
      <button class="filter-btn" data-filter="Gowns">Gowns</button>
      <button class="filter-btn" data-filter="Bridal">Bridal</button>
      <button class="filter-btn" data-filter="Casual">Casual</button>
      <button class="filter-btn" data-filter="Alterations">Alterations</button>
    </div>

    <div class="cards-grid">
      <?php
      $emojis = ['Suits'=>'🧥','Gowns'=>'👗','Bridal'=>'💍','Casual'=>'🥻','Alterations'=>'✂️'];
      $imgs   = [
        'Suits'       => 'images/mensuit.webp',
        'Gowns'       => 'images/eveninggown.avif',
        'Bridal'      => 'images/weddingdress.webp',
        'Casual'      => 'images/trouseralteration.webp',
        'Alterations' => 'images/shirtalteration.jpg',
      ];
      foreach ($services as $s):
        $cat   = htmlspecialchars($s['category']);
        $img   = isset($imgs[$cat]) ? $imgs[$cat] : null;
      ?>
      <div class="card service-card reveal" data-cat="<?= $cat ?>">
        <div class="card-img" style="padding:0; overflow:hidden;">
          <?php if ($img): ?>
            <img src="<?= $img ?>" alt="<?= $cat ?>" style="width:100%; height:100%; object-fit:cover;">
          <?php else: ?>
            ✂️
          <?php endif; ?>
        </div>
        <div class="card-body">
          <h3><?= htmlspecialchars($s['name']) ?></h3>
          <p><?= htmlspecialchars($s['description']) ?></p>
          <div class="card-price">Rs <?= number_format($s['price'], 2) ?></div>
          <div style="margin-top:10px; display:flex; gap:8px; flex-wrap:wrap;">
            <span style="font-size:11px; padding:3px 10px; border-radius:12px; background:var(--cream); border:1px solid var(--border); color:var(--mid);"><?= $cat ?></span>
            <a href="book.php?service=<?= $s['id'] ?>" class="btn btn-primary btn-sm">Book</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<?php include 'footer.php'; ?>
