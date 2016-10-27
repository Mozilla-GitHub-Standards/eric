<?php
/**
 * The template used for key facts page content
 */
?>

<section class="home-section facts-section">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-sm-12 col-xs-12">
        <h2>Important Statistics</h2>
        <div class="entry-content">
          <p>The following data exemplifies some of the most salient issues surrounding Internet access and adoption. The points are color coded to correspond to the World Economic Forum Internet for All framework described in the <a href="<?php echo OVERVIEW_PAGE_URL;?>#frameworks">Overview</a>.</p>
        </div>
        
        <ul class="statistics-categories">
          <li class="infrastructure">Infrastructure</li>
          <li class="affordability">Affordability</li>
          <li class="skills">Skills, awareness & cultural acceptance</li>
          <li class="adoption">Local adoption & use</li>
        </ul>
        
        <div class="row">
          
          
          
          <div id="statistics"><?php echo eric_statistics(); ?></div>
        </div>
        
        
      </div>
      <div class="col-md-4 col-sm-12 col-xs-12">
        <?php echo eric_analyses();?>
      </div>
    </div>
    <div class="entry-content">
      <?php the_content();?>
    </div>
  </div>
</section>