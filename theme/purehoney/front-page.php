<?php
/**
 * Homepage template — full pre-built layout
 * All sections render automatically on activation
 */
defined('ABSPATH') || exit;



get_header();
$shop_url     = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop');
$about_url    = home_url('/about-us');
$dir          = get_template_directory_uri();
?>

<!-- ══ HERO ══ -->
<section class="ph-hero" id="home-hero">
  <div class="ph-hero__bg" style="background-image:url('<?php echo esc_url($dir . '/assets/images/hero-bg.jpg'); ?>');" role="img" aria-label="Golden honey jars on marble countertop"></div>
  <div class="ph-hero__overlay"></div>
  <div class="ph-container">
    <div class="ph-hero__content" data-ph-animate>
      <span class="ph-hero__eyebrow">Nature's Gold, Elegantly Dispensed</span>
      <h1 class="ph-hero__title">Where <span>Honey Meets</span><br>Artisan Elegance</h1>
      <p class="ph-hero__text">Discover our curated collection of handcrafted honey dispensers, luxury gift sets, and kitchen essentials — for those who believe every moment deserves beauty.</p>
      <div class="ph-hero__cta">
        <a href="<?php echo esc_url($shop_url); ?>" class="ph-btn ph-btn--primary ph-btn--lg">
          Shop the Collection
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        <a href="<?php echo esc_url($about_url); ?>" class="ph-btn ph-btn--ghost ph-btn--lg">Our Story</a>
      </div>
    </div>
  </div>
  <div class="ph-hero__badge ph-hero__badge--1"><strong>⭐ 4.9/5</strong><small>2,000+ Reviews</small></div>
  <div class="ph-hero__badge ph-hero__badge--2"><strong>🚀 Fast Shipping</strong><small>2–4 Business Days</small></div>
  <div class="ph-hero__scroll" aria-hidden="true">
    <span>Scroll</span>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
  </div>
</section>

<!-- ══ TRUST BAR ══ -->
<?php echo do_shortcode('[ph_trust_bar]'); ?>

<!-- ══ FEATURED PRODUCTS ══ -->
<section class="ph-section" id="featured">
  <div class="ph-container">
    <div class="ph-section-title" data-ph-animate>
      <span class="eyebrow">Handpicked For You</span>
      <h2>Top Picks This Season</h2>
      <p>Our most-loved dispensers and gift sets — crafted for beauty and everyday elegance.</p>
    </div>
    <div data-ph-stagger>
      <?php
      $q = new WP_Query(['post_type' => 'product', 'posts_per_page' => 5, 'meta_key' => '_featured', 'meta_value' => 'yes', 'post_status' => 'publish']);
      if ($q->have_posts()):
        echo '<div class="woocommerce"><ul class="products columns-5">';
        while ($q->have_posts()) { $q->the_post(); wc_get_template_part('content', 'product'); }
        wp_reset_postdata();
        echo '</ul></div>';
      else:
        echo do_shortcode('[products limit="5" columns="5" orderby="popularity"]');
      endif;
      ?>
    </div>
    <div class="text-center" style="margin-top:40px;" data-ph-animate>
      <a href="<?php echo esc_url($shop_url); ?>" class="ph-btn ph-btn--outline">View All Products →</a>
    </div>
  </div>
</section>

<!-- ══ CATEGORY CARDS ══ -->
<section class="ph-section ph-section--dark2" id="categories">
  <div class="ph-container">
    <div class="ph-section-title" data-ph-animate>
      <span class="eyebrow">Browse By Category</span>
      <h2>Explore Our Collections</h2>
    </div>
    <div class="ph-cat-grid" data-ph-stagger>
      <a href="<?php echo esc_url(get_term_link('artisan-dispensers', 'product_cat')); ?>" class="ph-cat-card" data-ph-animate>
        <img src="<?php echo esc_url($dir . '/assets/images/cat-dispensers.jpg'); ?>" alt="Artisan Dispensers" loading="lazy">
        <div class="ph-cat-card__content">
          <span class="ph-cat-card__label">Collection</span>
          <h3 class="ph-cat-card__title">Artisan Dispensers</h3>
          <span class="ph-cat-card__link">Shop Now <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </div>
      </a>
      <a href="<?php echo esc_url(get_term_link('luxury-gift-sets', 'product_cat')); ?>" class="ph-cat-card" data-ph-animate>
        <img src="<?php echo esc_url($dir . '/assets/images/cat-gifts.jpg'); ?>" alt="Luxury Gift Sets" loading="lazy" onerror="this.src='<?php echo esc_url($dir . '/assets/images/hero-bg.jpg'); ?>'">
        <div class="ph-cat-card__content">
          <span class="ph-cat-card__label">Collection</span>
          <h3 class="ph-cat-card__title">Luxury Gift Sets</h3>
          <span class="ph-cat-card__link">Shop Now <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </div>
      </a>
      <a href="<?php echo esc_url(get_term_link('kitchen-elegance', 'product_cat')); ?>" class="ph-cat-card" data-ph-animate>
        <img src="<?php echo esc_url($dir . '/assets/images/cat-kitchen.jpg'); ?>" alt="Kitchen Elegance" loading="lazy">
        <div class="ph-cat-card__content">
          <span class="ph-cat-card__label">Collection</span>
          <h3 class="ph-cat-card__title">Kitchen Elegance</h3>
          <span class="ph-cat-card__link">Shop Now <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </div>
      </a>
    </div>
  </div>
