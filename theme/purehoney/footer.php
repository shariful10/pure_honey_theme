<?php defined('ABSPATH') || exit; ?>
</main><!-- #main -->
</div><!-- #page -->

<!-- ════════════ FOOTER (Avoraix Style 4-Column Layout) ════════════ -->
<footer class="ph-footer" id="colophon" role="contentinfo">
  <div class="ph-container">
    <div class="ph-footer__grid">

      <!-- Column 1: Newsletter Subscription & Brand Info -->
      <div class="ph-footer__col ph-footer__col--newsletter">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="ph-footer__brand" aria-label="<?php bloginfo('name'); ?>">
          <span class="ph-footer__brand-text">Pure<span class="ph-text-highlight">Honey</span></span>
        </a>
        <p class="ph-footer__tagline">
          Nature's Sweetness Delivered to Your Home. We curate 100% pure raw wildflower honey, artisan no-drip glass dispensers, and sustainable kitchen accessories.
        </p>
        
        <div class="ph-footer__newsletter-box">
          <h4 class="ph-footer__subheading">Subscribe & Save 10%</h4>
          <form class="ph-footer__newsletter-form" onsubmit="event.preventDefault(); alert('Subscribed successfully! Use code PURE10');">
            <label for="ph-footer-email" class="screen-reader-text">Email Address</label>
            <input type="email" id="ph-footer-email" placeholder="Your email address..." required autocomplete="email">
            <button type="submit" aria-label="Subscribe">Join</button>
          </form>
          <span class="ph-footer__spam-note">✓ We respect your privacy. Unsubscribe anytime.</span>
        </div>

        <div class="ph-footer__social">
          <a href="#" class="ph-footer__social-link" aria-label="Instagram">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18"><rect width="20" height="20" x="2" y="2" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
          </a>
          <a href="#" class="ph-footer__social-link" aria-label="Facebook">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
          </a>
          <a href="#" class="ph-footer__social-link" aria-label="Pinterest">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18"><path d="M12 2C6.48 2 2 6.48 2 12c0 4.24 2.65 7.86 6.39 9.29-.09-.78-.17-1.98.04-2.83.18-.77 1.23-5.22 1.23-5.22s-.31-.63-.31-1.57c0-1.47.85-2.57 1.91-2.57.9 0 1.33.67 1.33 1.48 0 .9-.58 2.26-.87 3.51-.25 1.05.52 1.9 1.55 1.9 1.86 0 3.11-2.4 3.11-5.24 0-2.16-1.47-3.79-4.13-3.79-3.01 0-4.9 2.25-4.9 4.76 0 .87.26 1.47.67 1.94.18.22.21.3.14.55-.05.17-.16.58-.2.74-.07.27-.28.36-.51.27-1.39-.57-2.03-2.1-2.03-3.82 0-2.84 2.4-6.25 7.18-6.25 3.84 0 6.39 2.78 6.39 5.77 0 3.95-2.2 6.9-5.43 6.9-1.09 0-2.12-.59-2.47-1.26 0 0-.58 2.32-.7 2.76-.21.79-.77 1.77-1.18 2.38A10 10 0 0 0 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2z"/></svg>
          </a>
        </div>
      </div>

      <!-- Column 2: Quick Links -->
      <div class="ph-footer__col">
        <h3 class="ph-footer__col-title">Quick Links</h3>
        <ul class="ph-footer__links">
          <li><a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop')); ?>">Shop All Products</a></li>
          <li><a href="<?php echo esc_url(home_url('/about-us')); ?>">About Us</a></li>
          <li><a href="<?php echo esc_url(home_url('/track-order')); ?>">Track Order</a></li>
          <li><a href="<?php echo esc_url(home_url('/contact-us')); ?>">Contact Support</a></li>
          <li><a href="<?php echo esc_url(function_exists('wc_get_account_endpoint_url') ? wc_get_account_endpoint_url('dashboard') : home_url('/my-account')); ?>">My Account</a></li>
          <li><a href="<?php echo esc_url(function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart')); ?>">View Cart</a></li>
        </ul>
      </div>

      <!-- Column 3: Legal & Policies -->
      <div class="ph-footer__col">
        <h3 class="ph-footer__col-title">Legal & Policies</h3>
        <ul class="ph-footer__links">
          <li><a href="<?php echo esc_url(home_url('/terms-conditions')); ?>">Terms & Conditions</a></li>
          <li><a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Privacy Policy</a></li>
          <li><a href="<?php echo esc_url(home_url('/shipping-policy')); ?>">Shipping Policy</a></li>
          <li><a href="<?php echo esc_url(home_url('/returns-refunds')); ?>">Return & Refund Policy</a></li>
          <li><a href="<?php echo esc_url(home_url('/faq')); ?>">FAQ & Help Center</a></li>
        </ul>
      </div>

      <!-- Column 4: Customer Support -->
      <div class="ph-footer__col ph-footer__col--support">
        <h3 class="ph-footer__col-title">Customer Support</h3>
        <div class="ph-footer__support-info">
          <div class="ph-support-item">
            <span class="ph-support-icon">📞</span>
            <div>
              <strong>Phone Helpline:</strong>
              <p><a href="tel:+18005557873">+1 (800) 555-PURE (7873)</a></p>
            </div>
          </div>
          <div class="ph-support-item">
            <span class="ph-support-icon">✉️</span>
            <div>
              <strong>Email Support:</strong>
              <p><a href="mailto:support@purehoney.me">support@purehoney.me</a></p>
            </div>
          </div>
          <div class="ph-support-item">
            <span class="ph-support-icon">📍</span>
            <div>
              <strong>Business Address:</strong>
              <p>PureHoney Artisan Honeyworks<br>742 Evergreen Terrace, Portland, OR 97201</p>
            </div>
          </div>
          <div class="ph-support-item">
            <span class="ph-support-icon">⏰</span>
            <div>
              <strong>Hours:</strong>
              <p>Mon – Sat: 8:00 AM – 8:00 PM EST<br>24/7 Priority Email Ticket Support</p>
            </div>
          </div>
        </div>
      </div>

    </div><!-- .ph-footer__grid -->

    <!-- Bottom Bar -->
    <div class="ph-footer__bottom">
      <p class="ph-footer__copyright">
        &copy; <?php echo esc_html(gmdate('Y')); ?> PureHoney Store. All rights reserved. • Curated with ❤️ for honey enthusiasts worldwide.
      </p>
      
      <div class="ph-footer__payment" aria-label="Accepted payment methods">
        <!-- Visa -->
        <span class="ph-pay-badge" title="Visa">
          <svg width="38" height="24" viewBox="0 0 38 24" fill="none"><rect width="38" height="24" rx="4" fill="#1A1F71"/><path d="M15.2 16.4H13L14.4 8.4H16.6L15.2 16.4ZM22.4 8.6C21.9 8.4 21.1 8.2 20.2 8.2C18 8.2 16.5 9.3 16.5 10.8C16.5 12 17.7 12.6 18.6 13C19.5 13.4 19.8 13.7 19.8 14.1C19.8 14.7 19 15 18.3 15C17.3 15 16.8 14.9 16 14.5L15.7 14.4L15.4 16.3C15.9 16.5 16.9 16.7 17.9 16.7C20.3 16.7 21.7 15.6 21.7 14C21.7 13.1 21.1 12.4 19.8 11.8C19 11.4 18.5 11.1 18.5 10.7C18.5 10.3 19 9.9 19.9 9.9C20.7 9.9 21.2 10.1 21.6 10.2L21.8 10.3L22.1 8.5L22.4 8.6ZM27.5 8.4H25.8C25.3 8.4 24.9 8.5 24.7 9.1L21.4 16.4H23.8L24.3 15.1H27.2L27.5 16.4H29.7L27.5 8.4ZM24.9 13.4C25.1 12.9 25.9 10.8 25.9 10.8C25.9 10.8 26.1 10.3 26.2 9.9L26.4 10.7C26.4 10.7 26.9 12.9 27 13.4H24.9ZM11.7 8.4L9.6 14L9.4 13.2C8.9 11.9 7.7 10.5 6.3 9.8L8.2 16.4H10.6L14.1 8.4H11.7Z" fill="white"/></svg>
        </span>
        <!-- Mastercard -->
        <span class="ph-pay-badge" title="Mastercard">
          <svg width="38" height="24" viewBox="0 0 38 24" fill="none"><rect width="38" height="24" rx="4" fill="#252525"/><circle cx="14" cy="12" r="6" fill="#EB001B"/><circle cx="24" cy="12" r="6" fill="#F79E1B"/><path d="M19 7.8a6 6 0 0 1 0 8.4A6 6 0 0 1 19 7.8Z" fill="#FF5F00"/></svg>
        </span>
        <!-- PayPal -->
        <span class="ph-pay-badge" title="PayPal">
          <svg width="38" height="24" viewBox="0 0 38 24" fill="none"><rect width="38" height="24" rx="4" fill="#F5F5F5"/><text x="6" y="16" font-size="9" font-weight="bold" fill="#003087" font-family="Arial">Pay</text><text x="18" y="16" font-size="9" font-weight="bold" fill="#009CDE" font-family="Arial">Pal</text></svg>
        </span>
        <!-- Apple Pay -->
        <span class="ph-pay-badge" title="Apple Pay">
          <svg width="38" height="24" viewBox="0 0 38 24" fill="none"><rect width="38" height="24" rx="4" fill="#000000"/><text x="7" y="15" font-size="8.5" font-weight="bold" fill="#FFFFFF" font-family="-apple-system, sans-serif">Pay</text></svg>
        </span>
      </div>
    </div>
  </div>
</footer>

<!-- Back to Top Button -->
<button id="ph-back-to-top" class="ph-back-to-top" aria-label="Back to top">
  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
</button>

<?php wp_footer(); ?>
</body>
</html>
