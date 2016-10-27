<?php
/**
 * The main template file
 */

get_header(); ?>
<section class="page-section">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 col-xs-12">
        <?php
          if ( have_posts() ) :
            while ( have_posts() ) : the_post();
              // Include the page content template.
              get_template_part( 'content', '' );
            endwhile;

            eric_posts_pagination();
          // If no content, include the "No posts found" template.
          else :
        //			get_template_part( 'template-parts/content', 'none' );
          endif;
        ?>
      </div>

      <div class="col-sm-4 col-xs-12">
        <?php get_sidebar();?>
      </div>
    </div>
  </div><!-- .container -->
</section><!-- .page-section -->

<?php 
get_footer();