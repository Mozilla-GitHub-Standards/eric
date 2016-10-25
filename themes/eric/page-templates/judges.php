<?php
/**
 * The template for judges page
 * Template Name: Judges
 */

get_header(); ?>
<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">
    <div class="container">
      <?php
        while ( have_posts() ) : the_post();
          get_template_part( 'template-parts/content', 'judges' );
        endwhile;
      ?>
    </div>
  </main><!-- .site-main -->
</div><!-- .content-area -->

<?php 
get_footer();
