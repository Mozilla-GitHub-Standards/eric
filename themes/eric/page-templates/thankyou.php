<?php
/**
 * The template for thank you page
 * Template Name: Thank You
 */

get_header(); ?>
<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">
  <?php
    // Start the loop.
    while ( have_posts() ) : the_post();
      // Include the page content template.
      get_template_part( 'template-parts/content', 'thankyou' );
    endwhile; ?>
  </main><!-- .site-main -->
</div><!-- .content-area -->

<?php 
get_footer();
