<?php
/**
 * PureHoney – Simple product add to cart
 * Overrides: woocommerce/single-product/add-to-cart/simple.php
 *
 * "Buy Now" uses a standard form POST so WooCommerce processes
 * it in the same PHP session before redirecting to checkout.
 */
defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
    return;
}

echo wc_get_stock_html( $product );

if ( $product->is_in_stock() ) :
    $product_id = $product->get_id();
?>

    <?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

    <form class="cart"
          action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>"
          method="post"
          enctype="multipart/form-data">

        <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

        <?php
        do_action( 'woocommerce_before_add_to_cart_quantity' );
        woocommerce_quantity_input([
            'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
            'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
            'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(),
        ]);
        do_action( 'woocommerce_after_add_to_cart_quantity' );
        ?>

        <!-- ── CTA Row ── -->
        <div class="ph-atc-row">

            <!-- Standard Add to Cart (WooCommerce handles this normally) -->
            <button type="submit"
                    name="add-to-cart"
                    value="<?php echo esc_attr( $product_id ); ?>"
                    class="single_add_to_cart_button button alt">
                <?php echo esc_html( $product->single_add_to_cart_text() ); ?>
            </button>

            <!--
                Buy Now: submits form with name="purehoney_buy_now".
                PHP handler in functions.php catches this on template_redirect,
                empties cart, adds this product, then redirects to checkout.
                All in the same PHP session → checkout always shows correct item.
            -->
            <button type="submit"
                    name="purehoney_buy_now"
                    value="<?php echo esc_attr( $product_id ); ?>"
                    class="button ph-buy-now-btn">
                <span><?php esc_html_e( 'Buy Now', 'purehoney' ); ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor" width="16" height="16" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </button>
        </div>

        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
    </form>

    <script>
    (function() {
        var form = document.querySelector('form.cart');
        if (!form) return;
        var buyNowBtn = form.querySelector('.ph-buy-now-btn');
        if (!buyNowBtn) return;
        buyNowBtn.addEventListener('click', function() {
            var existing = form.querySelector('input[name="purehoney_buy_now"]');
            if (!existing) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'purehoney_buy_now';
                input.value = buyNowBtn.value;
                form.appendChild(input);
            }
            var span = buyNowBtn.querySelector('span');
            if (span) {
                span.textContent = '<?php echo esc_js( __( 'Processing...', 'purehoney' ) ); ?>';
            }
        });
    })();
    </script>

    <?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif;
