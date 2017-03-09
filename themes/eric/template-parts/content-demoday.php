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
      <?php
        $livestream_url = get_field('live_stream_url');
        if($livestream_url && strlen($livestream_url) > 10) {
          echo '<div class="video-wrapper livestream-wrapper"><iframe src="'.$livestream_url.'" frameborder="0" allowfullscreen></iframe></div>';
        } else {
          echo '<img src="'.THEME_PATH.'/images/video-placeholder-pre-demo-day.png" alt="Video placeholder pre demo day" class="img-fluid" />';
        }
      ?>
      <?php echo eric_demoday_program();?>
    </div>
    
  </article><!-- #post-## -->
</section>
