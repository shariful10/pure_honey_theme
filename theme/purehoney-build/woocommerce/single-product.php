<?php
/**
 * Single Product Page Template
 */
defined('ABSPATH') || exit;
get_header();
?>
<div class="ph-container ph-single-product">
  <?php woocommerce_breadcrumb(); ?>

  <?php while (have_posts()): the_post(); ?>

  <div class="woocommerce">
    <?php wc_get_template_part('content', 'single-product'); ?>
  </div>

  <!-- Product Trust Badges (injected below add-to-cart via hook) -->

  <?php endwhile; ?>
</div>
<?php get_footer(); ?>
