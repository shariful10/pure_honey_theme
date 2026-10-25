<?php
/**
 * Template part for displaying a product card
 * PureHoney Avoraix-Style High-Converting Product Card Fallback
 */

defined('ABSPATH') || exit;

global $product, $post;

if (empty($product) && function_exists('wc_get_product')) {
    $product = wc_get_product(get_the_ID());
}

$is_on_sale = false;
$save_badge = '';
if ($product && method_exists($product, 'is_on_sale')) {
    $is_on_sale = $product->is_on_sale();
    if ($is_on_sale) {
        $reg = (float)$product->get_regular_price();
        $sale = (float)$product->get_sale_price();
        if ($reg > $sale) {
            $save_badge = 'Save $' . number_format($reg - $sale, 2);
        }
    }
}

$cat_name = 'HONEY ESSENTIAL';
if ($product) {
    $terms = get_the_terms($product->get_id(), 'product_cat');
    if ($terms && !is_wp_error($terms)) {
        $cat_name = $terms[0]->name;
    }
}
?>
<li <?php if (function_exists('wc_product_class')) { wc_product_class('ph-product-card', $product); } else { post_class('ph-product-card product'); } ?>>
    <div class="ph-card-inner">
        <!-- Thumbnail Wrap with Badges -->
        <div class="ph-card-media">
            <div class="ph-card-badges">
                <?php if ($is_on_sale): ?>
                    <span class="ph-badge-sale">Sale!</span>
                    <?php if ($save_badge): ?>
                        <span class="ph-badge-save"><?php echo esc_html($save_badge); ?></span>
                    <?php endif; ?>
                <?php else: ?>
                    <span class="ph-badge-save ph-badge-save--natural">100% Pure</span>
                <?php endif; ?>
            </div>

            <a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link ph-card-img-link">
                <?php
                if (function_exists('woocommerce_template_loop_product_thumbnail')) {
                    woocommerce_template_loop_product_thumbnail();
                } elseif (has_post_thumbnail()) {
                    the_post_thumbnail('woocommerce_thumbnail');
                } else {
                    echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/cat-dispensers.jpg') . '" alt="' . esc_attr(get_the_title()) . '" loading="lazy">';
                }
                ?>
            </a>

            <div class="ph-card-quick-add">
                <?php
                if (function_exists('woocommerce_template_loop_add_to_cart')) {
                    woocommerce_template_loop_add_to_cart();
                } else {
                    echo '<a href="' . esc_url(get_permalink()) . '" class="button add_to_cart_button">Add to Cart</a>';
                }
                ?>
            </div>
        </div>

        <!-- Product Details -->
        <div class="ph-card-content">
            <div class="ph-card-category"><?php echo esc_html(strtoupper($cat_name)); ?></div>

            <h3 class="ph-card-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>

            <div class="ph-card-rating">
                <div class="ph-stars" aria-label="5 out of 5 stars">★★★★★</div>
                <span class="ph-rating-count">(4.9)</span>
            </div>

            <div class="ph-card-price">
                <?php 
                if (class_exists('WooCommerce') && !empty($product)) {
                    echo $product->get_price_html();
                } else {
                    $price = get_post_meta(get_the_ID(), '_product_price', true) ?: get_post_meta(get_the_ID(), 'price', true);
                    echo esc_html($price ? '$' . number_format((float)$price, 2) : '$34.99');
                }
                ?>
            </div>

            <div class="ph-card-stock">
                <span class="ph-dot-stock"></span>
                <span class="ph-stock-text">In stock for delivery • Free Home Delivery</span>
            </div>

            <div class="ph-card-btn-wrap">
                <?php
                if (function_exists('woocommerce_template_loop_add_to_cart')) {
                    woocommerce_template_loop_add_to_cart();
                } else {
                    echo '<a href="' . esc_url(get_permalink()) . '" class="ph-btn-card-add">Add to Cart →</a>';
                }
                ?>
            </div>
        </div>
    </div>
</li>
