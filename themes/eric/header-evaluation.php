<?php
/**
 * The template for displaying the header
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
  <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'equalrating' ); ?></a>

  <header id="masthead" class="site-header" role="banner">
    <div class="container">
      <div class="site-branding">
        <?php
          if ( is_front_page() && is_home() ) : ?>
            <h1 class="site-title"><a href="<?php echo SITE_URL; ?>" title="<?php echo SITE_NAME; ?>" rel="home"><img src="<?php echo THEME_PATH.'/images/logo.png';?>" alt="<?php echo SITE_NAME; ?>" class="img-responsive" /></a></h1>
          <?php else : ?>
            <p class="site-title"><a href="<?php echo SITE_URL; ?>" title="<?php echo SITE_NAME; ?>" rel="home"><img src="<?php echo THEME_PATH.'/images/logo.png';?>" alt="<?php echo SITE_NAME; ?>" class="img-responsive" /></a></p>
          <?php endif; 
        ?>
      </div><!-- .site-branding -->
      
      
      <ul class="judges-naviation">
        <li><a href="<?php echo SITE_URL.'/submissions';?>">Submissions</a></li>
        <li><a href="<?php echo SITE_URL.'/logout';?>">Log out</a></li>
      </ul>
    </div>
  </header><!-- .site-header -->

  <div id="content" class="site-content">
