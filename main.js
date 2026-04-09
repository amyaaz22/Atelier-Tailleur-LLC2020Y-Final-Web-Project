/* ============================================================
   main.js — Atelier Tailleur
   JS / jQuery Features:
   1. Mobile nav toggle
   2. Scroll-reveal animation
   3. Services filter (jQuery)
   4. Portfolio lightbox (jQuery)
   5. Multi-step booking form + live price calculator
   6. Contact / Register form validation (jQuery)
   ============================================================ */

$(document).ready(function () {

  /* ---- 1. Mobile nav toggle ---- */
  $('#navToggle').on('click', function () {
    $('#mainNav').toggleClass('open');
  });

  /* ---- 2. Scroll-reveal animation ---- */
  function revealOnScroll() {
    $('.reveal').each(function () {
      var top = $(this).offset().top;
      var windowBottom = $(window).scrollTop() + $(window).height();
      if (top < windowBottom - 60) {
        $(this).addClass('visible');
      }
    });
  }
  revealOnScroll();
  $(window).on('scroll', revealOnScroll);

  /* ---- 3. Services category filter ---- */
  $('.filter-btn').on('click', function () {
    $('.filter-btn').removeClass('active');
    $(this).addClass('active');
    var cat = $(this).data('filter');
    if (cat === 'all') {
      $('.service-card').show();
    } else {
      $('.service-card').hide();
      $('.service-card[data-cat="' + cat + '"]').show();
    }
  });

  /* ---- 4. Portfolio lightbox ---- */
  $('.portfolio-item').on('click', function () {
    var title = $(this).data('title');
    var desc  = $(this).data('desc');
    var emoji = $(this).data('emoji');
    $('#lb-emoji').text(emoji);
    $('#lb-title').text(title);
    $('#lb-desc').text(desc);
    $('#lightbox').addClass('open');
  });
  $('#lb-close, #lightbox').on('click', function () {
    $('#lightbox').removeClass('open');
  });
  $('#lightbox .lightbox-box').on('click', function (e) { e.stopPropagation(); });

  /* ---- 5. Multi-step booking form ---- */
  var currentStep = 1;
  var totalSteps  = 3;

  window.goStep = function (n) {
    // Validate step 1 before advancing
    if (n > currentStep && currentStep === 1) {
      var ok = true;
      $('#step1 [required]').each(function () {
        if (!$(this).val().trim()) {
          $(this).addClass('field-error');
          ok = false;
        } else {
          $(this).removeClass('field-error');
        }
      });
      if (!ok) { alert('Please fill in all required fields.'); return; }
    }

    $('.form-step').removeClass('active');
    $('#step' + n).addClass('active');
    $('.step-label').removeClass('active done');
    for (var i = 1; i < n; i++) { $('#lbl' + i).addClass('done'); }
    $('#lbl' + n).addClass('active');
    currentStep = n;
    updateSummary();
  };

  /* Live price calculator */
  function updateSummary() {
    var service  = $('#bookService option:selected').text()  || '—';
    var price    = parseFloat($('#bookService option:selected').data('price')) || 0;
    var qty      = parseInt($('#bookQty').val()) || 1;
    var discount = $('#bookMember').is(':checked') ? 0.1 : 0;
    var subtotal = price * qty;
    var discAmt  = subtotal * discount;
    var total    = subtotal - discAmt;

    $('#sum-service').text(service);
    $('#sum-qty').text(qty);
    $('#sum-subtotal').text('Rs ' + subtotal.toFixed(2));
    $('#sum-discount').text(discount > 0 ? '- Rs ' + discAmt.toFixed(2) : 'None');
    $('#sum-total').text('Rs ' + total.toFixed(2));
    $('#bookTotal').val(total.toFixed(2));
  }

  $('#bookService, #bookQty').on('change input', updateSummary);
  $('#bookMember').on('change', updateSummary);

  /* ---- 6a. Contact form validation ---- */
  $('#contactForm').on('submit', function (e) {
    var ok = true;
    $(this).find('[required]').each(function () {
      var $err = $(this).next('.form-error');
      if (!$(this).val().trim()) {
        $(this).addClass('field-error');
        $err.addClass('visible');
        ok = false;
      } else {
        $(this).removeClass('field-error');
        $err.removeClass('visible');
      }
    });
    if (!ok) { e.preventDefault(); }
  });

  /* ---- 6b. Register form validation ---- */
  $('#registerForm').on('submit', function (e) {
    var pass  = $('#reg_password').val();
    var pass2 = $('#reg_password2').val();
    var ok = true;
    $(this).find('[required]').each(function () {
      if (!$(this).val().trim()) {
        $(this).addClass('field-error');
        ok = false;
      } else {
        $(this).removeClass('field-error');
      }
    });
    if (pass !== pass2) {
      $('#pass-mismatch').addClass('visible');
      ok = false;
    } else {
      $('#pass-mismatch').removeClass('visible');
    }
    if (!ok) { e.preventDefault(); }
  });

  /* ---- 6c. Login form validation ---- */
  $('#loginForm').on('submit', function (e) {
    var ok = true;
    $(this).find('[required]').each(function () {
      if (!$(this).val().trim()) {
        $(this).addClass('field-error');
        ok = false;
      } else {
        $(this).removeClass('field-error');
      }
    });
    if (!ok) { e.preventDefault(); }
  });

}); // end document.ready
