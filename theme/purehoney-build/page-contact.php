<?php
/**
 * Template Name: Contact Page
 * Description: Custom premium template for the Contact page.
 */

defined('ABSPATH') || exit;
get_header();
?>

<div class="ph-page-wrap">
  <!-- Hero Section -->
  <div class="ph-page-hero ph-page-hero--banner" style="background: radial-gradient(ellipse at center, rgba(250, 246, 240, 0.60) 0%, rgba(250, 246, 240, 0.35) 60%, rgba(250, 246, 240, 0.15) 100%), url('<?php echo get_template_directory_uri(); ?>/assets/images/hero-bg.jpg') center/cover; padding: 160px 0 100px;">
    <div class="ph-container text-center">
      <h1 class="ph-page-title" style="margin-bottom: 16px; font-size: clamp(2.5rem, 6vw, 4.5rem); font-weight: 700; color: #1C1917; justify-content: center; text-shadow: 0 1px 12px rgba(255, 255, 255, 0.85);"><?php the_title(); ?></h1>
      <p style="color: #B45309; font-size: 1.125rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase;">We're Here for You</p>
    </div>
  </div>

  <!-- Contact Split Section -->
  <div class="ph-section" style="background: #FFFFFF;">
    <div class="ph-container">
      <div class="ph-story">
        
        <!-- Left Side: Contact Information -->
        <div class="ph-contact-info" style="padding-right: 4vw;">
          <div class="ph-section-title" style="text-align: left; margin-bottom: 40px;">
            <span class="eyebrow" style="color: var(--accent-gold); margin-bottom: 12px; display: block;">Get in Touch</span>
            <h2 style="font-size: clamp(2rem, 3.5vw, 2.75rem); margin-bottom: 24px; color: var(--text-primary);">How can we help?</h2>
            <p style="color: var(--text-secondary); font-size: 1.0625rem; line-height: 1.8;">Whether you have a question about our products, need assistance with an order, or just want to say hello, our team is ready to assist you.</p>
          </div>

          <div class="ph-contact-methods" style="display: flex; flex-direction: column; gap: 32px;">
            <!-- Email -->
            <div style="display: flex; align-items: flex-start; gap: 20px;">
              <div style="width: 50px; height: 50px; border-radius: 50%; background: rgba(217,119,6,0.1); border: 1px solid rgba(217,119,6,0.25); display: flex; align-items: center; justify-content: center; color: var(--accent-gold); flex-shrink: 0;">
                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
              </div>
              <div>
                <h3 style="color: var(--text-primary); font-size: 1.125rem; font-weight: 700; margin-bottom: 8px;">Email Us</h3>
                <p style="color: var(--text-secondary); margin-bottom: 4px; font-size: 0.9375rem;">Our friendly team is here to help.</p>
                <a href="mailto:hello@purehoney.me" style="color: var(--accent-gold); font-weight: 600; font-size: 1.0625rem; text-decoration: none;">hello@purehoney.me</a>
              </div>
            </div>

            <!-- Hours -->
            <div style="display: flex; align-items: flex-start; gap: 20px;">
              <div style="width: 50px; height: 50px; border-radius: 50%; background: rgba(217,119,6,0.1); border: 1px solid rgba(217,119,6,0.25); display: flex; align-items: center; justify-content: center; color: var(--accent-gold); flex-shrink: 0;">
                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
              </div>
              <div>
                <h3 style="color: var(--text-primary); font-size: 1.125rem; font-weight: 700; margin-bottom: 8px;">Business Hours</h3>
                <p style="color: var(--text-secondary); margin-bottom: 4px; font-size: 0.9375rem;">Monday - Friday</p>
                <p style="color: var(--text-primary); font-weight: 600; font-size: 1.0625rem; margin: 0;">9:00 AM — 5:00 PM (EST)</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Side: Contact Form (pulled from editor) -->
        <div class="ph-contact-form-wrap" style="background: #FFFFFF; padding: 48px 40px; border-radius: var(--ph-radius-lg); border: 1px solid var(--border-subtle); box-shadow: 0 10px 30px rgba(78,52,23,0.06);">
          <h3 style="color: var(--text-primary); font-size: 1.5rem; margin-bottom: 24px; font-weight: 700;">Send a Message</h3>
          <div class="ph-form-styles">
            <?php 
              while (have_posts()): the_post();
                the_content();
              endwhile; 
            ?>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Form Styling Overrides specifically for CF7 -->
  <style>
    .ph-form-styles p { margin-bottom: 20px; color: var(--text-secondary); font-size: 0.9375rem; }
    .ph-form-styles label { display: block; color: var(--text-primary); font-weight: 600; margin-bottom: 8px; font-size: 0.9375rem; }
    .ph-form-styles input[type="text"], 
    .ph-form-styles input[type="email"], 
    .ph-form-styles input[type="tel"],
    .ph-form-styles textarea {
      width: 100%;
      background: #FFFFFF;
      border: 1.5px solid var(--border-subtle);
      color: var(--text-primary);
      padding: 14px 16px;
      border-radius: var(--ph-radius-sm);
      font-family: var(--font-body);
      transition: all 0.3s ease;
    }
    .ph-form-styles input:focus, 
    .ph-form-styles textarea:focus {
      outline: none;
      border-color: var(--accent-gold);
      box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.15);
    }
    .ph-form-styles input[type="submit"] {
      background: var(--ph-gold-gradient);
      color: #FFFFFF;
      font-weight: 700;
      border: none;
      padding: 16px 32px;
      border-radius: var(--ph-radius-sm);
      cursor: pointer;
      width: 100%;
      margin-top: 10px;
      box-shadow: 0 4px 18px rgba(217, 119, 6, 0.32);
      transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
    }
    .ph-form-styles input[type="submit"]:hover {
      transform: translateY(-2px);
      background: var(--accent-hover);
      box-shadow: 0 8px 24px rgba(180, 83, 9, 0.4);
    }
    .wpcf7-not-valid-tip { font-size: 0.8125rem; color: #dc2626; margin-top: 4px; }
    .wpcf7-response-output { border-radius: var(--ph-radius-sm) !important; margin: 24px 0 0 !important; font-size: 0.875rem; border: 1px solid var(--border-subtle); background: #FAF5EE; color: var(--text-primary); }
  </style>
</div>

<?php get_footer(); ?>
