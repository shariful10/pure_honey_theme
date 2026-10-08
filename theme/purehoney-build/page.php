<?php
/**
 * PureHoney – page.php
 * Handles all regular pages including WooCommerce shortcode pages
 */
defined('ABSPATH') || exit;
get_header();

// Detect WooCommerce pages
$is_woo_page    = function_exists('WC') && (is_cart() || is_checkout() || is_account_page() || is_order_received_page());
$is_checkout    = function_exists('is_checkout') && is_checkout() && !is_order_received_page();
$is_cart        = function_exists('is_cart') && is_cart();
$is_order_recv  = function_exists('is_order_received_page') && is_order_received_page();
?>

<?php if ($is_woo_page): ?>
<!-- WooCommerce Page with our design wrapper -->
<div class="ph-page-wrap ph-woo-page">

  <?php if ($is_checkout): ?>
  <!-- Checkout hero -->
  <div class="ph-page-hero ph-page-hero--sm">
    <div class="ph-container">
      <nav class="ph-breadcrumb" aria-label="Breadcrumb">
        <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
        <span>›</span>
        <a href="<?php echo esc_url(wc_get_cart_url()); ?>">Cart</a>
        <span>›</span>
        <span>Checkout</span>
      </nav>
      <h1 class="ph-page-title">Checkout</h1>
    </div>
  </div>

  <?php elseif ($is_cart): ?>
  <!-- Cart hero -->
  <div class="ph-page-hero ph-page-hero--sm">
    <div class="ph-container">
      <h1 class="ph-page-title">
        Shopping Cart
        <?php if (function_exists('WC') && WC()->cart->get_cart_contents_count() > 0): ?>
        <span class="ph-cart-badge"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        <?php endif; ?>
      </h1>
    </div>
  </div>

  <?php elseif ($is_order_recv): ?>
  <!-- Order confirmation hero -->
  <div class="ph-page-hero ph-page-hero--sm">
    <div class="ph-container">
      <h1 class="ph-page-title">Order Confirmed 🎉</h1>
    </div>
  </div>

  <?php else: ?>
  <!-- Account hero -->
  <div class="ph-page-hero ph-page-hero--sm">
    <div class="ph-container">
      <h1 class="ph-page-title"><?php the_title(); ?></h1>
    </div>
  </div>
  <?php endif; ?>

  <!-- WooCommerce content wrapped in 1140px container -->
  <div class="ph-container ph-woo-content">
    <?php while (have_posts()): the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; ?>
  </div>

</div>

<?php else: ?>
<!-- Regular Page -->
<div class="ph-page-wrap">
  <div class="ph-page-hero">
    <div class="ph-container">
      <?php the_title('<h1 class="ph-page-title">', '</h1>'); ?>
    </div>
  </div>
  <div class="ph-section">
    <div class="ph-container" style="padding: 80px 0 100px;">
      <div class="ph-content-wrap">
        <?php while (have_posts()): the_post(); ?>
          <?php the_content(); ?>
          <?php
          $link = get_edit_post_link();
          if ($link): ?>
          <div class="ph-edit-link"><a href="<?php echo esc_url($link); ?>">Edit this page</a></div>
          <?php endif; ?>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<?php get_footer(); ?>

