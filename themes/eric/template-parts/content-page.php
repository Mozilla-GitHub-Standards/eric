<?php
/**
 * The template used for displaying page content
 */
?>
<section class="page-section">
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="container">
      <div class="row">
        <div class="col-lg-10 col-md-12 col-lg-offset-1">
          <h2 class="page-heading"><?php echo get_custom_post_title();?></h2>
          <div class="entry-content">
            <?php the_content();?>
          </div>
        </div>
      </div>
    </div>
  </article><!-- #post-## -->
</section>