</section>

<!-- ══ STORY ══ -->
<section class="ph-section--cream" id="our-story">
  <div class="ph-container">
    <div class="ph-story">
      <div class="ph-story__visual" data-ph-animate="fade-left">
        <img src="<?php echo esc_url($dir . '/assets/images/cat-dispensers.jpg'); ?>" alt="Artisan honey jars" loading="lazy">
      </div>
      <div class="ph-story__content" data-ph-animate="fade-right">
        <span class="eyebrow">Our Story</span>
        <h2>Born from a Love of<br>Nature's Sweetest Gift</h2>
        <p>PureHoney started with a simple belief: that honey — the world's oldest natural sweetener — deserves to be presented as the treasure it truly is.</p>
        <p>We partnered with artisan craftspeople across Europe and North America to create dispensers and accessories that honor both the bees and the people who love their golden harvest.</p>
        <a href="<?php echo esc_url($about_url); ?>" class="ph-btn ph-btn--dark" style="margin-top:8px;">Read Our Story</a>
        <div class="ph-story__stats">
          <div>
            <span class="ph-story__stat-number" data-ph-count="2000" data-ph-count-suffix="+">2000+</span>
            <span class="ph-story__stat-label">Happy Customers</span>
          </div>
          <div>
            <span class="ph-story__stat-number" data-ph-count="15" data-ph-count-suffix="+">15+</span>
            <span class="ph-story__stat-label">Artisan Products</span>
          </div>
          <div>
            <span class="ph-story__stat-number" data-ph-count="98" data-ph-count-suffix="%">98%</span>
            <span class="ph-story__stat-label">Satisfaction Rate</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══ BEST SELLERS ══ -->
<section class="ph-section ph-section--dark" id="best-sellers">
  <div class="ph-container">
    <div class="ph-section-title" data-ph-animate>
      <span class="eyebrow">Customer Favourites</span>
      <h2>Best Sellers</h2>
      <p>The products our customers can't stop gifting — or keeping for themselves.</p>
    </div>
    <div data-ph-stagger>
      <?php echo do_shortcode('[products best_selling="true" limit="8" columns="4"]'); ?>
    </div>
  </div>
</section>

<!-- ══ FEATURES ══ -->
<section class="ph-section ph-section--dark2" id="why-purehoney">
  <div class="ph-container">
    <div class="ph-section-title" data-ph-animate>
      <span class="eyebrow" style="color:var(--ph-gold);">Why PureHoney</span>
      <h2>Crafted With Intention</h2>
    </div>
    <div class="grid-4" data-ph-stagger>
      <?php
      $features = [
        ['icon'=>'M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z', 'title'=>'Pure Materials', 'text'=>'Premium borosilicate glass, natural bamboo, and food-grade materials — always BPA-free.'],
        ['icon'=>'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z', 'title'=>'Crafted with Love', 'text'=>'Every item handpicked by our artisan curators who test for quality, beauty, and elegance.'],
        ['icon'=>'M20.893 13.393l-1.135-1.135a2.252 2.252 0 0 1-.421-.585l-1.08-2.16a.414.414 0 0 0-.663-.107.827.827 0 0 1-.812.21l-1.273-.363a.89.89 0 0 0-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.212.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 0 1-1.81 1.025 1.055 1.055 0 0 1-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.655-.261a2.25 2.25 0 0 1-1.383-2.46l.007-.042a2.25 2.25 0 0 1 .29-.787l.09-.15a2.25 2.25 0 0 1 2.37-1.048l1.178.236a1.125 1.125 0 0 0 1.302-.795l.208-.73a1.125 1.125 0 0 0-.578-1.315l-.665-.332', 'title'=>'Eco Packaging', 'text'=>'100% recyclable packaging. Zero single-use plastic. FSC-certified gift boxes.'],
        ['icon'=>'M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0', 'title'=>'Fast Delivery', 'text'=>'Orders dispatched within 24 hours. Free shipping on orders over $59 with tracking.'],
      ];
      foreach ($features as $f):
      ?>
      <div class="ph-feature" data-ph-animate>
        <div class="ph-feature__icon">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="26" height="26"><path stroke-linecap="round" stroke-linejoin="round" d="<?php echo esc_attr($f['icon']); ?>"/></svg>
        </div>
        <h3 class="ph-feature__title"><?php echo esc_html($f['title']); ?></h3>
        <p class="ph-feature__text"><?php echo esc_html($f['text']); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══ TESTIMONIALS ══ -->
