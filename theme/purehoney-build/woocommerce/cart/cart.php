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
    <div class="woocommerce-notices-wrapper">
      <?php wc_print_notices(); ?>
    </div>

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
          <div class="ph-cart-item ph-cart-row-grid <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>" data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>" data-price="<?php echo esc_attr($_product->get_price()); ?>">

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
                <button type="button" class="ph-qty-btn minus" data-action="minus" data-step="1" data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>" aria-label="Decrease quantity">−</button>
                <?php
                  $max_qty = $_product->get_max_purchase_quantity();
                  $max_attr = ($max_qty && intval($max_qty) > 0) ? 'max="' . esc_attr($max_qty) . '"' : '';
                  $current_qty = max(1, intval($cart_item['quantity']));
                ?>
                <input type="number" class="qty" name="cart[<?php echo esc_attr($cart_item_key); ?>][qty]"
                  value="<?php echo esc_attr($current_qty); ?>"
                  data-saved-qty="<?php echo esc_attr($current_qty); ?>"
                  min="1" <?php echo $max_attr; ?>
                  step="1" autocomplete="off"
                  data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>"
                  data-price="<?php echo esc_attr($_product->get_price()); ?>">
                <button type="button" class="ph-qty-btn plus" data-action="plus" data-step="1" data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>" aria-label="Increase quantity">+</button>
              </div>
            </div>

            <!-- Subtotal -->
            <div class="ph-cart-item__subtotal text-right" data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>">
              <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
            </div>

          </div>
          <?php endif; endforeach; ?>

          <!-- Cart Actions -->
          <div class="ph-cart-actions">
            <button type="button" name="update_cart" class="ph-btn ph-btn--ghost ph-btn--sm ph-update-cart-btn" value="Update cart">
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
        <?php do_action('woocommerce_cart_collaterals'); ?>
      </div>

    </div><!-- .ph-cart-layout -->
    <?php endif; ?>
  </div>
</div>

<?php get_footer(); ?>
