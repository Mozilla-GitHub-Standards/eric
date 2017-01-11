<?php
/**
 * The template for mentorship page
 * Template Name: Mentorship
 */

get_header(); ?>
<div id="primary" class="content-area">
  <main id="main" class="site-main page-about" role="main">
  <?php
    // Start the loop.
    while ( have_posts() ) : the_post(); 
      // Include the page content template.
      get_template_part( 'template-parts/content', 'mentorship' );
    endwhile; ?>
  </main><!-- .site-main -->
</div><!-- .content-area -->

<?php 
get_footer();
