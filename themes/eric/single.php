<?php
/**
 * The template for displaying all single posts
 */

get_header(); ?>

<section class="page-section">
  <div class="container">
    <div class="col-md-8 col-xs-12">
      <?php
      // Start the loop.
      while ( have_posts() ) : the_post();
        // Include the page content template.
        get_template_part( 'content', '' );
        
        // Previous/next post navigation.
        the_post_navigation( array(
          'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next &raquo;', 'twentysixteen' ) . '</span> ' .
            '<span class="screen-reader-text">' . __( 'Next post:', 'twentysixteen' ) . '</span><br />' .
            '<span class="post-title">%title</span>',
          'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( '&laquo; Previous', 'twentysixteen' ) . '</span> ' .
            '<span class="screen-reader-text">' . __( 'Previous post:', 'twentysixteen' ) . '</span><br />' .
            '<span class="post-title">%title</span>',
        ) );
        
      endwhile;
      ?>
  </div>
      
  <div class="col-md-4 col-xs-12">
    <?php echo get_sidebar();?>
  </div>
  </div><!-- .container -->
</section>

<?php 
get_footer();
