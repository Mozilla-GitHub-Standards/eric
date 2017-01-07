<?php
/**
 * The template for submission entry
 * Template Name: Submission Entry
 */

if(is_user_logged_in()) :

get_header('evaluation'); ?>
<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">
    <div class="container">
      <section class="page-section">
      <?php
        while ( have_posts() ) : the_post();
          eric_submission_view($_GET['secret']);
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