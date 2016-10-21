<?php
/**
 * The template used for displaying current solutions page content
 */
?>

<section class="page-section">
  <div class="container">
    <h2 class="page-heading">Case Studies</h2>
    <div id="casestudies"><?php echo eric_casestudies();?></div>
    
    <h2 class="page-heading">Technology Considerations</h2>
    
    <div class="entry-content">
      <?php the_content();?>
    </div>
  </div><!-- .container -->
</section><!-- .page-section -->
