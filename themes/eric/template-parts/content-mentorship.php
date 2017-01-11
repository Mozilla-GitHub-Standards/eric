<?php
/**
 * The template used for displaying mentorship page content
 */
?>

<div class="banner-mentorship">
  <?php 
    $image_desktop = THEME_PATH . '/images/mentorship-image.gif';
    $image_mobile = THEME_PATH . '/images/mobile-mentorship-image.gif';
    echo '<img src="'.$image_desktop.'" class="img-fluid hidden-xs-down">';
    echo '<img src="'.$image_mobile.'" class="img-fluid hidden-sm-up">';
  ?>
</div>

<section class="page-section">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-sm-12 col-xs-12">
        <h2 class="page-heading"><?php echo get_custom_post_title();?></h2>
        <div class="entry-content"><?php the_content();?></div>
      </div>

      <div class="col-md-4 col-sm-12 col-xs-12">
        <?php echo eric_widget_mentor();?>
        <?php echo eric_widget_mentorship();?>
      </div>
    </div>
  </div>
</section>
