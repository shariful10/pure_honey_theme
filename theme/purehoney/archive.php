<?php defined('ABSPATH')||exit; get_header(); ?>
<div class="page-hero"><div class="ph-container"><h1><?php the_archive_title(); ?></h1></div></div>
<div class="ph-section"><div class="ph-container"><div class="woocommerce"><ul class="products columns-4"><?php while(have_posts()):the_post();wc_get_template_part('content','product');endwhile;?></ul></div></div></div>
<?php get_footer(); ?>
