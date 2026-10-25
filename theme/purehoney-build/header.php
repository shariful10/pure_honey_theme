<?php defined('ABSPATH') || exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<?php wp_head(); ?>
<link rel="icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/images/favicon.jpg?v=3.4.0'); ?>" type="image/jpeg">
<link rel="apple-touch-icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/images/favicon.jpg?v=3.4.0'); ?>">
<!-- Emergency failsafe: if JS is broken or slow, ensure loader never permanently blocks the page -->
<noscript><style>#ph-loader{display:none!important}</style></noscript>
<style>
/* Elementor visual editor compatibility: prevent preloader from blocking editor canvas */
body.elementor-editor-active #ph-loader,
body.elementor-editor-preview #ph-loader,
.elementor-editor-active #ph-loader {
  display: none !important;
}
</style>
<script>
/* Inline early-exit loader script — runs before main.js is parsed.
   Ensures page is never permanently white even if main.js errors out. */
(function(){
  var TIMEOUT_MS = 3500;
  function emergencyHide(){
    var el = document.getElementById('ph-loader');
    if(el){ el.style.display='none'; }
    document.body && document.body.classList.add('ph-loaded');
  }
  // Absolute fallback: force-hide at TIMEOUT_MS
  setTimeout(emergencyHide, TIMEOUT_MS);
  // Also hook window.load in case main.js never runs
  window.addEventListener('load', function(){
    setTimeout(emergencyHide, 600);
  });
})();
</script>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$custom_logo_id = get_theme_mod('custom_logo');
$logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
$ph_ver = defined('PUREHONEY_VERSION') ? PUREHONEY_VERSION : '3.4.0';
$default_logo = get_template_directory_uri() . '/assets/images/logo-dark-text.png?v=' . $ph_ver;
?>

<!-- Loader -->
<div id="ph-loader" class="ph-loader" aria-hidden="true">
  <div class="ph-loader__inner">
    <div class="ph-loader__logo">
      <?php if (has_custom_logo() && $logo_url): ?>
        <img src="<?php echo esc_url($logo_url); ?>" alt="<?php bloginfo('name'); ?>" style="height:50px; width:auto;"
             onerror="this.style.display='none';this.nextElementSibling.style.display='inline-flex';">
        <span style="display:none;font-family:var(--font-heading,serif);font-size:2rem;font-weight:700;color:#1C1917;letter-spacing:-0.02em;">Pure<span style="color:#D97706;">Honey</span></span>
      <?php else: ?>
        <img src="<?php echo esc_url($default_logo); ?>" alt="PureHoney" width="180" height="50" style="height:50px; width:auto;"
             onerror="this.style.display='none';this.nextElementSibling.style.display='inline-flex';">
        <span style="display:none;font-family:var(--font-heading,serif);font-size:2rem;font-weight:700;color:#1C1917;letter-spacing:-0.02em;">Pure<span style="color:#D97706;">Honey</span></span>
      <?php endif; ?>
    </div>
    <div class="ph-loader__bar"></div>
  </div>
</div>

<!-- Top Announcement Bar -->
<div class="ph-topbar" role="region" aria-label="Announcement">
  <div class="ph-container ph-topbar__inner">
    <span>🌿 Nature's Purest Raw Honey • Free Home Delivery on orders over $60 • 100% Satisfaction Guaranteed</span>
    <div class="ph-topbar__links">
      <a href="<?php echo esc_url(home_url('/track-order')); ?>">Track Order</a>
      <span class="ph-topbar__sep">|</span>
      <a href="<?php echo esc_url(home_url('/contact-us')); ?>">Help & Support</a>
    </div>
  </div>
</div>

