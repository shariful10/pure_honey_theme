<?php get_header(); ?>
<div class="ph-container" style="padding-top:120px;padding-bottom:60px;">
<?php if (have_posts()): while (have_posts()): the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  <?php the_excerpt(); ?>
</article>
<?php endwhile; else: ?>
<p style="color:var(--ph-text-muted);"><?php esc_html_e('No posts found.','purehoney'); ?></p>
<?php endif; ?>
</div>
<?php get_footer(); ?>
