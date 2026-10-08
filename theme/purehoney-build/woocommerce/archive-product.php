<?php
/**
 * Shop Page Template Override
 * Replaces WooCommerce default shop layout with full custom design
 */
defined('ABSPATH') || exit;
get_header();
?>

<!-- Shop Header -->
<div class="ph-shop-header">
  <div class="ph-container">
    <?php woocommerce_breadcrumb(); ?>
    <h1><?php woocommerce_page_title(); ?></h1>
    <p>Discover our full collection of artisan honey accessories</p>
  </div>
</div>

<div class="ph-container" style="padding-bottom: 80px;">
  <div class="ph-shop-layout">

    <!-- Sidebar -->
    <aside class="ph-shop-sidebar">
      <!-- Categories -->
      <div class="ph-sidebar-widget">
        <h3>Collections</h3>
        <?php
        $cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0]);
        if ($cats && !is_wp_error($cats)):
          $current_cat = get_queried_object();
        ?>
        <ul class="widget_product_categories">
          <li style="padding:8px 0;border-bottom:1px solid rgba(255,255,255,0.04);">
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" style="color:<?php echo (!is_product_category()) ? 'var(--ph-gold)' : 'rgba(255,255,255,0.65)'; ?>;font-size:0.9rem;">All Products</a>
          </li>
          <?php foreach ($cats as $cat): ?>
          <li style="padding:8px 0;border-bottom:1px solid rgba(255,255,255,0.04);display:flex;justify-content:space-between;align-items:center;">
            <a href="<?php echo esc_url(get_term_link($cat)); ?>" style="color:<?php echo (is_product_category() && $current_cat->term_id === $cat->term_id) ? 'var(--ph-gold)' : 'rgba(255,255,255,0.65)'; ?>;font-size:0.9rem;transition:color 0.2s;"><?php echo esc_html($cat->name); ?></a>
            <span style="font-size:0.75rem;color:var(--ph-text-muted);background:rgba(255,255,255,0.05);padding:1px 7px;border-radius:20px;"><?php echo esc_html($cat->count); ?></span>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </div>

      <!-- Price filter -->
      <div class="ph-sidebar-widget">
        <h3>Price Range</h3>
        <?php the_widget('WC_Widget_Price_Filter'); ?>
      </div>

      <!-- Sort -->
      <div class="ph-sidebar-widget">
        <h3>Sort By</h3>
        <div style="display:flex;flex-direction:column;gap:6px;">
          <?php
          $sort_options = [
            ''           => 'Default',
            'popularity' => 'Most Popular',
            'rating'     => 'Top Rated',
            'price'      => 'Price: Low → High',
            'price-desc' => 'Price: High → Low',
            'date'       => 'Newest First',
          ];
          $current_orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : '';
          foreach ($sort_options as $val => $label):
            $url = add_query_arg('orderby', $val);
          ?>
          <a href="<?php echo esc_url($url); ?>" style="display:flex;align-items:center;gap:8px;padding:9px 12px;border-radius:6px;font-size:0.875rem;color:<?php echo $current_orderby === $val ? 'var(--ph-gold)' : 'rgba(255,255,255,0.55)'; ?>;background:<?php echo $current_orderby === $val ? 'rgba(212,175,55,0.1)' : 'transparent'; ?>;transition:all 0.2s;">
            <?php if ($current_orderby === $val): ?>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="var(--ph-gold)"><path d="M20 6 9 17l-5-5"/></svg>
            <?php else: ?>
            <span style="width:14px;"></span>
            <?php endif; ?>
            <?php echo esc_html($label); ?>
          </a>
          <?php endforeach; ?>
        </div>
      </div>
    </aside>

    <!-- Main Products Area -->
    <div class="ph-shop-main">
      <!-- Toolbar -->
      <div class="ph-shop-toolbar">
        <?php woocommerce_result_count(); ?>
        <?php woocommerce_catalog_ordering(); ?>
      </div>

      <?php if (woocommerce_product_loop()): ?>
        <div class="woocommerce">
          <?php
          woocommerce_product_loop_start();
          if (wc_get_loop_prop('total')) {
            while (have_posts()) {
              the_post();
              do_action('woocommerce_shop_loop');
              wc_get_template_part('content', 'product');
            }
          }
          woocommerce_product_loop_end();
          ?>
        </div>
        <?php woocommerce_pagination(); ?>
      <?php else: ?>
        <div style="text-align:center;padding:80px 0;">
          <div style="font-size:4rem;margin-bottom:20px;">🍯</div>
          <h3 style="color:white;margin-bottom:12px;">No products found</h3>
          <p style="color:var(--ph-text-muted);margin-bottom:28px;">Try adjusting your filters or browse all products.</p>
          <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="ph-btn ph-btn--outline">View All Products</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>
