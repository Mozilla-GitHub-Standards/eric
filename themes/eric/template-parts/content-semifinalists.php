<?php
/**
 * The template used for displaying semifinalists page content
 */
?>
<section class="page-section">
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <h2 class="page-heading"><?php echo get_custom_post_title();?></h2>
    <a href="<?php echo SITE_URL;?>/vote/" class="voting-status">COMMUNITY VOTING IS OPEN, <span>CAST YOUR VOTE</span> NOW &#10132;</a>
    <div class="entry-content"><?php the_content();?></div>
  </article><!-- #post-## -->
</section>
