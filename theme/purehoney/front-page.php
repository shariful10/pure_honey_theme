<?php
/**
 * Homepage Template — Avoraix-Inspired High-Converting E-Commerce Redesign
 * PureHoney WordPress Theme
 */
defined('ABSPATH') || exit;

get_header();

$shop_url     = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop');
$contact_url  = home_url('/contact-us');
$about_url    = home_url('/about-us');
$dir          = get_template_directory_uri();
?>

<!-- ════════════ 1. HERO SECTION (AVORAIX STYLE) ════════════ -->
<section class="ph-hero-avoraix" id="home-hero">
  <div class="ph-container ph-hero-avoraix__container">
    <div class="ph-hero-avoraix__grid">

      <!-- Left Column: Copy & CTAs -->
      <div class="ph-hero-avoraix__content" data-ph-animate>
        <!-- Eyebrow Pill -->
        <div class="ph-pill-badge">
          <span class="ph-pill-badge__icon">✨</span>
          <span class="ph-pill-badge__text">100% ORGANIC & UNFILTERED RAW HONEY</span>
        </div>

        <!-- Headline -->
        <h1 class="ph-hero-avoraix__headline">
          Pure • Natural • Healthy <br>
          <span class="ph-text-highlight">Nature's Sweetness</span> Delivered to Your Home
        </h1>

        <!-- Subheadline -->
        <p class="ph-hero-avoraix__subheadline">
          Discover artisanal raw wildflower honey, precision no-drip glass dispensers, and handcrafted gift hampers. Harvested ethically from master beekeepers, preserving raw enzymes and rich golden flavor.
        </p>

        <!-- CTA Buttons -->
        <div class="ph-hero-avoraix__actions">
          <a href="<?php echo esc_url($shop_url); ?>" class="ph-btn ph-btn--primary ph-btn--lg">
            Shop Now →
          </a>
          <a href="<?php echo esc_url($contact_url); ?>" class="ph-btn ph-btn--secondary ph-btn--lg">
            Contact Us
          </a>
        </div>

        <!-- Hero Trust Highlights -->
        <div class="ph-hero-avoraix__trust-row">
          <div class="ph-hero-trust-item">
            <div class="ph-hero-trust-item__stars">★★★★★</div>
            <div class="ph-hero-trust-item__text">
              <strong>4.9/5 Rating</strong>
              <span>2,000+ Verified Reviews</span>
            </div>
          </div>
          <div class="ph-hero-trust-sep"></div>
          <div class="ph-hero-trust-item">
            <span class="ph-hero-trust-item__icon">🚚</span>
            <div class="ph-hero-trust-item__text">
              <strong>Fast 2–4 Day Delivery</strong>
              <span>Free on orders over $60</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: Crisp Un-Fogged Lifestyle Photography -->
      <div class="ph-hero-avoraix__visual" data-ph-animate="fade-left">
        <div class="ph-hero-image-card">
          <img src="<?php echo esc_url($dir . '/assets/images/hero-banner.jpg'); ?>" 
               alt="PureHoney Artisan Honey Jar and Dispensers" 
               class="ph-hero-img-main"
               width="640" height="520"
               loading="eager">
          <!-- Floating Badge: 100% Raw Harvest -->
          <div class="ph-floating-badge ph-floating-badge--top">
            <div class="ph-floating-badge__icon">🍯</div>
            <div class="ph-floating-badge__text">
              <strong>100% Pure Raw Honey</strong>
              <small>Zero additives or syrups</small>
            </div>
          </div>
          <!-- Floating Badge: Ethical Beekeeping -->
          <div class="ph-floating-badge ph-floating-badge--bottom">
            <div class="ph-floating-badge__icon">🐝</div>
            <div class="ph-floating-badge__text">
              <strong>Ethical Beekeeping</strong>
              <small>Sustainable & Bee-Friendly</small>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ════════════ 2. 4-PILLAR TRUST FEATURE BAR ════════════ -->
