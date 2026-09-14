<?php
/**
 * PureHoney – Checkout Page Template Override
 * @package PureHoney
 */
defined('ABSPATH') || exit;
get_header();
?>

<div class="ph-page-wrap">
  <div class="ph-page-hero">
    <div class="ph-container">
      <nav class="ph-breadcrumb" aria-label="Breadcrumb">
        <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
        <span>›</span>
        <a href="<?php echo esc_url(wc_get_cart_url()); ?>">Cart</a>
        <span>›</span>
        <span>Checkout</span>
      </nav>
      <h1 class="ph-page-title">Checkout</h1>
    </div>
  </div>

  <div class="ph-container ph-checkout-page">
    <?php wc_print_notices(); ?>

    <!-- Checkout Steps Indicator -->
    <div class="ph-checkout-steps">
      <div class="ph-step ph-step--done">
        <div class="ph-step__num">✓</div>
        <span>Cart</span>
      </div>
      <div class="ph-step__line ph-step__line--done"></div>
      <div class="ph-step ph-step--active">
        <div class="ph-step__num">2</div>
        <span>Details</span>
      </div>
      <div class="ph-step__line"></div>
      <div class="ph-step">
        <div class="ph-step__num">3</div>
        <span>Confirmation</span>
      </div>
    </div>

    <?php if (WC()->cart->is_empty()): ?>
    <div class="ph-empty-cart">
      <div class="ph-empty-cart__icon">🛒</div>
      <h2>Your cart is empty</h2>
      <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="ph-btn ph-btn--primary ph-btn--lg">Browse Collection →</a>
    </div>
    <?php else: ?>

    <form name="checkout" method="post" class="checkout woocommerce-checkout ph-checkout-form"
      action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

      <div class="ph-checkout-layout">

        <!-- LEFT: Customer Details -->
        <div class="ph-checkout-left">

          <!-- Returning customer notice -->
          <?php if (is_user_logged_in()): ?>
          <div class="ph-checkout-logged-in">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Welcome back, <?php echo esc_html(wp_get_current_user()->display_name); ?>!
          </div>
          <?php else: ?>
          <?php do_action('woocommerce_before_checkout_form_cart_notices'); ?>
          <?php woocommerce_checkout_login_form(); ?>
          <?php endif; ?>

          <!-- Billing Details -->
          <div class="ph-checkout-section">
            <h2 class="ph-checkout-section-title">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              Billing Information
            </h2>
            <div class="ph-fields-grid">
              <?php woocommerce_form_field('billing_first_name', ['type'=>'text','label'=>'First Name','required'=>true,'class'=>['ph-field-half']], WC()->checkout()->get_value('billing_first_name')); ?>
              <?php woocommerce_form_field('billing_last_name', ['type'=>'text','label'=>'Last Name','required'=>true,'class'=>['ph-field-half']], WC()->checkout()->get_value('billing_last_name')); ?>
              <?php woocommerce_form_field('billing_company', ['type'=>'text','label'=>'Company Name (Optional)','class'=>['ph-field-full']], WC()->checkout()->get_value('billing_company')); ?>
              <?php woocommerce_form_field('billing_country', ['type'=>'country','label'=>'Country','required'=>true,'class'=>['ph-field-full']], WC()->checkout()->get_value('billing_country')); ?>
              <?php woocommerce_form_field('billing_address_1', ['type'=>'text','label'=>'Street Address','required'=>true,'placeholder'=>'House number and street name','class'=>['ph-field-full']], WC()->checkout()->get_value('billing_address_1')); ?>
              <?php woocommerce_form_field('billing_address_2', ['type'=>'text','label'=>'','placeholder'=>'Apartment, suite, unit, etc. (optional)','class'=>['ph-field-full']], WC()->checkout()->get_value('billing_address_2')); ?>
              <?php woocommerce_form_field('billing_city', ['type'=>'text','label'=>'City','required'=>true,'class'=>['ph-field-half']], WC()->checkout()->get_value('billing_city')); ?>
              <?php woocommerce_form_field('billing_postcode', ['type'=>'text','label'=>'Postcode / ZIP','required'=>true,'class'=>['ph-field-half']], WC()->checkout()->get_value('billing_postcode')); ?>
              <?php woocommerce_form_field('billing_phone', ['type'=>'tel','label'=>'Phone Number','required'=>true,'class'=>['ph-field-half']], WC()->checkout()->get_value('billing_phone')); ?>
              <?php woocommerce_form_field('billing_email', ['type'=>'email','label'=>'Email Address','required'=>true,'class'=>['ph-field-half']], WC()->checkout()->get_value('billing_email')); ?>
            </div>
          </div>

          <!-- Ship to Different Address -->
          <div class="ph-checkout-section">
            <div class="ph-ship-toggle" id="ship-to-different-address">
              <label class="ph-toggle-label" for="ship-to-different-address-checkbox">
                <input type="checkbox" id="ship-to-different-address-checkbox" name="ship_to_different_address" value="1" <?php checked(apply_filters('woocommerce_ship_to_different_address_checked', 'shipping' === get_option('woocommerce_ship_to_destination') ? 1 : 0), 1); ?>>
                <span class="ph-toggle-check"></span>
                <span class="ph-toggle-text">Ship to a different address?</span>
              </label>
            </div>
            <div class="shipping_address" style="display:none;">
              <h2 class="ph-checkout-section-title" style="margin-top:24px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Shipping Address
              </h2>
              <div class="ph-fields-grid">
                <?php woocommerce_form_field('shipping_first_name', ['type'=>'text','label'=>'First Name','required'=>true,'class'=>['ph-field-half']], WC()->checkout()->get_value('shipping_first_name')); ?>
                <?php woocommerce_form_field('shipping_last_name', ['type'=>'text','label'=>'Last Name','required'=>true,'class'=>['ph-field-half']], WC()->checkout()->get_value('shipping_last_name')); ?>
                <?php woocommerce_form_field('shipping_country', ['type'=>'country','label'=>'Country','required'=>true,'class'=>['ph-field-full']], WC()->checkout()->get_value('shipping_country')); ?>
                <?php woocommerce_form_field('shipping_address_1', ['type'=>'text','label'=>'Street Address','required'=>true,'placeholder'=>'House number and street name','class'=>['ph-field-full']], WC()->checkout()->get_value('shipping_address_1')); ?>
                <?php woocommerce_form_field('shipping_city', ['type'=>'text','label'=>'City','required'=>true,'class'=>['ph-field-half']], WC()->checkout()->get_value('shipping_city')); ?>
                <?php woocommerce_form_field('shipping_postcode', ['type'=>'text','label'=>'Postcode / ZIP','required'=>true,'class'=>['ph-field-half']], WC()->checkout()->get_value('shipping_postcode')); ?>
              </div>
            </div>
          </div>

          <!-- Order Notes -->
          <div class="ph-checkout-section">
            <h2 class="ph-checkout-section-title">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
              Additional Notes
            </h2>
            <?php woocommerce_form_field('order_comments', ['type'=>'textarea','label'=>'','placeholder'=>'Special instructions for your order, gift message, or delivery notes (optional)','class'=>['ph-field-full']], WC()->checkout()->get_value('order_comments')); ?>
          </div>

          <?php do_action('woocommerce_checkout_after_customer_details'); ?>
        </div>

        <!-- RIGHT: Order Summary + Payment -->
        <div class="ph-checkout-right">

          <div class="ph-order-review woocommerce-checkout-review-order" id="order_review">
            <h2 class="ph-checkout-section-title">Your Order</h2>

            <!-- Items list -->
            <div class="ph-order-items">
              <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
                $_product = $cart_item['data'];
                if ($_product && $_product->exists() && $cart_item['quantity'] > 0):
              ?>
              <div class="ph-order-item">
                <div class="ph-order-item__img">
                  <?php echo $_product->get_image('thumbnail'); ?>
                  <span class="ph-order-item__qty"><?php echo esc_html($cart_item['quantity']); ?></span>
                </div>
                <div class="ph-order-item__info">
                  <span class="ph-order-item__name"><?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key)); ?></span>
                  <?php if ($cart_item['variation_id']): ?>
                  <span class="ph-order-item__variant"><?php echo wc_get_formatted_cart_item_data($cart_item); ?></span>
                  <?php endif; ?>
                </div>
                <div class="ph-order-item__price">
                  <?php echo WC()->cart->get_product_subtotal($_product, $cart_item['quantity']); ?>
                </div>
              </div>
              <?php endif; endforeach; ?>
            </div>

            <!-- Totals -->
            <div class="ph-order-totals">
              <?php woocommerce_review_order_before_cart_contents(); ?>
              <?php woocommerce_review_order_after_cart_contents(); ?>

              <div class="ph-total-row">
                <span>Subtotal</span>
                <span><?php wc_cart_totals_subtotal_html(); ?></span>
              </div>

              <?php foreach (WC()->cart->get_coupons() as $code => $coupon): ?>
              <div class="ph-total-row ph-total-row--green">
                <span>Coupon (<?php echo esc_html(wc_format_coupon_code($code)); ?>)</span>
                <span>-<?php wc_cart_totals_coupon_html($coupon); ?></span>
              </div>
              <?php endforeach; ?>

              <?php woocommerce_checkout_totals(); ?>

              <div class="ph-total-divider"></div>
              <div class="ph-total-row ph-total-row--final">
                <span>Total</span>
                <span><?php wc_cart_totals_order_total_html(); ?></span>
              </div>
            </div>

            <!-- Payment Methods & Place Order -->
            <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
            <?php woocommerce_checkout_payment(); ?>

            <!-- Security Note -->
            <div class="ph-checkout-security">
              <div class="ph-security-row">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span>Your information is 100% secure & encrypted</span>
              </div>
              <div class="ph-payment-logos">
                <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.1.0/min/flat/visa.svg" alt="Visa" height="24">
                <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.1.0/min/flat/mastercard.svg" alt="Mastercard" height="24">
                <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.1.0/min/flat/paypal.svg" alt="PayPal" height="24">
                <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.1.0/min/flat/stripe.svg" alt="Stripe" height="24">
                <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.1.0/min/flat/amex.svg" alt="Amex" height="24">
              </div>
            </div>

          </div><!-- .ph-order-review -->
        </div><!-- .ph-checkout-right -->

      </div><!-- .ph-checkout-layout -->

      <?php do_action('woocommerce_checkout_after_order_review'); ?>

    </form>
    <?php endif; ?>
  </div>
</div>

<?php get_footer(); ?>