<!-- ════════════ HEADER (Avoraix Style) ════════════ -->
<header id="ph-header" class="ph-header ph-header--white" role="banner">
  <!-- Main Row: Logo, Center Search with Category, Right Actions -->
  <div class="ph-header__main">
    <div class="ph-container ph-header__inner">

      <!-- Logo -->
      <a href="<?php echo esc_url(home_url('/')); ?>" class="ph-logo" rel="home" aria-label="<?php bloginfo('name'); ?> – Home">
        <?php if (has_custom_logo() && $logo_url): ?>
          <img src="<?php echo esc_url($logo_url); ?>" alt="<?php bloginfo('name'); ?>" style="height:42px; width:auto; display:block;">
        <?php else: ?>
          <img src="<?php echo esc_url($default_logo); ?>" alt="PureHoney" width="160" height="42" style="height:42px; width:auto; display:block;" onerror="this.style.display='none';this.nextElementSibling.style.display='inline-flex';">
          <span class="ph-logo-fallback" style="display:none; align-items:center; gap:8px;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 2L20.5 7V17L12 22L3.5 17V7L12 2Z" stroke="#D97706" stroke-width="2" stroke-linejoin="round"/>
              <path d="M12 7C12 7 8 11.5 8 14C8 16.2091 9.79086 18 12 18C14.2091 18 16 16.2091 16 14C16 11.5 12 7 12 7Z" fill="#D97706"/>
            </svg>
            <span style="font-family:var(--font-heading,sans-serif); font-size:1.5rem; font-weight:700; color:#1E1E1E; letter-spacing:-0.02em;">Pure<span style="color:#D97706;">Honey</span></span>
          </span>
        <?php endif; ?>
      </a>

      <!-- Centered Search Bar with Category Dropdown -->
      <div class="ph-header__search">
        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="ph-search-bar">
          <div class="ph-search-bar__cat-wrap">
            <label for="ph-header-cat" class="screen-reader-text">Category</label>
            <select id="ph-header-cat" name="product_cat" class="ph-search-bar__cat">
              <option value="">All Categories</option>
              <option value="essentials">Essentials</option>
              <option value="honey-dispensers">Dispensers</option>
              <option value="gift-boxes">Gift Box</option>
              <option value="handpicked-honey">Handpicked</option>
            </select>
          </div>
          <span class="ph-search-bar__divider"></span>
          <label for="ph-main-search-input" class="screen-reader-text">Search</label>
          <input type="search" id="ph-main-search-input" name="s" class="ph-search-bar__input" placeholder="Search for honey, dispensers, gifts..." autocomplete="off">
          <input type="hidden" name="post_type" value="product">
          <button type="submit" class="ph-search-bar__btn" aria-label="Search">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
              <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
          </button>
        </form>
      </div>

      <!-- Right-Aligned Action Icons -->
      <div class="ph-header__actions">
        <!-- Wishlist -->
        <a href="<?php echo esc_url(home_url('/wishlist')); ?>" class="ph-action-link ph-action-link--wishlist" aria-label="Wishlist">
          <span class="ph-action-icon-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
            </svg>
            <span class="ph-badge-pill">0</span>
          </span>
          <span class="ph-action-text">Wishlist</span>
        </a>

        <!-- My Account / Login -->
        <?php
        $account_url = function_exists('wc_get_account_endpoint_url') ? wc_get_account_endpoint_url('dashboard') : home_url('/my-account');
        ?>
        <a href="<?php echo esc_url($account_url); ?>" class="ph-action-link ph-action-link--account" aria-label="My Account">
          <span class="ph-action-icon-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
          </span>
          <span class="ph-action-text">Account</span>
        </a>

        <!-- Cart Counter Pill with Subtotal (Cart / $0.00) -->
        <?php
        $cart_count = 0;
        $cart_total = '$0.00';
        if (function_exists('WC') && WC()->cart) {
          $cart_count = WC()->cart->get_cart_contents_count();
          $cart_total = WC()->cart->get_cart_subtotal();
        }
        $cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart');
        ?>
        <a href="<?php echo esc_url($cart_url); ?>" class="ph-cart-pill" aria-label="View shopping cart">
          <div class="ph-cart-pill__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" x2="21" y1="6" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>
            </svg>
            <span class="ph-cart-pill__badge"><?php echo esc_html($cart_count); ?></span>
          </div>
          <div class="ph-cart-pill__info">
            <span class="ph-cart-pill__label">Cart /</span>
            <span class="ph-cart-pill__amount"><?php echo wp_kses_post($cart_total); ?></span>
          </div>
        </a>

        <!-- Mobile Hamburger Toggle -->
        <button id="ph-hamburger" class="ph-hamburger" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="ph-mobile-menu">
          <span></span><span></span><span></span>
        </button>

      </div>
    </div>
  </div>

  <!-- Category Nav Strip: Secondary Horizontal Bar -->
  <nav class="ph-nav-strip" role="navigation" aria-label="Categories">
    <div class="ph-container ph-nav-strip__inner">
      <ul class="ph-cat-links">
        <?php
        $shop_link = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop');
        $essentials_link = function_exists('get_term_link') ? get_term_link('essentials', 'product_cat') : home_url('/product-category/essentials');
        if (is_wp_error($essentials_link)) $essentials_link = $shop_link . '?category=essentials';
        $gift_link = function_exists('get_term_link') ? get_term_link('gift-boxes', 'product_cat') : home_url('/product-category/gift-boxes');
        if (is_wp_error($gift_link)) $gift_link = $shop_link . '?category=gift-boxes';
        $dispensers_link = function_exists('get_term_link') ? get_term_link('honey-dispensers', 'product_cat') : home_url('/product-category/honey-dispensers');
        if (is_wp_error($dispensers_link)) $dispensers_link = $shop_link . '?category=honey-dispensers';
        $handpicked_link = function_exists('get_term_link') ? get_term_link('handpicked-honey', 'product_cat') : home_url('/product-category/handpicked-honey');
        if (is_wp_error($handpicked_link)) $handpicked_link = $shop_link . '?category=handpicked-honey';
        $track_link = home_url('/track-order');
        ?>
        <li class="<?php echo (is_shop() && !is_product_category()) ? 'is-active' : ''; ?>">
          <a href="<?php echo esc_url($shop_link); ?>">SHOP</a>
        </li>
        <li class="<?php echo (is_product_category('essentials')) ? 'is-active' : ''; ?>">
          <a href="<?php echo esc_url($essentials_link); ?>">ESSENTIALS</a>
        </li>
        <li class="<?php echo (is_product_category('gift-boxes')) ? 'is-active' : ''; ?>">
          <a href="<?php echo esc_url($gift_link); ?>">GIFT BOX</a>
        </li>
        <li class="<?php echo (is_product_category('honey-dispensers')) ? 'is-active' : ''; ?>">
          <a href="<?php echo esc_url($dispensers_link); ?>">DISPENSERS</a>
        </li>
        <li class="<?php echo (is_product_category('handpicked-honey')) ? 'is-active' : ''; ?>">
          <a href="<?php echo esc_url($handpicked_link); ?>">HANDPICKED</a>
        </li>
        <li>
          <a href="<?php echo esc_url($track_link); ?>">TRACK ORDER</a>
        </li>
      </ul>
      <div class="ph-nav-strip__badge">
        <span class="ph-dot-live"></span> <span>24H Dispatch Available</span>
      </div>
    </div>
  </nav>