<section class="ph-trust-section" id="trust-pillars">
  <?php echo do_shortcode('[ph_trust_bar]'); ?>
</section>

<!-- ════════════ 3. "SHOP BY CATEGORY" SECTION ════════════ -->
<section class="ph-section ph-section--neutral" id="shop-categories">
  <div class="ph-container">
    <div class="ph-section-header text-center" data-ph-animate>
      <span class="ph-eyebrow">CURATED COLLECTIONS</span>
      <h2 class="ph-section-title">Shop by Category</h2>
      <p class="ph-section-subtitle">Explore our handpicked range of honey dispensers, gift collections, and pantry essentials.</p>
    </div>

    <div class="ph-category-grid" data-ph-stagger>
      <?php
      $categories_data = [
        [
          'slug'  => 'gift-boxes',
          'name'  => 'Gift Boxes',
          'desc'  => 'Luxurious keepsakes for special moments',
          'image' => $dir . '/assets/images/categories/gift-boxes.jpg',
          'count' => '5 Gift Sets',
        ],
        [
          'slug'  => 'honey-dispensers',
          'name'  => 'Honey Dispensers',
          'desc'  => 'No-drip pumps & borosilicate glass jars',
          'image' => $dir . '/assets/images/categories/honey-dispensers.jpg',
          'count' => '6 Models',
        ],
        [
          'slug'  => 'handpicked-honey',
          'name'  => 'Handpicked Honey',
          'desc'  => 'Pure wildflower & seasonal raw honey jars',
          'image' => $dir . '/assets/images/categories/handpicked-honey.jpg',
          'count' => '4 Varieties',
        ],
        [
          'slug'  => 'essentials',
          'name'  => 'Essentials',
          'desc'  => 'Acacia wood dippers, aprons & wax wraps',
          'image' => $dir . '/assets/images/categories/essentials.jpg',
          'count' => '5 Accessories',
        ],
      ];

      foreach ($categories_data as $cat):
        $cat_link = function_exists('get_term_link') ? get_term_link($cat['slug'], 'product_cat') : '';
        if (empty($cat_link) || is_wp_error($cat_link)) {
          $cat_link = $shop_url . '?category=' . $cat['slug'];
        }
      ?>
      <a href="<?php echo esc_url($cat_link); ?>" class="ph-category-card" data-ph-animate>
        <div class="ph-category-card__image-wrap">
          <img src="<?php echo esc_url($cat['image']); ?>" alt="<?php echo esc_attr($cat['name']); ?>" loading="lazy">
          <span class="ph-category-card__pill"><?php echo esc_html($cat['count']); ?></span>
        </div>
        <div class="ph-category-card__body">
          <h3 class="ph-category-card__title"><?php echo esc_html($cat['name']); ?></h3>
          <p class="ph-category-card__desc"><?php echo esc_html($cat['desc']); ?></p>
          <span class="ph-category-card__cta">Explore Collection →</span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ════════════ 4. FEATURED PRODUCTS GRID WITH TABS ════════════ -->
