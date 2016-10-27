<?php
/**
 * The template used for displaying submission process page content
 */
?>

<?php echo eric_banner_process();?>

<section class="page-section">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-sm-12 col-xs-12">
        <div id="criteria">
          <h2 class="page-heading">Criteria</h2>
          <div class="entry-content">
            <?php the_content();?>
          </div>
        </div>
        
        <br />
        <?php echo eric_scoring_allocation();?>
      </div>

      <div class="col-md-4 col-sm-12 col-xs-12">
        <?php echo eric_widget_awards();?>
        <?php echo eric_widget_faqs();?>
      </div>
    </div>
  
    <?php echo eric_full_schedule(); ?>
  </div>
</section>