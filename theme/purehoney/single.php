<?php defined('ABSPATH')||exit; get_header(); ?>
<div class="page-hero"><div class="ph-container"><h1><?php the_title(); ?></h1></div></div>
<div class="ph-section"><div class="ph-container"><div class="entry-content" style="max-width:800px;margin:0 auto;"><?php while(have_posts()):the_post();the_content();endwhile;?></div></div></div>
<?php get_footer(); ?>
