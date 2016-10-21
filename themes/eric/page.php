<?php
/**
 * The template for displaying pages
 * This is the template that displays all pages by default.
 */

get_header(); ?>
<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">
    <div class="container">
      <?php
        // Start the loop.
        while ( have_posts() ) : the_post();
          // Include the page content template.
          get_template_part( 'template-parts/content', 'page' );
        endwhile;
      ?>
    </div>
  </main><!-- .site-main -->
</div><!-- .content-area -->

<?php 
get_footer();