</header>

<!-- Mobile Navigation Drawer -->
<div id="ph-mobile-menu" class="ph-mobile-menu" role="dialog" aria-modal="true" aria-label="Mobile navigation">
  <div class="ph-mobile-menu__header">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="ph-mobile-logo">
      <span style="font-family:var(--font-heading,sans-serif); font-size:1.4rem; font-weight:700; color:#1E1E1E;">Pure<span style="color:#D97706;">Honey</span></span>
    </a>
    <button id="ph-mobile-close" class="ph-mobile-menu__close" aria-label="Close menu">✕</button>
  </div>

  <div class="ph-mobile-menu__search">
    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
      <input type="search" name="s" placeholder="Search honey, dispensers..." autocomplete="off">
      <input type="hidden" name="post_type" value="product">
      <button type="submit" aria-label="Search">🔍</button>
    </form>
  </div>

  <nav class="ph-mobile-menu__nav">
    <div class="ph-mobile-section-title">CATEGORIES</div>
    <ul>
      <li><a href="<?php echo esc_url($shop_link); ?>">🛍️ All Products (Shop)</a></li>
      <li><a href="<?php echo esc_url($essentials_link); ?>">✨ Essentials</a></li>
      <li><a href="<?php echo esc_url($gift_link); ?>">🎁 Gift Box</a></li>
      <li><a href="<?php echo esc_url($dispensers_link); ?>">🍯 Honey Dispensers</a></li>
      <li><a href="<?php echo esc_url($handpicked_link); ?>">🌿 Handpicked Honey</a></li>
      <li><a href="<?php echo esc_url($track_link); ?>">📦 Track Order</a></li>
    </ul>

    <div class="ph-mobile-section-title" style="margin-top:20px;">CUSTOMER CARE</div>
    <ul>
      <li><a href="<?php echo esc_url(home_url('/about-us')); ?>">Our Story & Values</a></li>
      <li><a href="<?php echo esc_url(home_url('/contact-us')); ?>">Contact Customer Support</a></li>
      <li><a href="<?php echo esc_url($account_url); ?>">My Account / Login</a></li>
      <li><a href="<?php echo esc_url(home_url('/wishlist')); ?>">Saved Wishlist</a></li>
    </ul>
  </nav>

  <div class="ph-mobile-menu__footer">
    <div class="ph-mobile-contact">
      <p>📞 <strong>+1 (800) 555-PURE</strong></p>
      <p>✉️ support@purehoney.me</p>
    </div>
    <a href="<?php echo esc_url($shop_link); ?>" class="ph-btn ph-btn--primary" style="width:100%;justify-content:center;margin-top:12px;">
      Explore Store →
    </a>
  </div>
</div>
<div id="ph-mobile-overlay" class="ph-mobile-overlay" aria-hidden="true"></div>

<!-- Page Wrapper -->
<div id="page" class="site">
<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e('Skip to content', 'purehoney'); ?></a>
<main id="main" class="site-main" role="main">
