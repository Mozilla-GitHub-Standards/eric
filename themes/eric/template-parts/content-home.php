<?php
/**
 * The template used for displaying home page content
 */
?>

<div class="banner-home">
  <div class="container">
    <ul class="home-carousel">
    <?php 
      $slides = array(
          0 => array(
              'banner_desktop' => 'home-banner-cta.gif',
              'banner_mobile' => 'mobile-home-banner-cta.gif',
              'link_url' => SITE_URL .'/submission-form/'
          ),
          1 => array(
              'banner_desktop' => 'home-banner-process.gif',
              'banner_mobile' => 'mobile-home-banner-process.gif',
              'link_url' => SITE_URL .'/your-submission/#schedule'
          ),
          2 => array(
              'banner_desktop' => 'home-banner-mozilla.gif',
              'banner_mobile' => 'mobile-home-banner-mozilla.gif',
              'link_url' => SITE_URL .'/your-submission'
          ),
      );
      
      foreach($slides as $slide) {
        echo '<li class="slide"><a href="'.$slide['link_url'].'">';
          echo '<img src="'.THEME_PATH.'/images/banner-home/'.$slide['banner_desktop'].'" class="img-fluid hidden-xs-down">';
          echo '<img src="'.THEME_PATH.'/images/banner-home/'.$slide['banner_mobile'].'" class="img-fluid hidden-sm-up">';
        echo '</a></li>';
      }
    ?>
    </ul>
  </div>
</div>

<section class="page-section">

<div class="container">
  <div class="row">
    <div class="col-md-8 col-sm-12 col-xs-12">
      <div class="home-page-content equalrating">
        <h2>We Believe in Equal Rating</h2>
        <p>Mozilla seeks to make the full range of the Internet’s extraordinary power and innovative potential available to all. We advocate for &ldquo;equal rating&rdquo; where consumers choose content based on the quality of that content, not the financial power and business partnerships of the provider. </p>
        <p>Equal Rating practices meet the following criteria:</p>
        
        <div class="widget-equalrating">
          <h3>3 Requirements for Equal Rating</h3>
          <ol>
            <li>They are content-agnostic.</li>
            <li>They are not subject to gatekeepers.</li>
            <li>They do not allow pay-for-play.</li>
          </ol>
        </div>
        <p>Read more on <a href="<?php echo MISSION_PAGE_URL;?>">Mozilla&rsquo;s equal rating work here</a>.</p>
      </div>
        
      <div class="home-page-content">
        <div class="row">
          <div class="col-lg-6 col-md-12">
            <div class="bostel-knowledge">
              <h3>Bolster your knowledge</h3>
              <!--<h4>RESOURCES</h4>-->
              <p><em>New to <a href="<?php echo MISSION_PAGE_URL;?>">equal rating</a>, or brushing up on your know-how?</em></p>
              <p>Check out <a href="<?php echo OVERVIEW_PAGE_URL;?>#frameworks">our frameworks</a> to analyze the core issues, read about way others have tried to solve the problem in these <a href="<?php echo SOLUTIONS_PAGE_URL;?>">case studies</a>, and do some further investigation in our <a href="<?php echo FACTS_PAGE_URL;?>">reports roundup</a>.</p>
              <p>Have a great resource to share, <a href="mailto:info@equalrating.com">let us know!</a></p>
            </div>
          </div>
          
          <div class="col-lg-6 col-md-12">
            <?php echo eric_widget_upcoming_dates();?>
          </div>
        </div>
      </div>
    </div>
      
    <div class="col-md-4 col-sm-12 col-xs-12">
      <?php echo eric_widget_awards();?>
    </div>
  </div>
</div>
</section><!-- .home-section -->
