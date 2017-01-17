<?php
/**
 * The template for semifinalists page
 * Template Name: Semifinalists
 */

get_header(); ?>
<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">
    <div class="container">
      <?php
        while ( have_posts() ) : the_post();
          get_template_part( 'template-parts/content', 'semifinalists' );
        endwhile;
      ?>
    </div>
  </main><!-- .site-main -->
</div><!-- .content-area -->

<?php 
get_footer();
