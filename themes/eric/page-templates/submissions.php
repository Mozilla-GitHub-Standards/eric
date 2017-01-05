<?php
/**
 * The template for submissions listing
 * Template Name: Submissions
 */

if(is_user_logged_in()) :

get_header('evaluation'); ?>
<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">
    <div class="container">
      <section class="page-section">
      <?php
        while ( have_posts() ) : the_post();
          echo '<h2 class="page-heading">'.get_custom_post_title().'</h2>';
          eric_submissions();
        endwhile;
      ?>
      </section>
    </div>
  </main><!-- .site-main -->
</div><!-- .content-area -->

<?php 
get_footer('evaluation');

else :
  wp_redirect(SITE_URL);
endif;