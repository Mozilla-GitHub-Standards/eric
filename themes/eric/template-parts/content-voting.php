<?php
/**
 * The template used for displaying semifinalists page content
 */
?>
<section class="page-section">
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <h2 class="page-heading"><?php echo get_custom_post_title();?></h2>
    
    <div class="voting-status closed">VOTING IS NOW CLOSED</div>
    
    <div class="entry-content"><?php the_content();?></div>
  </article><!-- #post-## -->
</section>
