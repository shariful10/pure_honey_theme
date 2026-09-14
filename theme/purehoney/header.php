<?php defined('ABSPATH') || exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png" type="image/png">
<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$custom_logo_id = get_theme_mod('custom_logo');
$logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
?>

<!-- Loader -->
<div id="ph-loader" class="ph-loader" aria-hidden="true">
  <div class="ph-loader__inner">
    <div class="ph-loader__logo">
      <?php if (has_custom_logo() && $logo_url): ?>
        <img src="<?php echo esc_url($logo_url); ?>" alt="<?php bloginfo('name'); ?>" style="height:60px; width:auto;">
      <?php else: ?>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="PureHoney" style="height:60px; width:auto;">
      <?php endif; ?>
    </div>
    <div class="ph-loader__bar"></div>
  </div>
</div>

<!-- ════════════ HEADER ════════════ -->
<header id="ph-header" class="ph-header <?php echo is_front_page() ? 'ph-header--transparent' : 'ph-header--scrolled'; ?>" role="banner">
  <div class="ph-header__inner ph-container">

    <!-- Logo -->
    <a href="<?php echo esc_url(home_url('/')); ?>" class="ph-logo" rel="home" aria-label="<?php bloginfo('name'); ?> – Home">
      <?php 
      if (has_custom_logo() && $logo_url): ?>
        <img src="<?php echo esc_url($logo_url); ?>" alt="<?php bloginfo('name'); ?>" style="height:48px; width:auto; display:block;">
      <?php else: ?>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="PureHoney" style="height:48px; width:auto; display:block;">
      <?php endif; ?>
    </a>

    <!-- Nav -->
    <nav class="ph-nav-wrapper" role="navigation" aria-label="Primary">
      <?php wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'ph-nav',
        'fallback_cb'    => function() {
          echo '<ul class="ph-nav">';
          echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
          if (function_exists('wc_get_page_permalink')) {
            echo '<li><a href="' . esc_url(wc_get_page_permalink('shop')) . '">Shop</a></li>';
          }
          echo '<li><a href="' . esc_url(home_url('/about-us')) . '">About</a></li>';
          echo '<li><a href="' . esc_url(home_url('/contact-us')) . '">Contact</a></li>';
          echo '</ul>';
        },
      ]); ?>
    </nav>

    <!-- Actions -->
    <div class="ph-header__actions">

      <!-- Search -->
      <button class="ph-header__btn" data-search-toggle aria-label="Search" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      </button>

      <!-- Account -->
      <?php if (function_exists('wc_get_account_endpoint_url')): ?>
      <a href="<?php echo esc_url(wc_get_account_endpoint_url('dashboard')); ?>" class="ph-header__btn" aria-label="My Account">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      </a>
      <?php endif; ?>

      <!-- Cart -->
      <?php if (function_exists('WC')): ?>
      <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="ph-header__btn" aria-label="Cart">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" x2="21" y1="6" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        <?php $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
        <span class="ph-cart-count" <?php echo $count === 0 ? 'style="display:none"' : ''; ?>><?php echo esc_html($count); ?></span>
      </a>
      <?php endif; ?>

      <!-- Hamburger -->
      <button id="ph-hamburger" class="ph-hamburger" aria-label="Open menu" aria-expanded="false" aria-controls="ph-mobile-menu">
        <span></span><span></span><span></span>
      </button>

    </div>
  </div>

  <!-- Search Overlay -->
  <div id="ph-search-overlay" class="ph-search-overlay" role="search" aria-hidden="true">
    <div class="ph-container" style="position:relative;display:flex;align-items:center;gap:16px;">
      <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="ph-search-form" style="flex:1;">
        <label for="ph-search-input" class="screen-reader-text">Search</label>
        <input type="search" id="ph-search-input" name="s" placeholder="Search honey dispensers, gift sets…" autocomplete="off">
        <input type="hidden" name="post_type" value="product">
        <button type="submit" aria-label="Search">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        </button>
      </form>
      <button id="ph-search-close" class="ph-search-close" aria-label="Close search">✕</button>
    </div>
  </div>
</header>

<!-- Mobile Menu -->
<div id="ph-mobile-menu" class="ph-mobile-menu" role="dialog" aria-modal="true" aria-label="Mobile menu">
  <div class="ph-mobile-menu__header">
    <span class="ph-logo">Pure<span>Honey</span></span>
    <button id="ph-mobile-close" class="ph-mobile-menu__close" aria-label="Close">✕</button>
  </div>
  <nav class="ph-mobile-menu__nav">
    <?php wp_nav_menu([
      'theme_location' => 'primary',
      'container'      => false,
      'menu_class'     => '',
      'fallback_cb'    => function() {
        echo '<ul>';
        echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
        if (function_exists('wc_get_page_permalink')) {
          echo '<li><a href="' . esc_url(wc_get_page_permalink('shop')) . '">Shop</a></li>';
        }
        echo '<li><a href="' . esc_url(home_url('/about-us')) . '">About Us</a></li>';
        echo '<li><a href="' . esc_url(home_url('/contact-us')) . '">Contact</a></li>';
        echo '</ul>';
      },
    ]); ?>
  </nav>
  <?php if (function_exists('wc_get_page_permalink')): ?>
  <div class="ph-mobile-menu__footer">
    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="ph-btn ph-btn--primary" style="width:100%;justify-content:center;">
      Shop Now →
    </a>
  </div>
  <?php endif; ?>
</div>
<div id="ph-mobile-overlay" class="ph-mobile-overlay" aria-hidden="true"></div>

<!-- Page Wrapper -->
<div id="page" class="site">
<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e('Skip to content', 'purehoney'); ?></a>
<main id="main" class="site-main" role="main">
