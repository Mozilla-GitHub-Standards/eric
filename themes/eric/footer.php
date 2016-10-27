<?php
/**
 * The template for displaying the footer
 */
?>
    
  </div><!-- .site-content -->
  
  <footer class="site-footer" role="contentinfo">
    <div id="subscribe">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-4 col-xs-12 col-lg-offset-1">
            <h3>Subscribe</h3>
          </div>
          <div class="col-lg-7 col-md-8 col-xs-12">
            <?php getSubscriptionForm();?>
          </div>
        </div>
      </div>
    </div>
    
    
    <div id="colophon">
      <a href="#top" id="goTop" title="Scroll to Top">Top<span></span></a>
      <div class="container">
        <?php if ( has_nav_menu( 'footer' ) ) : ?>
          <nav id="footer-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Primary Menu', 'twentysixteen' ); ?>">
            <?php
              wp_nav_menu( array(
                'theme_location' => 'footer',
                'menu_class'     => 'footer-menu',
               ) );
            ?>
          </nav><!-- .main-navigation -->
        <?php endif; ?>
          
          <div class="contact-info">Contact us with question or suggest a resource: <a href="mailto:equalrating@mozilla.com">equalrating@mozilla.com</a></div>

        <div class="site-info">
          <div class="footer-logo">
            <a href="https://mozilla.org/" target="_blank"><img src="<?php echo THEME_PATH;?>/images/logo-mozilla.png" alt="Link to Mozilla.org"></a>
          </div>
          <p>Mozilla is a global non-profit dedicated to putting you in control of your online experience and shaping the future of the Web for the public good. Visit us at <a href="https://mozilla.org/" target="_blank">mozilla.org</a></p>
        </div><!-- .site-info -->
      </div>
    </div><!-- #colophon -->
    
  </footer><!-- .site-footer -->
</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>
