<?php
defined( 'ABSPATH' ) || exit;
?>
<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">
  <div class="ph-summary-card">
    <h2 class="ph-summary-title">Order Summary</h2>

    <!-- Itemized Cart Items List -->
    <?php if ( ! WC()->cart->is_empty() ) : 
      $cart_items = WC()->cart->get_cart();
      $item_count = count($cart_items);
    ?>
    <div class="ph-summary-items-section">
      <div class="ph-summary-items-list <?php echo $item_count > 3 ? 'ph-summary-items-list--scrollable' : ''; ?>">
        <?php
        foreach ( $cart_items as $cart_item_key => $cart_item ) :
          $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
          $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

          if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
            $product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
            $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
            $thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( [40, 40] ), $cart_item, $cart_item_key );
            $product_price     = WC()->cart->get_product_price( $_product );
            $line_subtotal     = WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] );
        ?>
          <div class="ph-summary-item" data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>" data-price="<?php echo esc_attr( $_product->get_price() ); ?>">
            <div class="ph-summary-item__thumb">
              <?php
              if ( ! $_product->is_visible() ) {
                echo $thumbnail;
              } else {
                printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
              }
              ?>
            </div>
            <div class="ph-summary-item__details">
              <div class="ph-summary-item__name">
                <?php
                if ( ! $_product->is_visible() ) {
                  echo wp_kses_post( $product_name );
                } else {
                  printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), wp_kses_post( $product_name ) );
                }
                ?>
              </div>
              <div class="ph-summary-item__meta">
                <span class="ph-summary-item__qty">&times; <?php echo esc_html( $cart_item['quantity'] ); ?></span>
                <span class="ph-summary-item__unit-price">(<?php echo wp_kses_post( $product_price ); ?> each)</span>
              </div>
            </div>
            <div class="ph-summary-item__price">
              <?php echo wp_kses_post( $line_subtotal ); ?>
            </div>
          </div>
        <?php
          endif;
        endforeach;
        ?>
      </div>
      <div class="ph-summary-divider ph-summary-divider--amber"></div>
    </div>
    <?php endif; ?>

    <!-- Subtotal -->
    <div class="ph-summary-row">
      <span>Subtotal</span>
      <span><?php wc_cart_totals_subtotal_html(); ?></span>
    </div>

    <!-- Shipping / Coupons -->
    <?php foreach (WC()->cart->get_coupons() as $code => $coupon): ?>
    <div class="ph-summary-row ph-summary-row--green">
      <span>Coupon: <?php echo esc_html(wc_format_coupon_code($code)); ?>
        <a href="<?php echo esc_url(add_query_arg('remove_coupon', rawurlencode(wc_format_coupon_code($code)), wc_get_cart_url())); ?>" class="ph-remove-coupon" title="Remove coupon">✕</a>
      </span>
      <span>-<?php wc_cart_totals_coupon_html($coupon); ?></span>
    </div>
    <?php endforeach; ?>

    <!-- Shipping estimate -->
    <div class="ph-summary-row">
      <span>Shipping</span>
      <span class="ph-shipping-label">
        <?php
        $packages = WC()->cart->get_shipping_packages();
        if (!empty($packages)) {
          $rates = WC()->cart->calculate_shipping();
          if (WC()->cart->show_shipping()) {
            echo '<span style="color:rgba(255,255,255,0.5);font-size:0.8rem;">Calculated at checkout</span>';
          } else {
            echo '<span style="color:var(--ph-gold);">Free</span>';
          }
        } else {
          echo '<span style="color:rgba(255,255,255,0.5);font-size:0.8rem;">Calculated at checkout</span>';
        }
        ?>
      </span>
    </div>

    <div class="ph-summary-divider"></div>

    <!-- Total -->
    <div class="ph-summary-total">
      <span>Total</span>
      <span><?php wc_cart_totals_order_total_html(); ?></span>
    </div>

    <p class="ph-summary-tax-note">Taxes calculated at checkout</p>

    <!-- Checkout Button -->
    <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="ph-btn ph-btn--primary ph-checkout-btn">
      Proceed to Checkout
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    </a>

    <!-- Security badges -->
    <div class="ph-security-badges">
      <div class="ph-security-item">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        <span>SSL Secured</span>
      </div>
      <div class="ph-security-item">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.955 11.955 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg>
        <span>30-Day Returns</span>
      </div>
      <div class="ph-security-item">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
        <span>Safe Payment</span>
      </div>
    </div>

    <!-- Accepted Payments -->
    <div class="ph-payment-icons">
      <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.1.0/min/flat/visa.svg" alt="Visa" title="Visa">
      <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.1.0/min/flat/mastercard.svg" alt="Mastercard" title="Mastercard">
      <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.1.0/min/flat/paypal.svg" alt="PayPal" title="PayPal">
      <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" alt="Stripe" title="Stripe">
    </div>
  </div>

  <!-- Free shipping notice -->
  <?php
  $threshold = 59;
  $cart_total = WC()->cart->get_subtotal();
  $remaining = $threshold - $cart_total;
  if ($remaining > 0): ?>
  <div class="ph-shipping-notice">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    Add <strong><?php echo wc_price($remaining); ?></strong> more for <strong>Free Shipping!</strong>
    <div class="ph-shipping-progress">
      <div class="ph-shipping-bar" style="width:<?php echo min(100, ($cart_total / $threshold) * 100); ?>%"></div>
    </div>
  </div>
  <?php else: ?>
  <div class="ph-shipping-notice ph-shipping-notice--active">
    🎉 You qualify for <strong>Free Shipping!</strong>
  </div>
  <?php endif; ?>
</div>