<section class="ph-section ph-section--white" id="featured-products">
  <div class="ph-container">
    <!-- Header with Filter Tabs -->
    <div class="ph-products-header" data-ph-animate>
      <div class="ph-products-header__titles">
        <span class="ph-eyebrow">OUR SIGNATURE SELECTION</span>
        <h2 class="ph-section-title">Featured Products</h2>
      </div>

      <!-- Tab Filter Header -->
      <div class="ph-tabs-nav" role="tablist" aria-label="Product categories tabs">
        <button class="ph-tab-btn is-active" data-tab="best-sellers" role="tab" aria-selected="true">
          Best Sellers
        </button>
        <button class="ph-tab-btn" data-tab="top-rated" role="tab" aria-selected="false">
          Top Rated
        </button>
        <button class="ph-tab-btn" data-tab="loved" role="tab" aria-selected="false">
          Loved by Customers
        </button>
      </div>
    </div>

    <!-- Tab Panels Container -->
    <div class="ph-tabs-content">
      <!-- Panel 1: Best Sellers (Active) -->
      <div class="ph-tab-panel is-active" id="tab-best-sellers" role="tabpanel">
        <div class="woocommerce">
          <ul class="products columns-4 ph-grid-products">
            <?php
            $q = new WP_Query([
              'post_type'      => 'product',
              'posts_per_page' => 8,
              'post_status'    => 'publish',
              'orderby'        => 'menu_order title',
              'order'          => 'ASC',
            ]);

            if ($q->have_posts()):
              while ($q->have_posts()): $q->the_post();
                get_template_part('woocommerce/content-product');
              endwhile;
              wp_reset_postdata();
            else:
              // Static Fallback Cards to ensure rich visual demonstration
              $fallback_products = [
                [
                  'name'      => 'Pure Raw Wildflower Honey Jar (500g)',
                  'cat'       => 'ARTISAN DISPENSERS',
                  'regular'   => '$44.99',
                  'sale'      => '$38.99',
                  'save'      => 'Save $6.00',
                  'image'     => $dir . '/assets/images/products/PH-AD-001.jpg',
                ],
                [
                  'name'      => 'Signature Amber Honey Dispenser & Jar Duo',
                  'cat'       => 'ARTISAN DISPENSERS',
                  'regular'   => '$54.99',
                  'sale'      => '$46.99',
                  'save'      => 'Save $8.00',
                  'image'     => $dir . '/assets/images/products/PH-AD-002.jpg',
                ],
                [
                  'name'      => 'Pure Honey Luxury Wooden Gift Box Set',
                  'cat'       => 'LUXURY GIFT SETS',
                  'regular'   => '$95.00',
                  'sale'      => '$79.99',
                  'save'      => 'Save $15.01',
                  'image'     => $dir . '/assets/images/products/PH-LG-001.jpg',
                ],
                [
                  'name'      => 'Artisanal Ceramic Honey Pot with Dipper',
                  'cat'       => 'ARTISAN DISPENSERS',
                  'regular'   => '$49.99',
                  'sale'      => '$42.99',
                  'save'      => 'Save $7.00',
                  'image'     => $dir . '/assets/images/products/PH-AD-004.jpg',
                ],
                [
                  'name'      => 'Crystal Clear Honeycomb Jar & Dipper Set',
                  'cat'       => 'ARTISAN DISPENSERS',
                  'regular'   => '$39.99',
                  'sale'      => '$34.99',
                  'save'      => 'Save $5.00',
                  'image'     => $dir . '/assets/images/products/PH-AD-003.jpg',
                ],
                [
                  'name'      => 'Acacia Wood Honey Dipper Set of 3',
                  'cat'       => 'KITCHEN ELEGANCE',
                  'regular'   => '$22.99',
                  'sale'      => '$18.99',
                  'save'      => 'Save $4.00',
                  'image'     => $dir . '/assets/images/products/PH-KE-001.jpg',
                ],
                [
                  'name'      => 'The Beekeeper\'s Treasure Chest',
                  'cat'       => 'LUXURY GIFT SETS',
                  'regular'   => '$139.99',
                  'sale'      => '$119.99',
                  'save'      => 'Save $20.00',
                  'image'     => $dir . '/assets/images/products/PH-LG-005.jpg',
                ],
                [
                  'name'      => 'Copper Bee Measuring Spoon Set',
                  'cat'       => 'KITCHEN ELEGANCE',
                  'regular'   => '$34.99',
                  'sale'      => '$28.99',
                  'save'      => 'Save $6.00',
                  'image'     => $dir . '/assets/images/products/PH-KE-004.jpg',
                ],
              ];

              foreach ($fallback_products as $fp):
              ?>
              <li class="product ph-product-card">
                <div class="ph-card-inner">
                  <div class="ph-card-media">
                    <div class="ph-card-badges">
                      <span class="ph-badge-sale">Sale!</span>
                      <span class="ph-badge-save"><?php echo esc_html($fp['save']); ?></span>
                    </div>
                    <a href="<?php echo esc_url($shop_url); ?>" class="ph-card-img-link">
                      <img src="<?php echo esc_url($fp['image']); ?>" alt="<?php echo esc_attr($fp['name']); ?>" loading="lazy">
                    </a>
                    <div class="ph-card-quick-add">
                      <a href="<?php echo esc_url($shop_url); ?>" class="button add_to_cart_button">Add to Cart</a>
                    </div>
                  </div>
                  <div class="ph-card-content">
                    <div class="ph-card-category"><?php echo esc_html($fp['cat']); ?></div>
                    <h3 class="ph-card-title">
                      <a href="<?php echo esc_url($shop_url); ?>"><?php echo esc_html($fp['name']); ?></a>
                    </h3>
                    <div class="ph-card-rating">
                      <div class="ph-stars">★★★★★</div>
                      <span class="ph-rating-count">(4.9)</span>
                    </div>
                    <div class="ph-card-price">
                      <del><?php echo esc_html($fp['regular']); ?></del>
                      <ins><?php echo esc_html($fp['sale']); ?></ins>
                    </div>
                    <div class="ph-card-stock">
                      <span class="ph-dot-stock"></span>
                      <span class="ph-stock-text">In stock for delivery • Free Home Delivery</span>
                    </div>
                    <div class="ph-card-btn-wrap">
                      <a href="<?php echo esc_url($shop_url); ?>" class="ph-btn-card-add">Add to Cart →</a>
                    </div>
                  </div>
                </div>
              </li>
              <?php
              endforeach;
            endif;
            ?>
          </ul>
        </div>
      </div>

      <!-- Panel 2: Top Rated -->
      <div class="ph-tab-panel" id="tab-top-rated" role="tabpanel" style="display:none;">
        <div class="woocommerce">
          <ul class="products columns-4 ph-grid-products">
            <?php
            $q2 = new WP_Query([
              'post_type'      => 'product',
              'posts_per_page' => 4,
              'post_status'    => 'publish',
              'orderby'        => 'rand',
            ]);
            if ($q2->have_posts()):
              while ($q2->have_posts()): $q2->the_post();
                get_template_part('woocommerce/content-product');
              endwhile;
              wp_reset_postdata();
            endif;
            ?>
          </ul>
        </div>
      </div>

      <!-- Panel 3: Loved by Customers -->
      <div class="ph-tab-panel" id="tab-loved" role="tabpanel" style="display:none;">
        <div class="woocommerce">
          <ul class="products columns-4 ph-grid-products">
            <?php
            $q3 = new WP_Query([
              'post_type'      => 'product',
              'posts_per_page' => 4,
              'post_status'    => 'publish',
              'orderby'        => 'date',
              'order'          => 'DESC',
            ]);
            if ($q3->have_posts()):
              while ($q3->have_posts()): $q3->the_post();
                get_template_part('woocommerce/content-product');
              endwhile;
              wp_reset_postdata();
            endif;
            ?>
          </ul>
        </div>
      </div>
    </div>

    <!-- View All Button -->
    <div class="text-center" style="margin-top: 48px;" data-ph-animate>
      <a href="<?php echo esc_url($shop_url); ?>" class="ph-btn ph-btn--primary ph-btn--lg">
        Explore Full Catalog (15 Products) →
      </a>
    </div>
  </div>
