<?php
/**
 * PureHoney - Checkout Form (WooCommerce template override)
 * Hero/breadcrumb rendered by page.php. This template renders the form only.
 * @package PureHoney
 */
defined('ABSPATH') || exit;
?>

<?php wc_print_notices(); ?>

<div class="ph-checkout-steps">
  <div class="ph-step ph-step--done"><div class="ph-step__num">&#10003;</div><span>Cart</span></div>
  <div class="ph-step__line ph-step__line--done"></div>
  <div class="ph-step ph-step--active"><div class="ph-step__num">2</div><span>Details</span></div>
  <div class="ph-step__line"></div>
  <div class="ph-step"><div class="ph-step__num">3</div><span>Confirmation</span></div>
</div>

<?php if (WC()->cart->is_empty()): ?>
<div class="ph-empty-cart">
  <div class="ph-empty-cart__icon">&#128722;</div>
  <h2>Your cart is empty</h2>
  <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="ph-btn ph-btn--primary ph-btn--lg">Browse Collection</a>
</div>
<?php else: ?>

<form name="checkout" method="post" class="checkout woocommerce-checkout ph-checkout-form"
  action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
  <div class="ph-checkout-layout">

    <div class="ph-checkout-left">
      <?php if (is_user_logged_in()): ?>
      <div class="ph-checkout-logged-in">Welcome back, <?php echo esc_html(wp_get_current_user()->user_email); ?>!</div>
      <?php else: ?>
      <?php do_action('woocommerce_before_checkout_form_cart_notices'); ?>
      <?php woocommerce_checkout_login_form(); ?>
      <?php endif; ?>

      <div class="ph-checkout-section">
        <h2 class="ph-checkout-section-title">Billing Information</h2>
        <div class="ph-fields-grid">
          <?php woocommerce_form_field('billing_first_name', ['type'=>'text','label'=>'First Name','required'=>true,'class'=>['ph-field-half']], WC()->checkout()->get_value('billing_first_name')); ?>
          <?php woocommerce_form_field('billing_last_name',  ['type'=>'text','label'=>'Last Name','required'=>true,'class'=>['ph-field-half']], WC()->checkout()->get_value('billing_last_name')); ?>
          <?php woocommerce_form_field('billing_company',    ['type'=>'text','label'=>'Company Name (Optional)','class'=>['ph-field-full']], WC()->checkout()->get_value('billing_company')); ?>
          <?php woocommerce_form_field('billing_country',    ['type'=>'country','label'=>'Country','required'=>true,'class'=>['ph-field-full']], WC()->checkout()->get_value('billing_country')); ?>
          <?php woocommerce_form_field('billing_address_1',  ['type'=>'text','label'=>'Street Address','required'=>true,'placeholder'=>'House number and street name','class'=>['ph-field-full']], WC()->checkout()->get_value('billing_address_1')); ?>
          <?php woocommerce_form_field('billing_address_2',  ['type'=>'text','label'=>'','placeholder'=>'Apartment, suite, unit, etc. (optional)','class'=>['ph-field-full']], WC()->checkout()->get_value('billing_address_2')); ?>
          <?php woocommerce_form_field('billing_city',       ['type'=>'text','label'=>'City','required'=>true,'class'=>['ph-field-half']], WC()->checkout()->get_value('billing_city')); ?>
          <?php woocommerce_form_field('billing_postcode',   ['type'=>'text','label'=>'Postcode / ZIP','required'=>true,'class'=>['ph-field-half']], WC()->checkout()->get_value('billing_postcode')); ?>
          <?php woocommerce_form_field('billing_phone',      ['type'=>'tel','label'=>'Phone Number','required'=>true,'class'=>['ph-field-half']], WC()->checkout()->get_value('billing_phone')); ?>
          <?php woocommerce_form_field('billing_email',      ['type'=>'email','label'=>'Email Address','required'=>true,'class'=>['ph-field-half']], WC()->checkout()->get_value('billing_email')); ?>
        </div>
      </div>

      <div class="ph-checkout-section">
        <div class="ph-ship-toggle" id="ship-to-different-address">
          <label class="ph-toggle-label" for="ship-to-different-address-checkbox">
            <input type="checkbox" id="ship-to-different-address-checkbox" name="ship_to_different_address" value="1" <?php checked(apply_filters('woocommerce_ship_to_different_address_checked', 'shipping' === get_option('woocommerce_ship_to_destination') ? 1 : 0), 1); ?>>
            <span class="ph-toggle-check"></span>
            <span class="ph-toggle-text">Ship to a different address?</span>
          </label>
        </div>
        <div class="shipping_address" style="display:none;">
          <h2 class="ph-checkout-section-title" style="margin-top:24px;">Shipping Address</h2>
          <div class="ph-fields-grid">
            <?php woocommerce_form_field('shipping_first_name', ['type'=>'text','label'=>'First Name','required'=>true,'class'=>['ph-field-half']], WC()->checkout()->get_value('shipping_first_name')); ?>
            <?php woocommerce_form_field('shipping_last_name',  ['type'=>'text','label'=>'Last Name','required'=>true,'class'=>['ph-field-half']], WC()->checkout()->get_value('shipping_last_name')); ?>
            <?php woocommerce_form_field('shipping_country',    ['type'=>'country','label'=>'Country','required'=>true,'class'=>['ph-field-full']], WC()->checkout()->get_value('shipping_country')); ?>
            <?php woocommerce_form_field('shipping_address_1',  ['type'=>'text','label'=>'Street Address','required'=>true,'placeholder'=>'House number and street','class'=>['ph-field-full']], WC()->checkout()->get_value('shipping_address_1')); ?>
            <?php woocommerce_form_field('shipping_city',       ['type'=>'text','label'=>'City','required'=>true,'class'=>['ph-field-half']], WC()->checkout()->get_value('shipping_city')); ?>
            <?php woocommerce_form_field('shipping_postcode',   ['type'=>'text','label'=>'Postcode / ZIP','required'=>true,'class'=>['ph-field-half']], WC()->checkout()->get_value('shipping_postcode')); ?>
          </div>
        </div>
      </div>

      <div class="ph-checkout-section">
        <h2 class="ph-checkout-section-title">Additional Notes</h2>
        <?php woocommerce_form_field('order_comments', ['type'=>'textarea','label'=>'','placeholder'=>'Special instructions, gift message, or delivery notes (optional)','class'=>['ph-field-full']], WC()->checkout()->get_value('order_comments')); ?>
      </div>

      <?php do_action('woocommerce_checkout_after_customer_details'); ?>
    </div>

    <div class="ph-checkout-right">
      <div class="ph-order-review woocommerce-checkout-review-order" id="order_review">
        <?php do_action('woocommerce_checkout_order_review'); ?>
        <div class="ph-checkout-security">
          <div class="ph-security-row">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            <span>100% secure &amp; encrypted checkout</span>
          </div>
          <div class="ph-payment-logos">
            <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.1.0/min/flat/visa.svg" alt="Visa" height="22">
            <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.1.0/min/flat/mastercard.svg" alt="Mastercard" height="22">
            <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.1.0/min/flat/paypal.svg" alt="PayPal" height="22">
            <svg height="22" viewBox="0 0 60 25" xmlns="http://www.w3.org/2000/svg" style="background:#635BFF;border-radius:4px;padding:2px 5px;box-sizing:content-box;" aria-label="Stripe"><path d="M59.64 14.28h-8.06c.19 1.93 1.6 2.55 3.2 2.55 1.64 0 2.96-.37 4.05-.95v3.32a8.33 8.33 0 0 1-4.56 1.1c-4.01 0-6.83-2.5-6.83-7.48 0-4.19 2.39-7.52 6.3-7.52 3.92 0 5.96 3.28 5.96 7.5 0 .4-.04 1.26-.06 1.48zm-5.92-5.62c-1.03 0-2.17.73-2.17 2.58h4.25c0-1.85-1.07-2.58-2.08-2.58zM40.95 20.3c-1.44 0-2.32-.6-2.9-1.04l-.02 4.63-4.12.87V5.57h3.76l.08 1.02a4.7 4.7 0 0 1 3.23-1.29c2.9 0 5.62 2.6 5.62 7.4 0 5.23-2.7 7.6-5.65 7.6zM40 8.95c-.95 0-1.54.34-1.94.81l.02 6.12c.4.44.98.78 1.92.78 1.55 0 2.51-1.76 2.51-3.87 0-2.07-.96-3.84-2.51-3.84zM28.24 5.57h4.13v14.44h-4.13V5.57zm0-4.7L32.37 0v3.36l-4.13.88V.88zM22.35 14.08c0 1.21.96 1.66 2.38 1.66 1.17 0 2.08-.3 2.96-.76v3.19c-.96.5-2.28.83-3.78.83-3.29 0-5.54-1.81-5.54-5.2V9.29h-2.17V5.57h2.17V2.43l4.12-.88v4.02h5.34v3.72h-5.34v4.79zM10.46 10.07c0-.86.71-1.22 1.89-1.22 1.65 0 3.73.5 5.38 1.4V6.19c-1.79-.72-3.56-1-5.38-1C8.96 5.2 6.2 6.86 6.2 10.29c0 5.27 7.27 4.43 7.27 6.7 0 1.01-.89 1.38-2.09 1.38-1.8 0-4.07-.74-5.87-1.73v4.1c2 .86 4.02 1.22 5.87 1.22 4.46 0 7.5-2.2 7.5-5.72-.01-5.68-7.42-4.68-7.42-6.17z" fill="white"/></svg>
            <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.1.0/min/flat/amex.svg" alt="Amex" height="22">
          </div>
        </div>
      </div>
    </div>

  </div>
  <?php do_action('woocommerce_checkout_after_order_review'); ?>
</form>
<?php endif; ?>
