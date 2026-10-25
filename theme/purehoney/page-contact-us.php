<?php
/**
 * Template Name: Contact Us Page
 * Description: Custom premium template for the Contact page.
 */

defined('ABSPATH') || exit;

$contact_sent  = false;
$contact_error = '';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['submit_contact'] ) ) {
    if ( ! isset( $_POST['contact_nonce'] ) || ! wp_verify_nonce( $_POST['contact_nonce'], 'purehoney_contact_nonce' ) ) {
        $contact_error = esc_html__( 'Security check failed. Please refresh and try again.', 'purehoney' );
    } else {
        $c_name    = sanitize_text_field( wp_unslash( $_POST['contact_name'] ?? '' ) );
        $c_email   = sanitize_email( wp_unslash( $_POST['contact_email'] ?? '' ) );
        $c_subject = sanitize_text_field( wp_unslash( $_POST['contact_subject'] ?? '' ) );
        $c_message = sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ?? '' ) );

        if ( ! is_email( $c_email ) ) {
            $contact_error = esc_html__( 'Please provide a valid email address.', 'purehoney' );
        } elseif ( empty( $c_name ) || empty( $c_message ) ) {
            $contact_error = esc_html__( 'Please fill in all required fields.', 'purehoney' );
        } else {
            $admin_email = get_option( 'admin_email' );
            $to          = ! empty( $admin_email ) ? $admin_email : 'hello@purehoney.me';
            $subject     = '[PureHoney Contact] ' . ( ! empty( $c_subject ) ? $c_subject : 'New Inquiry' );
            $body        = "Name: {$c_name}\nEmail: {$c_email}\nSubject: {$c_subject}\n\nMessage:\n{$c_message}\n";
            $headers     = array( 'Content-Type: text/plain; charset=UTF-8', "Reply-To: {$c_name} <{$c_email}>" );

            @wp_mail( $to, $subject, $body, $headers );
            $contact_sent = true;
        }
    }
}

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

        <!-- Right Side: Contact Form -->
        <div class="ph-contact-form-wrap" style="background: #FFFFFF; padding: 48px 40px; border-radius: var(--ph-radius-lg); border: 1px solid var(--border-subtle); box-shadow: 0 10px 30px rgba(78,52,23,0.06);">
          <h3 style="color: var(--text-primary); font-size: 1.5rem; margin-bottom: 24px; font-weight: 700;">Send a Message</h3>

          <?php if ( ! empty( $contact_sent ) ) : ?>
            <div style="background: #ECFDF5; border: 1px solid #6EE7B7; color: #065F46; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 0.95rem; line-height: 1.5;">
              <strong style="display: block; font-size: 1rem; margin-bottom: 4px;">Thank you!</strong>
              Your message has been received. Our team will get back to you within 24 hours.
            </div>
          <?php elseif ( ! empty( $contact_error ) ) : ?>
            <div style="background: #FEF2F2; border: 1px solid #FCA5A5; color: #991B1B; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 0.9375rem;">
              <?php echo esc_html( $contact_error ); ?>
            </div>
          <?php endif; ?>

          <div class="ph-form-styles">
            <?php
            // Check if Contact Form 7 exists and has a form available
            $cf7_form_id = get_theme_mod( 'purehoney_cf7_id', '' );

            if ( shortcode_exists( 'contact-form-7' ) && ! empty( $cf7_form_id ) ) {
                echo do_shortcode( '[contact-form-7 id="' . absint( $cf7_form_id ) . '" title="Contact Form"]' );
            } else {
                // Render styled native contact form
            ?>
                <form action="" method="post" class="space-y-4 purehoney-contact-form">
                    <?php wp_nonce_field( 'purehoney_contact_nonce', 'contact_nonce' ); ?>

                    <div style="margin-bottom: 16px;">
                        <label class="block text-sm font-semibold text-[#1C1917] mb-1.5" for="contact_name" style="display: block; font-size: 0.875rem; font-weight: 600; color: #1C1917; margin-bottom: 6px;">Your Name</label>
                        <input type="text" id="contact_name" name="contact_name" required placeholder="John Doe" 
                               value="<?php echo isset($_POST['contact_name']) ? esc_attr($_POST['contact_name']) : ''; ?>"
                               class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-[#FAF6F0]/50 text-[#1C1917] focus:outline-none focus:border-[#D97706] focus:ring-1 focus:ring-[#D97706] transition"
                               style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid #E7E5E4; background: rgba(250, 246, 240, 0.5); color: #1C1917; font-size: 0.95rem; box-sizing: border-box;" />
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label class="block text-sm font-semibold text-[#1C1917] mb-1.5" for="contact_email" style="display: block; font-size: 0.875rem; font-weight: 600; color: #1C1917; margin-bottom: 6px;">Email Address</label>
                        <input type="email" id="contact_email" name="contact_email" required placeholder="you@example.com" 
                               value="<?php echo isset($_POST['contact_email']) ? esc_attr($_POST['contact_email']) : ''; ?>"
                               class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-[#FAF6F0]/50 text-[#1C1917] focus:outline-none focus:border-[#D97706] focus:ring-1 focus:ring-[#D97706] transition"
                               style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid #E7E5E4; background: rgba(250, 246, 240, 0.5); color: #1C1917; font-size: 0.95rem; box-sizing: border-box;" />
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label class="block text-sm font-semibold text-[#1C1917] mb-1.5" for="contact_subject" style="display: block; font-size: 0.875rem; font-weight: 600; color: #1C1917; margin-bottom: 6px;">Subject</label>
                        <input type="text" id="contact_subject" name="contact_subject" required placeholder="Order inquiry, partnership, etc." 
                               value="<?php echo isset($_POST['contact_subject']) ? esc_attr($_POST['contact_subject']) : ''; ?>"
                               class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-[#FAF6F0]/50 text-[#1C1917] focus:outline-none focus:border-[#D97706] focus:ring-1 focus:ring-[#D97706] transition"
                               style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid #E7E5E4; background: rgba(250, 246, 240, 0.5); color: #1C1917; font-size: 0.95rem; box-sizing: border-box;" />
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="block text-sm font-semibold text-[#1C1917] mb-1.5" for="contact_message" style="display: block; font-size: 0.875rem; font-weight: 600; color: #1C1917; margin-bottom: 6px;">Message</label>
                        <textarea id="contact_message" name="contact_message" rows="4" required placeholder="How can we help you?" 
                                  class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-[#FAF6F0]/50 text-[#1C1917] focus:outline-none focus:border-[#D97706] focus:ring-1 focus:ring-[#D97706] transition resize-none"
                                  style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid #E7E5E4; background: rgba(250, 246, 240, 0.5); color: #1C1917; font-size: 0.95rem; resize: none; min-height: 110px; box-sizing: border-box;"><?php echo isset($_POST['contact_message']) ? esc_textarea($_POST['contact_message']) : ''; ?></textarea>
                    </div>

                    <button type="submit" name="submit_contact" 
                            class="w-full py-3.5 px-6 rounded-xl bg-[#D97706] hover:bg-[#B45309] text-white font-medium text-base shadow-sm hover:shadow-md transition duration-200 cursor-pointer"
                            style="width: 100%; padding: 14px 24px; border-radius: 12px; background: #D97706; color: #FFFFFF; font-weight: 600; font-size: 1rem; border: none; cursor: pointer; transition: background 0.2s ease, transform 0.2s ease; box-shadow: 0 4px 14px rgba(217, 119, 6, 0.25);">
                        Send Message
                    </button>
                </form>
            <?php } ?>
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