</section>

<!-- ════════════ 5. DUAL PROMOTIONAL BANNERS SECTION ════════════ -->
<section class="ph-section ph-section--neutral" id="promo-banners">
  <div class="ph-container">
    <div class="ph-promo-grid" data-ph-stagger>

      <!-- Promo Card A: 100% Pure Honey -->
      <div class="ph-promo-card ph-promo-card--honey" data-ph-animate>
        <div class="ph-promo-card__content">
          <span class="ph-promo-card__eyebrow">RAW & UNPASTEURIZED</span>
          <h3 class="ph-promo-card__title">
            100% Pure Honey — Good for your health, Great for your life
          </h3>
          <p class="ph-promo-card__text">
            Rich in active enzymes, natural antioxidants, and floral notes. Hand-extracted without heating to preserve pure wellness.
          </p>
          <a href="<?php echo esc_url($shop_url . '?category=handpicked-honey'); ?>" class="ph-btn ph-btn--primary">
            Shop Honey →
          </a>
        </div>
        <div class="ph-promo-card__visual">
          <img src="<?php echo esc_url($dir . '/assets/images/categories/handpicked-honey.jpg'); ?>" 
               alt="100% Pure Raw Honey" 
               loading="lazy">
        </div>
      </div>

      <!-- Promo Card B: Gift Boxes -->
      <div class="ph-promo-card ph-promo-card--gifts" data-ph-animate>
        <div class="ph-promo-card__content">
          <span class="ph-promo-card__eyebrow">ARTISAN GIFT HAMPERS</span>
          <h3 class="ph-promo-card__title">
            Perfect Gifts for Your Loved Ones — Gift boxes for every occasion
          </h3>
          <p class="ph-promo-card__text">
            Elegant wooden keepsake boxes, complimentary custom greeting notes, and deluxe gold ribbon wrapping included.
          </p>
          <a href="<?php echo esc_url($shop_url . '?category=gift-boxes'); ?>" class="ph-btn ph-btn--primary">
            Shop Gift Boxes →
          </a>
        </div>
        <div class="ph-promo-card__visual">
          <img src="<?php echo esc_url($dir . '/assets/images/categories/gift-boxes.jpg'); ?>" 
               alt="Honey Gift Boxes" 
               loading="lazy">
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ════════════ 6. WHY CHOOSE US SECTION ════════════ -->
<section class="ph-section ph-section--white" id="why-choose-us">
  <div class="ph-container">
    <div class="ph-section-header text-center" data-ph-animate>
      <span class="ph-eyebrow">OUR COMMITMENT</span>
      <h2 class="ph-section-title">Why Choose PureHoney</h2>
      <p class="ph-section-subtitle">We set the gold standard in artisan honey and sustainable kitchen design.</p>
    </div>

    <div class="ph-why-grid" data-ph-stagger>
      <!-- Reason 1: Natural & Pure -->
      <div class="ph-why-card" data-ph-animate>
        <div class="ph-why-card__icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582"/>
          </svg>
        </div>
        <h3 class="ph-why-card__title">Natural & Pure</h3>
        <p class="ph-why-card__desc">
          Single-origin, unheated, unpasteurized. Every drop retains 100% of its native enzymes, delicate wildflower notes, and natural immunity benefits.
        </p>
      </div>

      <!-- Reason 2: Trusted Quality -->
      <div class="ph-why-card" data-ph-animate>
        <div class="ph-why-card__icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.955 11.955 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
          </svg>
        </div>
        <h3 class="ph-why-card__title">Trusted Quality</h3>
        <p class="ph-why-card__desc">
          Engineered using premium borosilicate glass, food-grade 304 stainless steel pumps, and certified sustainably sourced acacia hardwoods.
        </p>
      </div>

      <!-- Reason 3: Fast Delivery -->
      <div class="ph-why-card" data-ph-animate>
        <div class="ph-why-card__icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
          </svg>
        </div>
        <h3 class="ph-why-card__title">Fast Delivery</h3>
        <p class="ph-why-card__desc">
          All orders are securely packaged in recyclable honeycomb cushioning and dispatched within 24 hours with real-time end-to-end tracking.
        </p>
      </div>

      <!-- Reason 4: Happy Customers -->
      <div class="ph-why-card" data-ph-animate>
        <div class="ph-why-card__icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm6 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Z"/>
          </svg>
        </div>
        <h3 class="ph-why-card__title">Happy Customers</h3>
        <p class="ph-why-card__desc">
          Rated 4.9/5 stars by over 2,000+ satisfied households. Enjoy total peace of mind with our no-hassle 30-day money-back satisfaction guarantee.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ════════════ 7. CUSTOMER TESTIMONIALS ════════════ -->
