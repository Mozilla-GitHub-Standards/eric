<?php
/**
 * The template for winning teams page
 * Template Name: Winning Teams
 */

get_header(); ?>
<div id="primary" class="content-area">
  <main id="main" class="site-main page-winners" role="main">
  <?php
    // Start the loop.
    while ( have_posts() ) : the_post(); 
      // Include the page content template.
      get_template_part( 'template-parts/content', 'winners' );
    endwhile; ?>
  </main><!-- .site-main -->
</div><!-- .content-area -->

<?php 
get_footer();
