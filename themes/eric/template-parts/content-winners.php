<?php
/**
 * The template used for displaying mentorship page content
 */

$semifinalists = get_field('semifinalists', SEMIFINALIST_PAGE_ID);

$winner = '';
$runnerup = '';
$mostnovel = '';
$finalists = array();
if($semifinalists) {
  foreach($semifinalists as $item) {
    if($item['rank']==='winner') {
      $winner = $item;
    } elseif($item['rank']==='runnerup') {
      $runnerup = $item;
    } elseif($item['rank']==='mostnovel') {
      $mostnovel = $item;
    } else {
      $finalists[] = $item;
    }
  }
}

// winner
$return .= '<div class="overall-winner winner-item">';
  $return .= '<div class="item-content">';
    $return .= '<img src="'.THEME_PATH.'/images/overall-winner-text.png" alt="Overall Winner!" class="img-fluid hidden-xs-down img-overall-winner">';
    $return .= '<img src="'.THEME_PATH.'/images/mobile-overall-winner-text.png" alt="Overall Winner!" class="img-fluid hidden-sm-up img-overall-winner">';
    $return .= '<h4>'.$winner['name'].'</h4>';
    if($winner['presenter'] && strlen($winner['presenter']) > 10) {
      $return .= '<div class="title">Presenter: '.$winner['presenter'].'</div>';
    }
    $return .= '<div class="title">Team Leader: '.$winner['team_leader'].'</div>';
    $return .= '<div class="title">Location: '.$winner['location'].'</div>';
    $return .= '<div class="description">'.apply_filters('the_content', $winner['description']).'</div>';
    $return .= '<p><a href="'.$winner['demo_day_video'].'">View demo day video</a><br />';
    $return .= '<a href="'.$winner['documentary_url'].'">View project mini-documentary</a></p>';

    $quotes = $winner["judge_quotes"];
    if($quotes) {
      foreach($quotes as $quote) {
        $return .= '<div class="judge-quote">';
          $return .= '<div class="quote-text">'.apply_filters('the_content', $quote['text']).'</div>';
          $return .= '<div class="quote-by">'.$quote['name_and_title'].'</div>';
        $return .= '</div>';
      }
    }
  $return .= '</div>';
$return .= '</div>';

//runnerup
$return .= '<div class="runner-up winner-item">';
  $return .= '<img src="'.$runnerup['image'].'" alt="'.$runnerup['name'].'" class="img-fluid hidden-xs-down">';
  $return .= '<img src="'.$runnerup['image_mobile'].'" alt="'.$runnerup['name'].'" class="img-fluid hidden-sm-up">';
  $return .= '<div class="item-content">';
    $return .= '<img src="'.THEME_PATH.'/images/runner-up-text.png" alt="Runner Up" class="img-fluid img-runner-up" />';
    $return .= '<h4>'.$runnerup['name'].'</h4>';
    if($runnerup['presenter'] && strlen($runnerup['presenter']) > 10) {
      $return .= '<div class="title">Presenter: '.$runnerup['presenter'].'</div>';
    }
    $return .= '<div class="title">Team Leader: '.$runnerup['team_leader'].'</div>';
    $return .= '<div class="title">Location: '.$runnerup['location'].'</div>';
    $return .= '<div class="description">'.apply_filters('the_content', $runnerup['description']).'</div>';
    $return .= '<p><a href="'.$runnerup['demo_day_video'].'">View demo day video</a><br />';
    $return .= '<a href="'.$runnerup['documentary_url'].'">View project mini-documentary</a></p>';
  $return .= '</div>';
$return .= '</div>';

//most novel
$return .= '<div class="most-novel winner-item">';
  $return .= '<img src="'.$mostnovel['image'].'" alt="'.$mostnovel['name'].'" class="img-fluid hidden-xs-down">';
  $return .= '<img src="'.$mostnovel['image_mobile'].'" alt="'.$mostnovel['name'].'" class="img-fluid hidden-sm-up">';
  $return .= '<div class="item-content">';
    $return .= '<img src="'.THEME_PATH.'/images/most-novel-text.png" alt="Most Novel" class="img-fluid img-most-novel" />';
    $return .= '<h4>'.$mostnovel['name'].'</h4>';
    if($mostnovel['presenter'] && strlen($mostnovel['presenter']) > 10) {
      $return .= '<div class="title">Presenter: '.$mostnovel['presenter'].'</div>';
    }
    $return .= '<div class="title">Team Leader: '.$mostnovel['team_leader'].'</div>';
    $return .= '<div class="title">Location: '.$mostnovel['location'].'</div>';
    $return .= '<div class="description">'.apply_filters('the_content', $mostnovel['description']).'</div>';
    $return .= '<p><a href="'.$mostnovel['demo_day_video'].'">View demo day video</a><br />';
    $return .= '<a href="'.$mostnovel['documentary_url'].'">View project mini-documentary</a></p>';
  $return .= '</div>';
$return .= '</div>';

//finalists
if($finalists) {
  $return .= '<div class="row clearfix">';
  foreach($finalists as $finalist) {
    $return .= '<div class="col-md-6 col-sm-12">';
      $return .= '<div class="winner-finalist">';
        $return .= '<img src="'.$finalist['image'].'" alt="'.$finalist['name'].'" class="img-fluid">';

        $return .= '<h4>Finalist</h4>';
        $return .= '<div class="finalist-name">'.$finalist['name'].'</div>';
        if($finalist['presenter'] && strlen($finalist['presenter']) > 10) {
          $return .= '<div class="title">Presenter: '.$finalist['presenter'].'</div>';
        }
        $return .= '<div class="title">Team Leader: '.$finalist['team_leader'].'</div>';
        $return .= '<div class="title">Location: '.$finalist['location'].'</div>';
        $return .= '<div class="description">'.apply_filters('the_content', $finalist['description']).'</div>';
        $return .= '<p><a href="'.$finalist['demo_day_video'].'">View demo day video</a><br />';
        $return .= '<a href="'.$finalist['documentary_url'].'">View project mini-documentary</a></p>';
      $return .= '</div>';
    $return .= '</div>';
  }
  $return .= '</div>';
}

?>

<div class="banner-winner">
  <?php 
    echo '<img src="'.$winner['image'].'" alt="'.$winner['name'].'" class="img-fluid hidden-xs-down">';
    echo '<img src="'.$winner['image_mobile'].'" alt="'.$winner['name'].'" class="img-fluid hidden-sm-up">';
  ?>
</div>

<section class="page-section">
  <div class="container">
    <h2 class="page-heading"><?php echo get_custom_post_title();?></h2>
    <?php echo $return; ?>
  </div>
</section>