<section class="ph-section ph-section--neutral" id="testimonials">
  <div class="ph-container">
    <div class="ph-section-header text-center" data-ph-animate>
      <span class="ph-eyebrow">VERIFIED REVIEWS</span>
      <h2 class="ph-section-title">Loved by Honey Connoisseurs</h2>
      <p class="ph-section-subtitle">Real experiences from customers who made PureHoney part of their daily routine.</p>
    </div>

    <div class="ph-reviews-grid" data-ph-stagger>
      <div class="ph-review-card" data-ph-animate>
        <div class="ph-review-card__stars">★★★★★</div>
        <p class="ph-review-card__text">
          "The Amber Glass Dispenser with pump changed my morning coffee routine completely. Zero drips, looks exquisite on my counter, and the raw honey tastes incredibly clean."
        </p>
        <div class="ph-review-card__author">
          <div class="ph-review-avatar">SM</div>
          <div class="ph-review-details">
            <strong>Sarah M.</strong>
            <span>Verified Buyer • New York</span>
          </div>
        </div>
      </div>

      <div class="ph-review-card" data-ph-animate>
        <div class="ph-review-card__stars">★★★★★</div>
        <p class="ph-review-card__text">
          "Purchased the Luxury Wooden Gift Box for my mother's birthday. The packaging is heirloom quality and the raw wildflower honey is the best we've ever tasted. 10/10!"
        </p>
        <div class="ph-review-card__author">
          <div class="ph-review-avatar">JR</div>
          <div class="ph-review-details">
            <strong>James R.</strong>
            <span>Verified Buyer • London, UK</span>
          </div>
        </div>
      </div>

      <div class="ph-review-card" data-ph-animate>
        <div class="ph-review-card__stars">★★★★★</div>
        <p class="ph-review-card__text">
          "Super fast delivery and everything arrived in immaculate eco-friendly packaging. The ceramic honey pot with carved wooden dipper is pure art. Will definitely buy again."
        </p>
        <div class="ph-review-card__author">
          <div class="ph-review-avatar">EL</div>
          <div class="ph-review-details">
            <strong>Elena L.</strong>
            <span>Verified Buyer • Sydney</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ════════════ 8. NEWSLETTER SUBSCRIPTION CALLOUT ════════════ -->
