<?php
/**
 * Template part for displaying a product card
 * PureHoney Theme
 */

defined('ABSPATH') || exit;

global $product, $post;

if (empty($product) && function_exists('wc_get_product')) {
    $product = wc_get_product(get_the_ID());
}
?>
<li <?php if (function_exists('wc_product_class')) { wc_product_class('', $product); } else { post_class('product'); } ?>>
    <a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link product-thumbnail-wrapper">
        <?php
        if (function_exists('woocommerce_show_product_loop_sale_flash')) {
            woocommerce_show_product_loop_sale_flash();
        }
        if (function_exists('woocommerce_template_loop_product_thumbnail')) {
            woocommerce_template_loop_product_thumbnail();
        } elseif (has_post_thumbnail()) {
            the_post_thumbnail('woocommerce_thumbnail');
        } else {
            echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/cat-dispensers.jpg') . '" alt="' . esc_attr(get_the_title()) . '">';
        }
        ?>
    </a>

    <div class="product-info" style="padding: 12px 4px 8px; text-align: left;">
        <h3 class="product-title" style="font-family: serif; font-size: 1.125rem; font-weight: 500; color: #FAF4ED; margin: 0 0 6px;">
            <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;">
                <?php the_title(); ?>
            </a>
        </h3>

        <div class="product-price" style="font-size: 1rem; font-weight: 600; color: #D9822B;">
            <?php 
            if ( class_exists( 'WooCommerce' ) ) {
                global $product;
                if ( ! empty( $product ) ) {
                    echo $product->get_price_html();
                }
            } else {
                // Fallback for custom post meta / custom fields
                $price = get_post_meta( get_the_ID(), '_product_price', true ) ?: get_post_meta( get_the_ID(), 'price', true );
                echo esc_html( $price ? '$' . number_format((float)$price, 2) : '' );
            }
            ?>
        </div>
    </div>

    <div class="product-actions">
        <?php
        if (function_exists('woocommerce_template_loop_add_to_cart')) {
            woocommerce_template_loop_add_to_cart();
        } else {
            ?>
            <a href="<?php the_permalink(); ?>" class="button product_type_simple add_to_cart_button">Add to cart</a>
            <?php
        }
        ?>
    </div>
</li>