<section class="ph-section" id="reviews">
  <div class="ph-container">
    <div class="ph-section-title" data-ph-animate>
      <span class="eyebrow">Real Reviews</span>
      <h2>What Our Customers Say</h2>
    </div>
    <div class="grid-3" data-ph-stagger>
      <?php
      $reviews = [
        ['text'=>'"I bought the Hexagonal Glass Honey Jar as a birthday gift and the recipient absolutely loved it. Beautifully packaged, arrived perfectly safe, and looks stunning on her counter."','name'=>'Sarah M.','meta'=>'Verified Buyer · New York, USA'],
        ['text'=>'"The Golden Harvest Gift Set is worth every penny. The quality is exceptional — each jar is thick glass and the lids seal perfectly. My mother-in-law was over the moon."','name'=>'James R.','meta'=>'Verified Buyer · London, UK'],
        ['text'=>'"I\'ve been using the Amber Glass Honey Dispenser with Pump for 3 months now. Zero drips, easy to clean, and looks gorgeous on my kitchen shelf. Would buy again!"','name'=>'Priya K.','meta'=>'Verified Buyer · Toronto, Canada'],
      ];
      foreach ($reviews as $r):
      ?>
      <div class="ph-testimonial" data-ph-animate>
        <div class="ph-testimonial__stars">
          <?php for ($i = 0; $i < 5; $i++): ?>
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="16" height="16"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" fill="#E8961A"/></svg>
          <?php endfor; ?>
        </div>
        <p class="ph-testimonial__text"><?php echo esc_html($r['text']); ?></p>
        <div class="ph-testimonial__author">
          <div style="width:44px;height:44px;border-radius:50%;background:var(--ph-gold-gradient);display:flex;align-items:center;justify-content:center;color:var(--ph-charcoal);font-weight:800;font-size:1.125rem;flex-shrink:0;">
            <?php echo esc_html(substr($r['name'], 0, 1)); ?>
          </div>
          <div>
            <p class="ph-testimonial__name"><?php echo esc_html($r['name']); ?></p>
            <p class="ph-testimonial__meta"><?php echo esc_html($r['meta']); ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══ NEWSLETTER ══ -->
<section class="ph-newsletter" id="newsletter">
  <div class="ph-container">
    <div class="ph-newsletter__inner" data-ph-animate>
      <span class="eyebrow" style="color:var(--ph-gold);">Stay in the Loop</span>
      <h2 class="ph-newsletter__title">Get 10% Off Your First Order</h2>
      <p class="ph-newsletter__subtitle">Subscribe for exclusive deals, new arrivals, and honey lifestyle inspiration.</p>
      <form class="ph-newsletter__form" novalidate>
        <input type="email" class="ph-newsletter__input" placeholder="Enter your email address…" required autocomplete="email">
        <button type="submit" class="ph-btn ph-btn--primary">Subscribe</button>
      </form>
      <p style="font-size:0.75rem;color:rgba(255,255,255,0.25);margin-top:14px;margin-bottom:0;">No spam, ever. Unsubscribe anytime.</p>
    </div>
  </div>
</section>

<!-- User Content (Elementor or Block Editor) -->
<div class="ph-container ph-user-content" style="margin-top: 40px; margin-bottom: 40px;">
  <?php while (have_posts()) : the_post(); the_content(); endwhile; ?>
</div>

<?php get_footer(); ?>