<section class="ph-newsletter-section" id="newsletter">
  <div class="ph-container">
    <div class="ph-newsletter-card" data-ph-animate>
      <div class="ph-newsletter-card__content">
        <span class="ph-newsletter-pill">SPECIAL OFFER</span>
        <h2 class="ph-newsletter-title">Get 10% Off Your First Order</h2>
        <p class="ph-newsletter-desc">Subscribe to receive exclusive seasonal harvest announcements, artisan recipes, and subscriber-only promotions.</p>
        
        <form class="ph-newsletter-form" onsubmit="event.preventDefault(); alert('Thank you for subscribing! Your 10% discount code is PURE10');">
          <label for="ph-news-email" class="screen-reader-text">Email Address</label>
          <input type="email" id="ph-news-email" class="ph-newsletter-input" placeholder="Enter your email address…" required autocomplete="email">
          <button type="submit" class="ph-btn ph-btn--primary">Subscribe</button>
        </form>
        <small class="ph-newsletter-note">🔒 Zero spam. Unsubscribe at any time with one click.</small>
      </div>
    </div>
  </div>
</section>

<!-- Elementor / Standard Content Area -->
<div class="ph-container ph-user-content" style="margin-top: 30px; margin-bottom: 30px;">
  <?php while (have_posts()) : the_post(); the_content(); endwhile; ?>
</div>

<?php get_footer(); ?>
