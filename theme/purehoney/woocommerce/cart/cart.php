<?php
/**
 * PureHoney – Cart Page Template Override
 * @package PureHoney
 */
defined('ABSPATH') || exit;
get_header();
?>

<div class="ph-page-wrap">
  <!-- Page Hero -->
  <div class="ph-page-hero">
    <div class="ph-container">
      <nav class="ph-breadcrumb" aria-label="Breadcrumb">
        <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
        <span>›</span>
        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Shop</a>
        <span>›</span>
        <span>Your Cart</span>
      </nav>
      <h1 class="ph-page-title">Your Cart
        <?php if (WC()->cart->get_cart_contents_count() > 0): ?>
        <span class="ph-cart-badge"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        <?php endif; ?>
      </h1>
    </div>
  </div>

  <div class="ph-container ph-cart-page">
    <?php wc_print_notices(); ?>

    <?php if (WC()->cart->is_empty()): ?>
    <!-- Empty Cart -->
    <div class="ph-empty-cart">
      <div class="ph-empty-cart__icon">🛒</div>
      <h2>Your cart is empty</h2>
      <p>Looks like you haven't added anything yet. Explore our collection of artisan honey accessories.</p>
      <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="ph-btn ph-btn--primary ph-btn--lg">
        Browse Collection →
      </a>
    </div>

    <?php else: ?>
    <!-- Cart Layout -->
    <div class="ph-cart-layout">

      <!-- Left: Cart Items -->
      <div class="ph-cart-items">
        <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
          <!-- Cart Table Header -->
          <div class="ph-cart-header ph-cart-row-grid">
            <span>Product</span>
            <span class="text-center">Quantity</span>
            <span class="text-right">Total</span>
          </div>

          <!-- Cart Items -->
          <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
            if ($_product && $_product->exists() && $cart_item['quantity'] > 0):
          ?>
          <div class="ph-cart-item ph-cart-row-grid <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

            <!-- Product Info -->
            <div class="ph-cart-item__product">
              <div class="ph-cart-item__image">
                <?php
                $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('woocommerce_thumbnail', ['class' => 'ph-cart-thumb']), $cart_item, $cart_item_key);
                if (!$_product->is_visible()) echo $thumbnail;
                else printf('<a href="%s">%s</a>', esc_url(get_permalink($product_id)), $thumbnail);
                ?>
              </div>
              <div class="ph-cart-item__meta">
                <h3 class="ph-cart-item__name">
                  <?php if (!$_product->is_visible()): echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key));
                  else: ?><a href="<?php echo esc_url(get_permalink($product_id)); ?>"><?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key)); ?></a>
                  <?php endif; ?>
                </h3>
                <?php echo wc_get_formatted_cart_item_data($cart_item); ?>
                <div class="ph-cart-item__price">
                  <?php echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); ?>
                  <span>each</span>
                </div>
                <a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>" class="ph-cart-item__remove" aria-label="Remove <?php echo esc_attr($_product->get_name()); ?>">
                  Remove
                </a>
              </div>
            </div>

            <!-- Quantity -->
            <div class="ph-cart-item__qty text-center">
              <div class="ph-qty-wrap">
                <button type="button" class="ph-qty-btn minus" aria-label="Decrease">−</button>
                <input type="number" class="qty" name="cart[<?php echo esc_attr($cart_item_key); ?>][qty]"
                  value="<?php echo esc_attr($cart_item['quantity']); ?>"
                  min="0" max="<?php echo esc_attr($_product->get_max_purchase_quantity()); ?>"
                  step="1" autocomplete="off">
                <button type="button" class="ph-qty-btn plus" aria-label="Increase">+</button>
              </div>
            </div>

            <!-- Subtotal -->
            <div class="ph-cart-item__subtotal text-right">
              <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
            </div>

          </div>
          <?php endif; endforeach; ?>

          <!-- Cart Actions -->
          <div class="ph-cart-actions">
            <div class="ph-coupon">
              <?php if (wc_coupons_enabled()): ?>
              <input type="text" name="coupon_code" id="coupon_code" class="ph-input" placeholder="Coupon code…" value="">
              <button type="submit" name="apply_coupon" value="Apply Coupon" class="ph-btn ph-btn--outline ph-btn--sm">Apply</button>
              <?php endif; ?>
            </div>
            <button type="submit" name="update_cart" class="ph-btn ph-btn--ghost ph-btn--sm" value="Update cart">
              ↺ Update Cart
            </button>
          </div>

          <?php do_action('woocommerce_cart_contents'); ?>
          <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
        </form>

        <!-- Continue Shopping -->
        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="ph-continue-shopping">
          ← Continue Shopping
        </a>
      </div>

      <!-- Right: Order Summary -->
      <div class="ph-cart-summary">
        <div class="ph-summary-card">
          <h2 class="ph-summary-title">Order Summary</h2>

          <!-- Subtotal -->
          <div class="ph-summary-row">
            <span>Subtotal</span>
            <span><?php wc_cart_totals_subtotal_html(); ?></span>
          </div>

          <!-- Shipping -->
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
            <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.1.0/min/flat/stripe.svg" alt="Stripe" title="Stripe">
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

    </div><!-- .ph-cart-layout -->
    <?php endif; ?>
  </div>
</div>

<?php get_footer(); ?>
