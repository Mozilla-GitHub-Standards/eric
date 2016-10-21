<?php
/**
 * The template for submission process page
 * Template Name: Submission Process
 */

get_header(); ?>
<div id="primary" class="content-area">
  <main id="main" class="site-main page-about" role="main">
  <?php
    // Start the loop.
    while ( have_posts() ) : the_post(); 
      // Include the page content template.
      get_template_part( 'template-parts/content', 'process' );
    endwhile; ?>
  </main><!-- .site-main -->
</div><!-- .content-area -->

<?php 
get_footer();
