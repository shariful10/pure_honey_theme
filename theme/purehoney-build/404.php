<?php defined('ABSPATH')||exit; get_header(); ?>
<div class="ph-section" style="min-height:70vh;display:flex;align-items:center;">
  <div class="ph-container text-center">
    <p style="font-size:8rem;font-weight:800;color:var(--ph-gold);line-height:1;margin-bottom:0;">404</p>
    <h2 style="font-size:2rem;margin-bottom:16px;">Page Not Found</h2>
    <p style="color:var(--ph-text-muted);margin-bottom:36px;">The page you are looking for does not exist or has been moved.</p>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="ph-btn ph-btn--primary">Go Home</a>
  </div>
</div>
<?php get_footer(); ?>
