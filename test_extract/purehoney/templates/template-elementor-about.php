<?php
/**
 * Template Name: Elementor - About Us
 * Description: A full-width clean canvas template with theme header and footer for Elementor editing.
 */

defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main elementor-about-wrapper w-full overflow-hidden">
    <?php
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile;
    ?>
</main>

<?php
get_footer();
