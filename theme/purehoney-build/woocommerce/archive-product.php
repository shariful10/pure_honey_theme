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
      <div class="ph-sidebar-widget filter-card">
        <h3>Collections</h3>
        <?php
        $cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0]);
        if ($cats && !is_wp_error($cats)):
          $current_cat = get_queried_object();
        ?>
        <ul class="widget_product_categories">
          <li style="padding:10px 0;border-bottom:1px solid var(--border-subtle, #EFE6D8);">
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" style="color:<?php echo (!is_product_category()) ? '#D97706' : '#292524'; ?>;font-size:0.95rem;font-weight:<?php echo (!is_product_category()) ? '600' : '500'; ?>;transition:color 0.2s ease;">All Products</a>
          </li>
          <?php foreach ($cats as $cat): 
            $is_active = (is_product_category() && $current_cat && isset($current_cat->term_id) && $current_cat->term_id === $cat->term_id);
          ?>
          <li style="padding:10px 0;border-bottom:1px solid var(--border-subtle, #EFE6D8);display:flex;justify-content:space-between;align-items:center;">
            <a href="<?php echo esc_url(get_term_link($cat)); ?>" style="color:<?php echo $is_active ? '#D97706' : '#292524'; ?>;font-size:0.95rem;font-weight:<?php echo $is_active ? '600' : '500'; ?>;transition:color 0.2s ease;"><?php echo esc_html($cat->name); ?></a>
            <span class="filter-count" style="font-size:0.875rem;color:#78716C;background:#F5EFE6;padding:2px 8px;border-radius:20px;font-weight:500;"><?php echo esc_html($cat->count); ?></span>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </div>

      <!-- Price filter -->
      <div class="ph-sidebar-widget filter-card">
        <h3>Price Range</h3>
        <?php the_widget('WC_Widget_Price_Filter'); ?>
      </div>

      <!-- Sort -->
      <div class="ph-sidebar-widget filter-card">
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
            $is_current = ($current_orderby === $val);
            $url = add_query_arg('orderby', $val);
          ?>
          <a href="<?php echo esc_url($url); ?>" style="display:flex;align-items:center;gap:8px;padding:9px 12px;border-radius:6px;font-size:0.95rem;font-weight:<?php echo $is_current ? '600' : '500'; ?>;color:<?php echo $is_current ? '#D97706' : '#292524'; ?>;background:<?php echo $is_current ? '#FDF3E3' : 'transparent'; ?>;transition:all 0.2s ease;">
            <?php if ($is_current): ?>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="#D97706"><path d="M20 6 9 17l-5-5"/></svg>
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
