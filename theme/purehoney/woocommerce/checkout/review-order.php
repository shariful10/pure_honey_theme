<?php
/**
 * Checkout Order Review template
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-checkout-review-order-table">
  <h2 class="ph-checkout-section-title">Your Order</h2>

  <!-- Items list -->
  <div class="ph-order-items">
    <?php
      do_action( 'woocommerce_review_order_before_cart_contents' );

      foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
          $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

          if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
              ?>
              <div class="ph-order-item">
                <div class="ph-order-item__img">
                  <?php echo apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('thumbnail'), $cart_item, $cart_item_key ); ?>
                  <span class="ph-order-item__qty"><?php echo esc_html( $cart_item['quantity'] ); ?></span>
                </div>
                <div class="ph-order-item__info">
                  <span class="ph-order-item__name"><?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?></span>
                  <?php if ( $cart_item['variation_id'] ) : ?>
                  <span class="ph-order-item__variant"><?php echo wc_get_formatted_cart_item_data( $cart_item ); ?></span>
                  <?php endif; ?>
                </div>
                <div class="ph-order-item__price">
                  <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
                </div>
              </div>
              <?php
          }
      }

      do_action( 'woocommerce_review_order_after_cart_contents' );
    ?>
  </div>

  <!-- Totals -->
  <div class="ph-order-totals">
    <div class="ph-total-row">
      <span>Subtotal</span>
      <span><?php wc_cart_totals_subtotal_html(); ?></span>
    </div>

    <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
    <div class="ph-total-row ph-total-row--green">
      <span>Coupon (<?php echo esc_html( wc_format_coupon_code( $code ) ); ?>)</span>
      <span>-<?php wc_cart_totals_coupon_html( $coupon ); ?></span>
    </div>
    <?php endforeach; ?>

    <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
        <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
        <div class="ph-shipping-totals">
            <?php wc_cart_totals_shipping_html(); ?>
        </div>
        <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
    <?php endif; ?>

    <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
        <div class="ph-total-row">
            <span><?php echo esc_html( $fee->name ); ?></span>
            <span><?php wc_cart_totals_fee_html( $fee ); ?></span>
        </div>
    <?php endforeach; ?>

    <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
        <?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
            <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
                <div class="ph-total-row">
                    <span><?php echo esc_html( $tax->label ); ?></span>
                    <span><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="ph-total-row">
                <span><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></span>
                <span><?php wc_cart_totals_taxes_total_html(); ?></span>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>
    <div class="ph-total-divider"></div>
    <div class="ph-total-row ph-total-row--final">
      <span>Total</span>
      <span><?php wc_cart_totals_order_total_html(); ?></span>
    </div>
    <?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
  </div>
</div>
