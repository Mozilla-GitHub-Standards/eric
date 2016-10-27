<?php
/**
 * The template used for displaying overview page content
 */
?>
<div class="banner-overview">
  <div class="container">
    <div class="banner-text"><?php echo apply_filters('the_content', get_field('overview_header_text', 'option'));?></div>
  </div>
</div>


<section class="page-section">
  <div class="container">
    <?php echo eric_barriers_map();?>
    <?php echo eric_frameworks();?>
      
      
    <div class="framework-diagram">
      <h3>About <span>4 Billion</span> non-users</h3>
      <div class="row">
        <div class="col-sm-6 col-xs-12">
          <div class="framework-item item-infrastructure">
            <h4>INFRASTRUCTURE</h4>
            <ul class="stats">
              <li><span>15%</span> of people around the globe have no electricity</li>
              <li><span>31%</span> of people live outside 3G coverage</li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-xs-12">
          <div class="framework-item item-affordability">
            <h4>AFFORDABILITY</h4>
            <ul class="stats">
              <li><span>13%</span> of people live below the international poverty line</li>
              <li><span>29</span> Number of countries where broadband is affordable for 100% of the population once household incomes are taken into account</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6 col-xs-12">
          <div class="framework-item item-skills">
            <h4>SKILLS, AWARENESS & CULTURAL ACCEPTANCE</h4>
            <ul class="stats">
              <li><span>15%</span> of adults are considered illiterate</li>
              <li class="no-absolute">Women are up to <span>50%</span> less likely to be connected</li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-xs-12">
          <div class="framework-item item-adoption">
            <h4>LOCAL ADOPTION &amp; USE</h4>
            <ul class="stats">
              <li><span>80%</span> of online content is only available in 1 of 10 languages, which only about three billion people speak as their first</li>
              <li><span>95%</span> of survey participants in 12 developed and developing countries have used online government services</li>
            </ul>
          </div>
        </div>
      </div>
      
      <p class="smalltext"><em>World Economic Forum, Internet for All: A Framework for Accelerating Internet Access and Adoption, 2016</em></p>
      
    </div>
  </div>
</section>

