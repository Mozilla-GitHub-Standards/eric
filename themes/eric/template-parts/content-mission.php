<?php
/**
 * The template used for displaying mission page content
 */
?>

<div class="banner-mission">
  <div class="container">
    <div class="banner-quote">
      <?php 
        echo apply_filters('the_content', get_field('mission_header_quote', 'option'));
        echo '<div class="quote-by">'.get_field('mission_header_quote_by', 'option').'</div>';
      ?>
    </div>
  </div>
</div>

<section class="page-section">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-sm-12 col-xs-12">
        <h2 class="page-heading"><?php echo get_custom_post_title();?></h2>
        <div class="entry-content"><?php the_content();?></div>
      </div>

      <div class="col-md-4 col-sm-12 col-xs-12">
        <?php echo eric_widget_equalrating();?>
      </div>
    </div>
  </div>
</section>