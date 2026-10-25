<?php
/**
 * Template Name: Elementor Full Width / About Page
 * Description: Fully editable Elementor template for the About page.
 */

defined('ABSPATH') || exit;
get_header();

$is_elementor_page = false;
if ( did_action( 'elementor/loaded' ) ) {
    if ( \Elementor\Plugin::$instance->preview->is_preview_mode() 
         || \Elementor\Plugin::$instance->editor->is_edit_mode() 
         || \Elementor\Plugin::$instance->db->is_built_with_elementor( get_the_ID() ) ) {
        $is_elementor_page = true;
    }
}
?>

<main id="primary" class="site-main about-page-content" style="width: 100%; position: relative;">
    <?php
    if ( $is_elementor_page ) {
        // Render unconstrained Elementor builder canvas
        while ( have_posts() ) :
            the_post();
            the_content();
        endwhile;
    } else {
        // Fallback default theme About layout until edited with Elementor
        ?>
        <div class="ph-page-wrap">
          <!-- Hero Section -->
          <div class="ph-page-hero ph-page-hero--banner" style="background: radial-gradient(ellipse at center, rgba(250, 246, 240, 0.60) 0%, rgba(250, 246, 240, 0.35) 60%, rgba(250, 246, 240, 0.15) 100%), url('<?php echo get_template_directory_uri(); ?>/assets/images/hero-bg.jpg') center/cover; padding: 160px 0 100px;">
            <div class="ph-container text-center">
              <h1 class="ph-page-title" style="margin-bottom: 16px; font-size: clamp(2.5rem, 6vw, 4.5rem); font-weight: 700; color: #1C1917; justify-content: center; text-shadow: 0 1px 12px rgba(255, 255, 255, 0.85);"><?php the_title(); ?></h1>
              <p style="color: #B45309; font-size: 1.125rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase;">Discover the PureHoney difference</p>
            </div>
          </div>

          <!-- Story Section (split grid) -->
          <div class="ph-section" style="background: #FFFFFF;">
            <div class="ph-container">
              <div class="ph-story">
                <div class="ph-story__visual story-image-container" style="border-radius: var(--ph-radius-lg, 1rem); overflow: hidden; box-shadow: 0 10px 30px rgba(78,52,23,0.08); border: 1px solid var(--border-subtle, #EFE6D8); aspect-ratio: 4 / 5; min-height: 480px;">
                  <?php 
                  $story_img = get_theme_mod('about_story_image') ?: get_the_post_thumbnail_url(get_the_ID(), 'large');
                  if (!$story_img) {
                      $story_img = get_stylesheet_directory_uri() . '/assets/images/about-story.jpg';
                  }
                  ?>
                  <img src="<?php echo esc_url($story_img); ?>" 
                       alt="<?php esc_attr_e('Our Story - Pure Honey', 'purehoney'); ?>" 
                       class="w-full h-full object-cover rounded-2xl shadow-md" 
                       loading="lazy" 
                       style="width: 100%; height: 100%; object-fit: cover; aspect-ratio: 4/5; display: block;"
                       onerror="this.src='<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/hero-bg.jpg'); ?>';"
                  />
                </div>
                <div class="ph-story__content">
                  <div class="ph-section-title" style="text-align: left; margin-bottom: 32px;">
                    <span class="eyebrow" style="color: var(--accent-gold); margin-bottom: 12px; display: block;">Our Origin</span>
                    <h2 style="font-size: clamp(2rem, 4vw, 3rem); margin-bottom: 24px; color: var(--text-primary);">The pursuit of<br>golden perfection.</h2>
                    <div style="color: var(--text-secondary); font-size: 1.0625rem; line-height: 1.8;">
                      <p>PureHoney was born from a simple belief: that honey - the world's oldest natural sweetener - deserves to be presented as the treasure it truly is.</p>
                      <p>We partner with artisan craftspeople to create dispensers and accessories that honor both the bees and the people who love their golden harvest. Every piece in our collection is thoughtfully designed, rigorously quality-tested, and beautifully packaged.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Mission & Values Grid -->
          <div class="ph-section ph-section--cream">
            <div class="ph-container">
              <div class="ph-section-title">
                <h2>Why Choose Us</h2>
                <p>Our commitment to quality, sustainability, and design.</p>
              </div>
              
              <div class="grid-3">
                <!-- Value 1 -->
                <div style="background: #FFFFFF; padding: 48px 32px; border-radius: var(--ph-radius-lg); text-align: center; border: 1px solid var(--border-subtle); box-shadow: 0 4px 20px rgba(78,52,23,0.05);">
                  <div style="width: 64px; height: 64px; background: rgba(217, 119, 6, 0.1); color: var(--accent-gold); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                    <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                  </div>
                  <h3 style="color: var(--text-primary); font-size: 1.25rem; margin-bottom: 16px; font-weight: 700;">Uncompromising Quality</h3>
                  <p style="color: var(--text-secondary); font-size: 0.9375rem; line-height: 1.6; margin: 0;">We source only the finest materials, from premium acacia wood to high-grade glass, ensuring lasting durability.</p>
                </div>

                <!-- Value 2 -->
                <div style="background: #FFFFFF; padding: 48px 32px; border-radius: var(--ph-radius-lg); text-align: center; border: 1px solid var(--border-subtle); box-shadow: 0 4px 20px rgba(78,52,23,0.05);">
                  <div style="width: 64px; height: 64px; background: rgba(217, 119, 6, 0.1); color: var(--accent-gold); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                    <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                  </div>
                  <h3 style="color: var(--text-primary); font-size: 1.25rem; margin-bottom: 16px; font-weight: 700;">Sustainably Sourced</h3>
                  <p style="color: var(--text-secondary); font-size: 0.9375rem; line-height: 1.6; margin: 0;">Our wood and materials are responsibly harvested, prioritizing environmental sustainability in every step.</p>
                </div>

                <!-- Value 3 -->
                <div style="background: #FFFFFF; padding: 48px 32px; border-radius: var(--ph-radius-lg); text-align: center; border: 1px solid var(--border-subtle); box-shadow: 0 4px 20px rgba(78,52,23,0.05);">
                  <div style="width: 64px; height: 64px; background: rgba(217, 119, 6, 0.1); color: var(--accent-gold); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                    <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                  </div>
                  <h3 style="color: var(--text-primary); font-size: 1.25rem; margin-bottom: 16px; font-weight: 700;">Gift-Ready Packaging</h3>
                  <p style="color: var(--text-secondary); font-size: 0.9375rem; line-height: 1.6; margin: 0;">Delivered in fully recyclable, premium packaging designed to delight from the moment of unboxing.</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Dynamic Page Content -->
          <?php while ( have_posts() ) : the_post(); ?>
            <?php if ( get_the_content() ) : ?>
              <div class="ph-section" style="padding: 40px 0;">
                <div class="ph-container">
                  <?php the_content(); ?>
                </div>
              </div>
            <?php endif; ?>
          <?php endwhile; ?>
        </div>
        <?php
    }
    ?>
</main>

<?php get_footer(); ?>
