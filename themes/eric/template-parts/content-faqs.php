<?php
/**
 * The template used for displaying page content
 */

$faqs = eric_get_faqs();
?>

<section class="page-section">
  <div class="container">
    <h2 class="page-heading">FAQs</h2>
    <div class="row">
      <div class="col-md-8 col-sm-12 col-xs-12">
        <?php echo eric_faqs_dropdown($faqs);?>
        
        <div class="faqs-list">
          <?php echo eric_faqs_list($faqs); ?>
        </div>
      </div>
      
      <div class="col-md-4 col-sm-12 col-xs-12">
        <?php echo eric_widget_submission_process();?>
      </div>
    </div>
  </div>
</section>