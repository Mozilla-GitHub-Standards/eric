<?php
/**
 * The template used for displaying page content
 */
?>
<section class="page-section">
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <h2 class="page-heading"><?php echo get_custom_post_title();?></h2>
    <div class="entry-content">
      <?php the_content();?>
      <div class="row">
        <div class="col-lg-10 col-md-12 col-lg-offset-1">
          <img src="<?php echo THEME_PATH;?>/images/video-placeholder-pre-demo-day.png" alt="Video placeholder pre demo day" class="img-fluid" />
        </div>
      </div>
    </div>
    
  </article><!-- #post-## -->
</section>
