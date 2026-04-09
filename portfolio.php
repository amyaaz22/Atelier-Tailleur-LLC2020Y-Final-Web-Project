<?php
session_start();
include 'header.php';
?>

<div class="page-hero">
  <h1>Portfolio</h1>
  <p>A selection of our finest creations</p>
  <div class="breadcrumb"><a href="index.php">Home</a> / Portfolio</div>
</div>

<section class="section">
  <div class="section-inner">

    <!-- Filter bar (jQuery) -->
    <div class="filter-bar">
      <button class="filter-btn active" data-filter="all">All</button>
      <button class="filter-btn" data-filter="suits">Suits</button>
      <button class="filter-btn" data-filter="gowns">Gowns</button>
      <button class="filter-btn" data-filter="bridal">Bridal</button>
      <button class="filter-btn" data-filter="alterations">Alterations</button>
    </div>

    <div class="portfolio-grid">

      <?php
      $items = [
        ['img'=>'images/mensuit.webp',          'title'=>'Charcoal Bespoke Suit',    'desc'=>'Hand-stitched three-piece suit with peak lapels and silk lining.',  'cat'=>'suits'],
        ['img'=>'images/eveninggown.avif',       'title'=>'Evening Gown',             'desc'=>'Flowing evening gown crafted for a special gala occasion.',          'cat'=>'gowns'],
        ['img'=>'images/weddingdress.webp',      'title'=>'Ivory Wedding Dress',      'desc'=>'Classic ivory lace bridal gown with a dramatic cathedral train.',    'cat'=>'bridal'],
        ['img'=>'images/headerbanner.jpg',       'title'=>'Casual Dress',             'desc'=>'Relaxed day dress styled for comfort and clean lines.',              'cat'=>'gowns'],
        ['img'=>'images/shirtalteration.jpg',    'title'=>'Shirt Alteration',         'desc'=>'Precision shirt alteration for a tailored, professional look.',      'cat'=>'alterations'],
        ['img'=>'images/trouseralteration.webp', 'title'=>'Trouser Fitting',          'desc'=>'Expert trouser hemming and waist adjustment service.',               'cat'=>'alterations'],
      ];
      foreach ($items as $item): ?>
      <div class="portfolio-item reveal"
           data-cat="<?= $item['cat'] ?>"
           data-title="<?= htmlspecialchars($item['title']) ?>"
           data-desc="<?= htmlspecialchars($item['desc']) ?>"
           data-img="<?= $item['img'] ?>">
        <div class="port-img" style="padding:0; overflow:hidden;">
          <img src="<?= $item['img'] ?>" alt="<?= htmlspecialchars($item['title']) ?>" style="width:100%; height:100%; object-fit:cover; transition:transform 0.3s;">
        </div>
        <div class="portfolio-overlay">
          <h4><?= htmlspecialchars($item['title']) ?></h4>
          <p><?= htmlspecialchars($item['desc']) ?></p>
        </div>
      </div>
      <?php endforeach; ?>

    </div>
  </div>
</section>

<!-- Lightbox -->
<div id="lightbox" class="lightbox">
  <div class="lightbox-box">
    <span class="lightbox-close" id="lb-close">&times;</span>
    <div style="height:200px; overflow:hidden; border-radius:6px; margin-bottom:16px;">
      <img id="lb-img" src="" alt="" style="width:100%; height:100%; object-fit:cover;">
    </div>
    <h3 id="lb-title"></h3>
    <p  id="lb-desc"></p>
    <a href="book.php" class="btn btn-primary" style="margin-top:14px;">Book This Style</a>
  </div>
</div>

<script>
$(document).ready(function(){
  $('.filter-btn').on('click', function(){
    $('.filter-btn').removeClass('active');
    $(this).addClass('active');
    var f = $(this).data('filter');
    if(f === 'all'){
      $('.portfolio-item').fadeIn(300);
    } else {
      $('.portfolio-item').hide();
      $('.portfolio-item[data-cat="'+f+'"]').fadeIn(300);
    }
  });

  $('.portfolio-item').on('click', function(){
    $('#lb-img').attr('src', $(this).data('img'));
    $('#lb-title').text($(this).data('title'));
    $('#lb-desc').text($(this).data('desc'));
    $('#lightbox').addClass('open');
  });
  $('#lb-close, #lightbox').on('click', function(){ $('#lightbox').removeClass('open'); });
  $('#lightbox .lightbox-box').on('click', function(e){ e.stopPropagation(); });
});
</script>

<?php include 'footer.php'; ?>
