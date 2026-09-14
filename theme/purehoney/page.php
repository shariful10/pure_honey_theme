<?php
/**
 * PureHoney – page.php
 * Handles all regular pages including WooCommerce shortcode pages
 */
defined('ABSPATH') || exit;
get_header();

// For WooCommerce pages, render content directly (shortcodes need no wrapper)
$is_woo_page = function_exists('WC') && (is_cart() || is_checkout() || is_account_page() || is_order_received_page());
?>

<?php if ($is_woo_page): ?>
  <?php while (have_posts()): the_post(); ?>
    <?php the_content(); ?>
  <?php endwhile; ?>

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
