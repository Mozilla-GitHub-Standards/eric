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
  <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentysixteen' ); ?></a>

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
      
      
      <nav id="site-navigation" class="main-navigation" role="navigation">
        <?php 
        if ( has_nav_menu( 'primary' ) ) :
          wp_nav_menu( array(
            'theme_location' => 'primary',
            'menu_class'     => 'primary-menu',
          ) );
        endif;
        ?>
        <button id="menu-toggle" class="menu-toggle">Menu</button>
      </nav><!-- .main-navigation -->
      
      <?php if(get_field('show_countdown', 'option')) :?>
        <div class="countdown-wrapper">
          <h4><?php echo get_field('countdown_title', 'option');?></h4>
          <div class="countdown" data-countdown-date="<?php echo get_field('countdown_datetime', 'option');?>">
            <div class="cd-days"><strong>00</strong><br />days</div>
            <div class="separator">:</div>
            <div class="cd-days"><strong>00</strong><br />hours</div>
            <div class="separator">:</div>
            <div class="cd-days"><strong>00</strong><br />minutes</div>
            <div class="clear"></div>
          </div>
        </div>
      
      <?php endif;?>
      
      
      
      
      
    </div>
  </header><!-- .site-header -->

  <div id="content" class="site-content">