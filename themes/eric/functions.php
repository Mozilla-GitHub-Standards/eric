<?php
/**
 * Theme functions and definitions
 */

/**
 * Constant variables
 */
define( 'THEME_PATH', get_template_directory_uri() );
define( 'THEME_DIR', TEMPLATEPATH );
define( 'STYLESHEET_DIR', get_stylesheet_directory() );
define( 'SITE_URL', get_option('siteurl') );
define( 'SITE_NAME', esc_attr( get_bloginfo( 'name', 'display' ) ) );

// Website Specific
define( 'MISSION_PAGE_URL', SITE_URL.'/our-goal/' );
define( 'OVERVIEW_PAGE_URL', SITE_URL.'/overview/' );
define( 'FACTS_PAGE_URL', SITE_URL.'/key-facts/' );
define( 'SOLUTIONS_PAGE_URL', SITE_URL.'/current-solutions/' );
define( 'SUBMISSION_PAGE_URL', SITE_URL.'/your-submission/' );
define( 'SUBMISSION_FROM_URL', SITE_URL.'/submission-form/' );
define( 'SCHEDULE_PAGE_URL', SUBMISSION_PAGE_URL.'#schedule' );
define( 'FAQS_PAGE_URL', SUBMISSION_PAGE_URL.'faqs/' );
define( 'RULES_PAGE_URL', SITE_URL.'/challenge-rules/' );
define( 'AJAX_PAGE_URL', SITE_URL.'/ajax' );

define( 'EVALUATION_PAGE_URL', SITE_URL.'/evaluation' );
define( 'EVALUATION_SUBMIT_PAGE_URL', SITE_URL.'/evaluation/submit' );
define( 'SUBMISSIONS_PAGE_URL', SITE_URL.'/submissions' );
define( 'SUBMISSION_VIEW_PAGE_URL', SITE_URL.'/submissions/view' );


remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


if(!isset($wpdb->subscribers)) {
  $wpdb->subscribers = $wpdb->prefix . 'subscribers';
}

if(!isset($wpdb->submissions)) {
  $wpdb->submissions = $wpdb->prefix . 'submissions';
}
if(!isset($wpdb->submission_members)) {
  $wpdb->submission_members = $wpdb->prefix . 'submission_members';
}
if(!isset($wpdb->evaluation)) {
  $wpdb->evaluation = $wpdb->prefix . 'evaluation';
}

/*
 * Create theme options for managing different type of content blocks
 */
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Equal Rating Innovation Challenge - Options',
		'menu_title'	=> 'ERIC Options',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Analyses & Perspectives',
		'menu_title'	=> 'Analyses & Perspectives',
		'parent_slug'	=> 'theme-general-settings',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Awards Widget',
		'menu_title'	=> 'Awards Widget',
		'parent_slug'	=> 'theme-general-settings',
	));
  
  acf_add_options_sub_page(array(
		'page_title' 	=> 'Barriers Map',
		'menu_title'	=> 'Barriers Map',
		'parent_slug'	=> 'theme-general-settings',
	));
  
  acf_add_options_sub_page(array(
		'page_title' 	=> 'Frameworks',
		'menu_title'	=> 'Frameworks',
		'parent_slug'	=> 'theme-general-settings',
	));
  acf_add_options_sub_page(array(
		'page_title' 	=> 'Framework Diagram',
		'menu_title'	=> 'Framework Diagram',
		'parent_slug'	=> 'theme-general-settings',
	));
  
  acf_add_options_sub_page(array(
		'page_title' 	=> 'Schedule',
		'menu_title'	=> 'Schedule',
		'parent_slug'	=> 'theme-general-settings',
	));
  acf_add_options_sub_page(array(
		'page_title' 	=> 'Scoring Allocation',
		'menu_title'	=> 'Scoring Allocation',
		'parent_slug'	=> 'theme-general-settings',
	));
  acf_add_options_sub_page(array(
		'page_title' 	=> 'Submission Process',
		'menu_title'	=> 'Submission Process',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Upcoming Dates',
		'menu_title'	=> 'Upcoming Dates',
		'parent_slug'	=> 'theme-general-settings',
	));
}


if ( ! function_exists( 'twentysixteen_setup' ) ) :
function twentysixteen_setup() {
	load_theme_textdomain( 'twentysixteen', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 9999 );
  if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'method_thumbnail', 336, 156, true);
  }

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'twentysixteen' ),
		'footer'  => __( 'Footer Menu', 'twentysixteen' )
	) );
}
endif; // twentysixteen_setup 
add_action( 'after_setup_theme', 'twentysixteen_setup' );


function unregister_default_widgets() {
  unregister_widget('WP_Widget_Pages');
  unregister_widget('WP_Widget_Calendar');
  unregister_widget('WP_Widget_Links');
  unregister_widget('WP_Widget_Meta');
  unregister_widget('WP_Widget_Search');
  unregister_widget('WP_Widget_Text');
  unregister_widget('WP_Widget_RSS');
  unregister_widget('WP_Nav_Menu_Widget');
}
add_action('widgets_init', 'unregister_default_widgets', 11);


function eric_clean_content($content) {
  $domains = array(
      0 => get_bloginfo('url'),
//      1 => 'https://toolkit.production.paas.mozilla.community',
  );
  foreach($domains as $domain) {
    $content = str_replace(' src="'.$domain, ' src="', $content );
    $content = str_replace(' href="'.$domain, ' href="', $content );
    $content = str_replace(" src='".$domain, " src='", $content );
    $content = str_replace(" href='".$domain, " href='", $content );
  }
  
  //strip inline span and styles
  $content = strip_only_tags($content, array('span'));
  $content = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $content);
  
  return $content;
}
add_filter('content_save_pre','eric_clean_content','99');
add_filter( 'the_content', 'eric_clean_content' );


function strip_only_tags($str, $tags, $stripContent=false) {
  $content = '';
  if(!is_array($tags)) {
    $tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
    if(end($tags) == '') array_pop($tags);
  }
  foreach($tags as $tag) {
    if ($stripContent)
      $content = '(.+</'.$tag.'(>|\s[^>]*>)|)';
    $str = preg_replace('#</?'.$tag.'(>|\s[^>]*>)'.$content.'#is', '', $str);
  }
  return $str;
}



/**
 * Hide admin bar for logged in users except administrator
 */
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
//  if (!current_user_can('administrator') && !is_admin()) {
    show_admin_bar(false);
//  }
}


/**
 * Customization to login screen
 */
function twentysixteen_login_logo() {
	echo '<style type="text/css">
		h1 a { 
      background-image:url('.THEME_PATH.'/images/logo.png) !important;
      background-size: 200px 98px !important;
      width: 200px !important;
      height: 98px !important;
    }
	</style>';
}
add_action('login_head', 'twentysixteen_login_logo');

function twentysixteen_home_url() {
	return get_home_url();  // or return any other URL you want
}
add_filter('login_headerurl', 'twentysixteen_home_url');

function twentysixteen_login_title() {
	return get_option('blogname'); // or return any other title you want
}
add_filter('login_headertitle', 'twentysixteen_login_title');


/**
 * Adds favicon to the page
 */
function twentysixteen_favicon() {
  print "\n<!-- Adding FavIcon -->\n";
	print "<link rel='shortcut icon' href='https://equalrating.com/wp-content/uploads/2016/10/favicon.ico' />\n";
}
add_action('wp_head', 'twentysixteen_favicon');
add_action('admin_head', 'twentysixteen_favicon');


/**
 * Handles JavaScript detection.
 */
function twentysixteen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
//add_action( 'wp_head', 'twentysixteen_javascript_detection', 0 );

/**
 * Enqueues scripts and styles.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_scripts() {
	// Add custom fonts, used in the main stylesheet.
//	wp_enqueue_style( 'twentysixteen-fonts', twentysixteen_fonts_url(), array(), null );
  
  wp_enqueue_style('font-mozilla-fira', 'https://code.cdn.mozilla.net/fonts/fira.css', array(), false, 'screen,projection,print');
  wp_enqueue_style( 'font-merriweather', 'https://fonts.googleapis.com/css?family=Merriweather:400,400i,700,700i', false );
  wp_enqueue_style( 'font-lato', 'https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i', false );

	// Theme stylesheet.
	wp_enqueue_style( 'twentysixteen-style', get_stylesheet_uri() );
  wp_enqueue_style( 'twentysixteen-styles', THEME_PATH.'/stylesheets/styles.css' );

  // Loading javascripts and jquery plugins
  wp_enqueue_script('jquery-easing', THEME_PATH . '/js/jquery.easing.1.3.js', array('jquery'), '1.3');
  wp_enqueue_script('jquery-showLoading', THEME_PATH . '/js/jquery.showLoading.min.js', array('jquery'), '1.0', false);
  wp_enqueue_script('jqery-form', THEME_PATH .'/js/jquery.form.js', array('jquery'), '2.67', true);
  wp_enqueue_script('jquery-textcounter', THEME_PATH . '/js/textcounter.js', array('jquery'), '0.3.6', false);
  wp_enqueue_script('bootstrap-slider', THEME_PATH . '/js/bootstrap-slider.js', array('jquery'), 'v9.5.4');
  
  
  wp_enqueue_script( 'mozilla-newsletter', THEME_PATH . '/js/basket-client.js', array('jquery'), '2.0', true );
  wp_enqueue_script('jquery-countdown', THEME_PATH . '/js/jquery.countdown.min.js', array('jquery'), '2.1.0');
  
  wp_enqueue_script( 'imagesloaded', THEME_PATH.'/js/imagesloaded.pkgd.min.js', array( 'jquery' ), '3.1.8', false );
  wp_enqueue_script( 'masonry', THEME_PATH.'/js/masonry.pkgd.min.js', array( 'jquery' ), '3.3.2', false );
  
  // Loading bxslider jquery plugin
  wp_enqueue_script( 'jquery-bxslider', THEME_PATH . '/js/jquery.bxslider.min.js', array(), 'v4.1.2', false );
  wp_enqueue_style( 'bxslider', THEME_PATH .'/css/jquery.bxslider.css' );
  
  
  wp_enqueue_script('jquery.confirm', THEME_PATH . '/js/jquery-confirm.js', array('jquery'), 'v3.0.1');
	wp_enqueue_script( 'twentysixteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20151204', true );
}
add_action( 'wp_enqueue_scripts', 'twentysixteen_scripts' );


// Apply filter
//add_filter('body_class', 'eric_body_classes');

function eric_body_classes($classes) {
  global $post;
  $classes[] = ""; // add classes
  return $classes;
}


add_action( 'template_redirect', 'eric_redirect_post' );
function eric_redirect_post() {
  $redirect_post_types = array('casestudy', 'faq', 'statistic', 'image', 'attachment');
  $queried_post_type = get_query_var('post_type');
  if ( is_single() && in_array($queried_post_type, $redirect_post_types) ) {
    wp_redirect( SITE_URL.'/404/', 301 );
    exit;
  }
}


function get_custom_post_title() {
  global $post;
  $custom_post_title = get_field('custom_post_title', $post->ID);
  return (!($custom_post_title)) ? $post->post_title : $custom_post_title;
}

add_shortcode('indent', 'shortcodeIndentText');
function shortcodeIndentText($atts = null, $content = null) {
  extract(shortcode_atts(array(
      'size' => 'default',
  ), $atts));
  return '<p class="indent indent-'.$size.'">'.$content.'</p>';
}

add_shortcode('smalltext', 'shortcodeSmallText');
function shortcodeSmallText($atts = null, $content = null) {
  extract(shortcode_atts(array(
      'size' => 'default',
  ), $atts));
  return '<p class="smalltext">'.$content.'</p>';
}

function eric_statistics() {
  $return = '';
    
  $args=array(
      'post_type' => 'statistic',
      'post_status' => 'publish',
      'posts_per_page' => -1,
  );

  $results = query_posts($args);
  foreach($results as $result) {
    $return .= eric_display_statistic($result);
  }
  $return .= '<div class="clear"></div>';
  wp_reset_query();
  
  return $return;
}

function eric_display_statistic($result) {
  $o = get_post_meta($result->ID);
//  var_dump($o['category'][0]);
  $return = '<div class="col-sm-6 col-xs-12 masonry-item">';
    $return .= '<div class="statistic-item '.$o['category'][0].'">';
      $return .= '<h3><a href="'.$o['link_url'][0].'" target="_blank">'.$result->post_title.'</a></h3>';
      $return .= '<div class="location '.sanitize_title($o["location"][0]).'">'.$o["location"][0].'</div>';
      $return .= apply_filters('the_content', $result->post_content);
    $return .= '</div>';
    $return .= '</div>';
  
  return $return;
}



function eric_casestudies() {
  $return = '';
    
  $args=array(
      'post_type' => 'casestudy',
      'post_status' => 'publish',
      'posts_per_page' => -1,
  );

  $results = query_posts($args);
  
  foreach($results as $result) {
    
    $return .= '<div class="casestudy">'.eric_display_casestudy($result).'</div>';
  }
  wp_reset_query();
  
  return $return;
}

function eric_display_casestudy($result) {
  $o = get_post_meta($result->ID);
  $thumbnail = get_the_post_thumbnail( $result->ID, 'full', array( 'class' => 'img-fluid', 'alt' => $result->post_tilte ) );
  
  $return = '<div class="row">';
    $return .= '<div class="col-md-4 col-sm-5 col-xs-12">'.$thumbnail.'</div>';
    $return .= '<div class="col-md-8 col-sm-7 col-xs-12">';
      $return .= '<h3>'.$result->post_title.'</h3>';
      $return .= '<div class="location country-'.sanitize_title($o["country"][0]).'">'.$o["location"][0].'</div>';
      $return .= apply_filters('the_content', $result->post_content);
      if($o["link_url"][0]) {
        $return .= '<a href="'.$o["link_url"][0].'" target="'.$o["link_target"][0].'">'.$o["link_text"][0].'</a>';
      }
    $return .= '</div>';
  $return .= '</div>';
  return $return;
}



/* 
 * Functions related to faqs listing
 */
function eric_get_faqs() {
  $args=array(
      'post_type' => 'faq',
      'post_status' => 'publish',
      'posts_per_page' => -1,
  );
  $faqs = query_posts($args);
  wp_reset_query();
  return $faqs;
}

function eric_faqs_list($faqs=null) {
  if(is_null($faqs)) {
    $faqs = eric_get_faqs();
  }
  
  $return = '';
  if($faqs) {
    foreach($faqs as $faq) {
      $return .= '<div class="faq-item faq-item-'.$faq->ID.'">';
        $return .= '<h3 class="item-header">'.$faq->post_title.'</h3>';
        $return .= '<div class="item-content">';
          $return .= apply_filters('the_content', $faq->post_content);
        $return .= '</div>';
      $return .= '</div>';
    }
  }
  
  return $return;
}

function eric_faqs_dropdown($faqs=null) {
  if(is_null($faqs)) {
    $faqs = eric_get_faqs();
  }
  
  $return = '';
  if($faqs) {
    $return .= '<div class="faqs-dropdown">';
      $return .= '<h3 class="dropdown-header">Commonly Asked Questions</h3>';
      $return .= '<a href="#" class="dropdown-toggle"></a>';
      $return .= '<ul class="dropdown-list">';
      foreach($faqs as $faq) {
        $return .= '<li><a href="'.SITE_URL.'/faqs/#'.$faq->ID.'" data-id="'.$faq->ID.'">'.$faq->post_title.'</a></li>';
      }
    $return .= '</ul>';
    $return .= '</div>';
  }
  return $return;
}

add_filter('query_vars', 'eric_add_custom_var', 0, 1);
function eric_add_custom_var($vars){
  $vars[] = 'action';
  $vars[] = 'submission';
  return $vars;
}
add_rewrite_rule('^ajax/([^/]+)/?$','index.php?pagename=ajax&action=$matches[1]','top');
//add_rewrite_rule('^evaluate/([^/]+)/?$','index.php?pagename=evaluate&submission=$matches[1]','top');


function addhttp($url) {
  if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
    $url = "http://" . $url;
  }
  return $url;
}


function getSubscriptionForm($is_footer=true) {
  echo '<div class="newsletter-form">';
    echo '<div id="newsletter_wrapper">';
      echo '<h4>Join our mailing list to get the latest news.</h4>';
      echo '<form id="newsletter_form" name="newsletter_form" action="https://www.mozilla.org/en-US/newsletter/" method="post">';
        echo '<input type="hidden" id="fmt" name="fmt" value="H">';
        echo '<input type="hidden" id="newsletters" name="newsletters" value="open-innovation-challenge">';
        
        echo '<label for="email" class="screen-reader-text">Enter email address</label>';
        echo '<input type="email" value="" name="email" id="email" class="email form_input" placeholder="Enter your email address" required maxlength="60" />';
        echo '<input type="checkbox" id="privacy" name="privacy" required checked="checked" class="hidden-xs-up">';
        echo '<button id="newsletter_submit" name="newsletter_submit" type="submit" class="button btn-subscribe">Join</button>';
      echo '</form>';
      echo '<div class="clearfix"></div>';
      echo '<div id="newsletter_errors" class="newsletter_errors"></div>';
      echo '<div class="agree-terms">By clicking the JOIN button, you agree to Mozilla&rsquo;s <a href="https://www.mozilla.org/en-US/privacy/" target="_blank">Privacy Policy</a></div>';
    echo '</div>';
    echo '<div id="newsletter_thanks">Thanks for joining the Equal Rating Innovation Challenge newsletter. Please check your inbox or your spam filter for an email confirmation from us.</div>';
  echo '</div>';
}


function eric_widget_awards() {
  $list = get_field('awards_content', 'option');
  $return = '<div class="widget-awards">';
    $return .= '<h3 class="widget-title">Awards</h3>';
      $return .= '<ul>';
      if($list) {
        foreach($list as $item) {
          $return .= '<li><div class="heading">'.$item['title'].'</div>'.$item['content'].'</li>';
        }
      }
      $return .= '</ul>';
    $return .= '</div>';
  return $return;
}


function eric_widget_equalrating() {
  $return = '<div class="widget-equalrating-means">';
    $return .= '<h3 class="widget-title">Equal Rating</h3>';
    $return .= '<div class="widget-meta">e·qual rat·ing<br />/\'ēkwəl \' rādiNG/</div>';
    $return .= '<p><small>noun</small><br /><br />1.  A model where consumers choose content based on the quality of that content, not the financial power and business partnerships of the provider. &ldquo;Equal rating&rdquo; is in contrast to the term &ldquo;zero rating,&rdquo; which is fraught with limitations set into motion by a few powerful players dictating terms for users.</p>
      <p>2. A movement to defend the openness and vibrancy of the Web and to promote its social benefit for all! <strong>Join us!</strong></p>';
    $return .= '</div>';
  return $return;
}


function eric_widget_submission_process() {
  $return = '<div class="widget-submission-process">';
    $return .= '<h3 class="page-heading">The Submission Process</h3>';
    $return .= '<img src="'.THEME_PATH.'/images/graphic-submission_process.png" alt="The submission process" class="img-fluid" />';
    $return .= '<a href="'.SUBMISSION_PAGE_URL.'">Click to find out more</a>';
  $return .= '</div>';
  return $return;
}

function eric_widget_faqs() {
  $return = '<div class="widget-faqs">';
    $return .= '<a href="'.FAQS_PAGE_URL.'">Need more info?<br />Read our<br /><strong>FAQ</strong></a>';
  $return .= '</div>';
  return $return;
}

function eric_widget_submit_badge() {
  $return = '<div class="widget-submit-badge">';
    $return .= '<a href="'.SUBMISSION_FROM_URL.'"><img src="'.THEME_PATH.'/images/badge-submit.png" alt="Submit your proposal now!"></a>';
//    <strong>SUBMIT</strong><br />your proposal now!
  $return .= '</div>';
  return $return;
}


function eric_recent_posts() {
  $args = array( 'numberposts' => '5', 'post_status' => 'publish' );
  $recent_posts = wp_get_recent_posts( $args );
  if($recent_posts) {
    $return = '<aside class="widget-recent-posts">';
      $return .= '<h3 class="widget-title">Recent Posts</h3>';
      $return .= '<ul>';
      foreach( $recent_posts as $recent ){
        $return .= '<li>';
        $return .= '<h4><a href="'.get_permalink($recent['ID']).'">' . $recent["post_title"].'</a></h4>';
        $return .= '<div class="entry-meta">'.date('F d, Y', strtotime($recent['post_date'])).'</div>';
        $return .= '</li>';
      }
      $return .= '</ul>';
    $return .= '</div>';
    return $return;
  }
}


function eric_posts_pagination() {
  global $wp_query;
  $big = 999999999; // need an unlikely integer
  $paginate_links = paginate_links( array(
      'base'      => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
      'format'    => '?paged=%#%',
      'current'   => max( 1, get_query_var('paged') ),
      'total'     => $wp_query->max_num_pages,
      'prev_text' => __('&laquo; Previous'),
      'next_text' => __('Next &raquo;'),
      'type'      => 'array'
  ));
  if($paginate_links) {
    echo '<div class="pagination">';
    foreach ( $paginate_links as $pgl ) {
      echo '<span class="page-link">'.$pgl.'</span>';
    }
    echo '</div>';
  }
}


function eric_widget_upcoming_dates() {
  $list = get_field('upcoming_dates', 'option');
  $return = '<div id="upcoming_dates" class="widget-upcoming-dates">';
    $return .= '<h3 class="widget-title clearfix">Upcoming Dates</h3>';
      $return .= '<div class="clearfix"></div>';
      $return .= '<div class="widget-content">';
        $return .= '<ul>';
        if($list) {
          foreach($list as $item) {
            $return .= '<li>';
              $return .= '<div class="schedule-date">'.$item['date'].'</div>';
              $return .= '<div class="schedule-title">'.$item['event'].'</div>';
              $return .= '<div class="schedule-location">'.$item['location'].'</div>';
              $return .= '</li>';
          }
        }
        $return .= '</ul>';
        $return .= '<a href="'.SCHEDULE_PAGE_URL.'">See full schedule</a>';
      $return .= '</div>';
    $return .= '</div>';
  return $return;
}


function eric_full_schedule() {
  $list = get_field('full_schedule', 'option');
  $return = '<div id="schedule">';
    $return .= '<h2 class="page-heading">Schedule</h2>';
    if($list) {
      $return .= '<div class="schedule-row row-header">';
        $return .= '<div class="schedule-col col-date">Date</div>';
        $return .= '<div class="schedule-col col-event">Event</div>';
        $return .= '<div class="schedule-col col-location">Location</div>';
      $return .= '</div>';
      foreach($list as $item) {
        $return .= '<div class="schedule-row">';
          $return .= '<div class="schedule-col col-date">'.$item['date'].'</div>';
          $return .= '<div class="schedule-col col-event">'.$item['event'].'</div>';
          $return .= '<div class="schedule-col col-location">'.$item['location'].'</div>';
        $return .= '</div>';
      }
    }
    $return .= '</div>';
  return $return;
}


function eric_scoring_allocation() {
  $list = get_field('scoring_allocation', 'option');
  $return = '<div id="scoring-matrix" class="widget-scoring-allocation">';
    $return .= '<h3 class="widget-title">Scoring Allocation</h3>';
    $return .= '<div class="clearfix"></div>';
    
    $return .= '<div class="widget-content">';
      $return .= '<p>Submissions that meet the Criteria will be evaluated by the Judges. Judges will score submissions according to the degree with which the submission meets the following attributes:</p>';
      if($list) {
        $return .= '<ul>';
        foreach($list as $item) {
          $return .= '<li>';
            $return .= '<div class="points">'.$item['points'].' pts</div>';
            $return .= '<div class="topic">'.$item['text'].'</div>';
          $return .= '</li>';
        }
        $return .= '</ul>';
      }
    $return .= '</div>';
  $return .= '</div>';
  return $return;
}


function eric_banner_process() {
  $steps = get_field('submission_steps', 'option');
  $return .= '<div class="banner-submission">';
    $return .= '<div class="container">';
      $return .= '<h3>The Submission Process</h3>';
      if($steps) {
        $return .= '<div class="steps-wrapper">';
        $return .= '<ul>';
        foreach($steps as $step) {
          $return .= '<li>';
            $return .= '<div class="icon"><img src="'.$step['icon_image'].'" alt="'.$step['title'].'" /></div>';
            $return .= '<div class="step">'.$step['step'].'</div>';
            $return .= '<h4>'.$step['title'].'</h4>';
            $return .= '<p>'.$step['content'].'</p>';
          $return .= '</li>';
        }
        $return .= '</ul>';
        $return .= '</div>';
      }
    $return .= '</div>';
  $return .= '</div>';
  return $return;
}


function eric_barriers_map() {
  $barriers_map_title =  get_field('barriers_map_title', 'option');
  $barriers_map_text =  get_field('barriers_map_text', 'option');
  $barriers = get_field('barriers_map_content', 'option');
  
  $return = '<div id="barriers-map-wrapper">';
    $return .= '<h3>'.$barriers_map_title.'</h3>';
    $return .= '<p>'.$barriers_map_text.'</p>';

    $return .= '<div id="barriers-map">';
      $return .= '<div class="graphic-map"><img src="'.THEME_PATH.'/images/graphic-map.png" class="img-fluid hidden-lg-up"></div>';
      $return .= '<div class="graphic-line"></div>';
      $return .= '<ul>';
      foreach($barriers as $barrier) {
        $return .= '<li class="'.$barrier['class_name'].'">';
          $return .= '<h4>'.$barrier['title'].'</h4>';
          $return .= '<div>'.$barrier['text'].'</div>';
          $return .= '<div class="stats">'.$barrier['stats'].'</div>';
        $return .= '</li>';
      }
      $return .= '</ul>';
    $return .= '</div>';
  $return .= '</div>';
  return $return;
}

function eric_frameworks() {
  $title =  get_field('framework_title', 'option');
  $text =  get_field('framework_text', 'option');
  $frameworks = get_field('frameworks', 'option');
  
  $return = '<div id="frameworks" class="widget-frameworks">';
    $return .= '<div class="widget-header">';
      $return .= '<h3>'.$title.'</h3>';
      $return .= '<p>'.$text.'</p>';
    $return .= '</div>';
    
    $return .= '<div class="row">';
      foreach($frameworks as $framework) {
        $return .= '<div class="col-sm-4 col-xs-12">';
          $return .= '<div class="framework-item">';
            $return .= '<img src="'.$framework['logo'].'" alt="" class="item-logo" />';
            $return .= '<h4>'.$framework['title'].'</h4>';
            $return .= '<div class="item-link">'.$framework['link_text'].'</div>';
//            $return .= '<div class="item-link"><a href="'.$framework['link_url'].'" target="_blank">'.$framework['link_text'].'</a></div>';
            $return .= '<div class="item-content">'.apply_filters('the_content', $framework['content']).'</div>';
          $return .= '</div>';
        $return .= '</div>';
      }
    $return .= '</div>';
  $return .= '</div>';
  return $return;
}

function eric_analyses() {
  $results = get_field('analyses_and_perspectives', 'option');
  
  $return = '<div id="analyses-erspectives" class="widget-analyses">';
    $return .= '<h2>Analyses &amp; Perspectives</h2>';
    
    $return .= '<ul>';
      foreach($results as $result) {
        $return .= '<li>';
          $return .= '<h3><a href="'.$result['link_url'].'" target="_blank">'.$result['title'].'</a></h3>';
          $return .= '<div class="item-meta">'.apply_filters('the_content', $result['content']).'</div>';
        $return .= '</li>';
      }
    $return .= '</ul>';
  $return .= '</div>';
  return $return;
}

function custom_login_redirect() {
  global $pagenow;
  if ( !is_user_logged_in() && $pagenow != 'wp-login.php' ){
    wp_redirect( wp_login_url(site_url()), 302 );
    exit();
  }
}
add_action( 'wp', 'custom_login_redirect' );

add_action( 'admin_init', 'redirect_non_admin_users' );
/**
 * Redirect non-admin users to home page
 * This function is attached to the 'admin_init' action hook.
 */
function redirect_non_admin_users() {
	if ( ! current_user_can( 'edit_posts' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
		wp_redirect( SUBMISSIONS_PAGE_URL );
		exit;
	}
}

add_shortcode('submission_form_status', 'shortcodeSubmissionFormStatus');
function shortcodeSubmissionFormStatus($atts=null, $content) {
  extract(shortcode_atts(array(
      'staus' => 'pending',
  ), $atts));
  return '<div class="submission-form-status '.$atts['status'].'">'.$content.'</div>';
}


add_shortcode('submission_form', 'shortcodeSubmissionForm');
function shortcodeSubmissionForm($atts=null) {
  extract(shortcode_atts(array(
      'staus' => 'open',
  ), $atts));
  
  $return = '<div class="submission-form-wrapper">';
  $return .= '<form id="submissionForm" name="submissionForm" method="post" action="" class="ajax-form '.$atts['status'].'">';
  $return .= '<fieldset>';
    $return .= '<legend>Team</legend>';
    $return .= '<div class="row">';
      $return .= '<div class="col-md-6 col-sm-12">';
        $return .= '<div class="field-group">';
          $return .= '<label for="leader_name">Team Leader Name</label>';
          $return .= '<input type="text" id="leader_name" name="leader_name" class="field-input required" />';
        $return .= '</div>';
      $return .= '</div>';
      
      $return .= '<div class="col-md-6 col-sm-12">';
        $return .= '<div class="field-group">';
          $return .= '<label for="leader_email">Team Leader Email</label>';
          $return .= '<input type="text" id="leader_email" name="leader_email" class="field-input required email" />';
        $return .= '</div>';
      $return .= '</div>';
    $return .= '</div>';
    
    $return .= '<div class="row">';
      $return .= '<div class="col-md-6 col-sm-12">';
        $return .= '<div class="field-group">';
          $return .= '<label for="leader_location">Team Leader location (city/state)</label>';
          $return .= '<input type="text" id="leader_location" name="leader_location" class="field-input required" />';
        $return .= '</div>';
      $return .= '</div>';
      
      $return .= '<div class="col-md-6 col-sm-12">';
        $return .= '<div class="field-group">';
          $return .= '<label for="leader_country">Team Leader country</label>';
          $return .= '<input type="text" id="leader_country" name="leader_country" class="field-input required" />';
        $return .= '</div>';
      $return .= '</div>';
    $return .= '</div>';
    
    $return .= '<div class="row">';
      $return .= '<div class="col-md-6 col-sm-12">';
        $return .= '<div class="field-group">';
          $return .= '<label for="leader_phone">Team Leader phone number</label>';
          $return .= '<input type="text" id="leader_phone" name="leader_phone" class="field-input required" />';
        $return .= '</div>';
      $return .= '</div>';
      
      $return .= '<div class="col-md-6 col-sm-12">';
        $return .= '<div class="field-group">';
          $return .= '<label for="leader_phone_type" class="hidden-sm-down">&nbsp;</label>';
          $return .= '<div class="form-group-radio clearfix">
            <label for="leader_phone_type_mobile">
              <input type="radio" name="leader_phone_type" id="leader_phone_type_mobile" value="Mobile Phone" checked="checked" /><i></i> <span>This is a mobile phone.</span>
            </label>
            <label for="leader_phone_type_landline">
              <input type="radio" name="leader_phone_type" id="leader_phone_type_landline" value="Land Line" /><i></i> <span>This is a land line.</span>
            </label>
            <div class="clear"></div>
          </div>';
        $return .= '</div>';
      $return .= '</div>';
    $return .= '</div>';
    
    $return .= '<div class="row">';
      $return .= '<div class="col-md-6 col-sm-12">';
        $return .= '<div class="field-group">';
          $return .= '<label for="leader_url">Team Leader url (ex: LinkedIn, GitHub, personal website)</label>';
          $return .= '<input type="text" id="leader_url" name="leader_url" class="field-input required" />';
        $return .= '</div>';
      $return .= '</div>';
    $return .= '</div>';
    
    $return .= '<div class="field-group">';
      $return .= '<label for="leader_bio">Team Leader bio (80 words max)</label>';
      $return .= '<textarea rows="5" id="leader_bio" name="leader_bio" class="field-input required"></textarea>';
    $return .= '</div>';
    
    
    for($i=1; $i<=5; $i++) {
      $required = ($i===1) ? ' required': '';
      $return .= '<div class="member-info member-'.$i . (($i>1) ? ' hidden-xs-up': '').'">';
        $return .= '<div class="row">';
          $return .= '<div class="col-md-6 col-sm-12">';
            $return .= '<div class="field-group">';
              $return .= '<label for="member_name_'.$i.'">Team Member Name</label>';
              $return .= '<input type="text" id="member_name_'.$i.'" name="member_name_'.$i.'" class="field-input'.$required.'" />';
            $return .= '</div>';
          $return .= '</div>';

          $return .= '<div class="col-md-6 col-sm-12">';
            $return .= '<div class="field-group">';
              $return .= '<label for="member_email_'.$i.'">Team Member Email</label>';
              $return .= '<input type="text" id="member_email_'.$i.'" name="member_email_'.$i.'" class="field-input'.$required.' email" />';
            $return .= '</div>';
          $return .= '</div>';
        $return .= '</div>';

        $return .= '<div class="row">';
          $return .= '<div class="col-md-6 col-sm-12">';
            $return .= '<div class="field-group">';
              $return .= '<label for="member_location_'.$i.'">Team Member location (city/state)</label>';
              $return .= '<input type="text" id="member_location_'.$i.'" name="member_location_'.$i.'" class="field-input'.$required.'" />';
            $return .= '</div>';
          $return .= '</div>';

          $return .= '<div class="col-md-6 col-sm-12">';
            $return .= '<div class="field-group">';
              $return .= '<label for="member_country_'.$i.'">Team Member country</label>';
              $return .= '<input type="text" id="member_country_'.$i.'" name="member_country_'.$i.'" class="field-input'.$required.'" />';
            $return .= '</div>';
          $return .= '</div>';
        $return .= '</div>';

        $return .= '<div class="row">';
          $return .= '<div class="col-md-6 col-sm-12">';
            $return .= '<div class="field-group">';
              $return .= '<label for="member_phone_'.$i.'">Team Member phone number</label>';
              $return .= '<input type="text" id="member_phone_'.$i.'" name="member_phone_'.$i.'" class="field-input'.$required.'" />';
            $return .= '</div>';
          $return .= '</div>';

          $return .= '<div class="col-md-6 col-sm-12">';
            $return .= '<div class="field-group">';
              $return .= '<label class="hidden-sm-down">&nbsp;</label>';
              $return .= '<div class="form-group-radio clearfix">
                <label for="member_phone_type_mobile_'.$i.'">
                  <input type="radio" name="member_phone_type_'.$i.'" id="member_phone_type_mobile_'.$i.'" value="Mobile Phone" checked="checked" /><i></i> <span>This is a mobile phone.</span>
                </label>
                <label for="member_phone_type_landline_'.$i.'">
                  <input type="radio" name="member_phone_type_'.$i.'" id="member_phone_type_landline_'.$i.'" value="Land Line" /><i></i> <span>This is a land line.</span>
                </label>
                <div class="clear"></div>
              </div>';
            $return .= '</div>';
          $return .= '</div>';
        $return .= '</div>';

        $return .= '<div class="row">';
          $return .= '<div class="col-md-6 col-sm-12">';
            $return .= '<div class="field-group">';
              $return .= '<label for="member_url_'.$i.'">Team Member url (ex: LinkedIn, GitHub, personal website)</label>';
              $return .= '<input type="text" id="member_url_'.$i.'" name="member_url_'.$i.'" class="field-input'.$required.'" />';
            $return .= '</div>';
          $return .= '</div>';
        $return .= '</div>';

        $return .= '<div class="field-group">';
          $return .= '<label for="member_bio_'.$i.'">Team Member bio (80 words max)</label>';
          $return .= '<textarea rows="5" id="member_bio_'.$i.'" name="member_bio_'.$i.'" class="field-input'.$required.'"></textarea>';
        $return .= '</div>';
      $return .= '</div><!-- member-info -->';
    }
    
    $return .= '<button class="add-member '.$atts['status'].'">+ ADDITIONAL TEAM MEMBERS</button>';
    
    $return .= '<div class="field-group">';
      $return .= '<label for="team_affiliated">Is your team affiliated with another organization? (company, NGO, university, startup, community/hub, government, etc).</label>';
      $return .= '<textarea rows="3" id="team_affiliated" name="team_affiliated" class="field-input required"></textarea>';
    $return .= '</div>';
  $return .= '</fieldset>';
  
  
  $return .= '<fieldset>';
    $return .= '<legend>Solution</legend>';
    
    $return .= '<div class="field-group">';
      $return .= '<label for="solution_name"><strong>SOLUTION NAME:</strong> (40 characters max)</label>';
      $return .= '<input type="text" id="solution_name" name="solution_name" class="field-input required" />';
    $return .= '</div>';
    
    $return .= '<div class="field-group">';
      $return .= '<label for="solution_description"><strong>DESCRIPTION:</strong> Describe the value and intended outcomes of the proposed solution (50 words max)</label>';
      $return .= '<textarea rows="3" id="solution_description" name="solution_description" class="field-input required"></textarea>';
    $return .= '</div>';
    
    $return .= '<div class="field-group">';
      $return .= '<label for="solution_audience"><strong>
TARGET AUDIENCE:</strong> Please include details like gender, age/lifestage, socio-economic, region/geography, etc (50 words max)</label>';
      $return .= '<textarea rows="3" id="solution_audience" name="solution_audience" class="field-input required"></textarea>';
    $return .= '</div>';
    
    $return .= '<div class="field-group">';
      $return .= '<label for="solution_maturity"><strong>MATURITY:</strong> Degree of solution maturity:</label>';
      $return .= '<div class="form-group-radio vertical clearfix">
        <label for="solution_maturity_concept">
          <input type="radio" name="solution_maturity" id="solution_maturity_concept" value="concept" checked="checked" /><i></i> <span>concept</span>
        </label>
        <label for="solution_maturity_prototype">
          <input type="radio" name="solution_maturity" id="solution_maturity_prototype" value="concept" /><i></i> <span>prototype</span>
        </label>
        <label for="solution_maturity_new">
          <input type="radio" name="solution_maturity" id="solution_maturity_new" value="new to market" /><i></i> <span>new to market</span>
        </label>
        <label for="solution_maturity_in_market">
          <input type="radio" name="solution_maturity" id="solution_maturity_in_market" value="in market +1 years" /><i></i> <span>in market +1 years</span>
        </label>
        
        <div class="clear"></div>
      </div>';
    $return .= '</div>';
    
    $return .= '<div class="field-group">';
      $return .= '<label for="solution_equalrating"><strong>EQUAL RATING:</strong> How does your solution provide unconnected people affordable access to the full diversity of the open Internet? (100 words max)</label>';
      $return .= '<textarea rows="3" id="solution_equalrating" name="solution_equalrating" class="field-input required"></textarea>';
    $return .= '</div>';
    
    
    $return .= '<div class="field-group">';
      $return .= '<label for="solution_scalability"><strong>SCALABILITY:</strong> What is your plan to scale your solution? Please provide a clear plan and method for achieving scale. Be specific. (200 words max)</label>';
      $return .= '<textarea rows="3" id="solution_scalability" name="solution_scalability" class="field-input required"></textarea>';
    $return .= '</div>';
    
    $return .= '<div class="field-group">';
      $return .= '<label for="solution_experience"><strong>USER EXPERIENCE:</strong> In what ways will your solution provide a positive and enduring experience for its users? (100 words max)</label>';
      $return .= '<textarea rows="3" id="solution_experience" name="solution_experience" class="field-input required"></textarea>';
    $return .= '</div>';
    
    $return .= '<div class="field-group">';
      $return .= '<label for="solution_differntiation"><strong>DIFFERENTIATION:</strong> What benefits does your proposed solution bring compared to those currently available? (100 words max)</label>';
      $return .= '<textarea rows="3" id="solution_differntiation" name="solution_differntiation" class="field-input required"></textarea>';
    $return .= '</div>';
    
    $return .= '<div class="field-group">';
      $return .= '<label for="solution_time_market"><strong>TIME TO MARKET:</strong> When do you expect to bring your solution to market? If it is already in market, please describe your plan to broaden your audience. (100 words max)
</label>';
      $return .= '<textarea rows="3" id="solution_time_market" name="solution_time_market" class="field-input required"></textarea>';
    $return .= '</div>';
    
    $return .= '<div class="field-group">';
      $return .= '<label for="solution_feasibility"><strong>FEASIBILITY &amp; SUSTAINABILITY:</strong> What evidence illustrates that your solution will work from a technical and business perspective? (100 words max)</label>';
      $return .= '<textarea rows="3" id="solution_feasibility" name="solution_feasibility" class="field-input required"></textarea>';
    $return .= '</div>';
    
    $return .= '<div class="field-group">';
      $return .= '<label for="solution_roadmap"><strong>ROADMAP &amp; PRIZE MONEY:</strong> Please share your plan for how the prize money will be used for development of your proposed solution. (200 words max)</label>';
      $return .= '<textarea rows="3" id="solution_roadmap" name="solution_roadmap" class="field-input required"></textarea>';
    $return .= '</div>';
    
    $return .= '<div class="field-group">';
      $return .= '<label for="solution_whywin"><strong>TEAM:</strong> Why should your team win this challenge? Please note previous relevant projects and collaborations. (100 words max)</label>';
      $return .= '<textarea rows="3" id="solution_whywin" name="solution_whywin" class="field-input required"></textarea>';
    $return .= '</div>';
    
//    $return .= '<div class="field-group">';
//      $return .= '<label for="solution_risks"><strong>RISKS:</strong> What are the limitations or vulnerabilities of the proposed solution? (100 words max)</label>';
//      $return .= '<textarea rows="3" id="solution_risks" name="solution_risks" class="field-input required"></textarea>';
//    $return .= '</div>';
    
  $return .= '</fieldset>';
  
  
  
  $return .= '<fieldset>';
    $return .= '<legend>Open Source</legend>';
    
    $return .= '<div class="field-group">';
      $return .= '<label for="opensource_solution">Are you open sourcing your solution?</label>';
      $return .= '<div class="form-group-radio vertical clearfix">
        <label for="opensource_solution_yes">
          <input type="radio" name="opensource_solution" id="opensource_solution_yes" value="Yes" checked="checked" /><i></i> <span>Yes</span>
        </label>
        <label for="opensource_solution_no">
          <input type="radio" name="opensource_solution" id="opensource_solution_no" value="No" /><i></i> <span>No</span>
        </label>
        <div class="clear"></div>
      </div>';
    $return .= '</div>';
    
    $return .= '<div class="field-group">';
      $return .= '<label for="opensource_solution_info">If no, please review Mozilla&rsquo;s opinion in the <a href="'.FAQS_PAGE_URL.'" target="_blank">FAQ</a>, and describe your alternative path to accomplish similar goals and avoid known pitfalls. (200 words max)</label>';
      $return .= '<textarea rows="3" id="opensource_solution_info" name="opensource_solution_info" class="field-input"></textarea>';
    $return .= '</div>';
  $return .= '</fieldset>';
  
  $return .= '<fieldset>';
    $return .= '<legend>Visual Asset</legend>';
    $return .= '<div class="field-group">';
      $return .= '<label for="solution_asset">Optional visual asset to further elaborate your solution. PNG, JPG, or GIF file format only. Max size 2Mb (megabytes).</label>';
      $return .= '<div class="input-file-wrapper '.$atts['status'].'">+ Upload'.(($atts['status']==='open') ? '<input type="file" id="solution_asset_file" name="solution_asset_file" />' : '').'</div>';
      $return .= '<input type="hidden" value="" name="solution_assets" id="solution_assets" autocomplete="off" />';
      $return .= '<span id="solution-assets-filename" name="input-filename"></span>';
      $return .= '<div class="clearfix"></div>';
    $return .= '</div>';
  $return .= '</fieldset>';
  
  $return .= '<div class="field-group">';
    $return .= '<div class="form-group-checkbox vertical clearfix">
      <label for="agree_terms">
        <input type="checkbox" name="agree_terms" id="agree_terms" value="Yes" /><i></i> <span><strong>I HAVE READ AND AGREE TO THE <a href="'.RULES_PAGE_URL.'" target="_blank">CHALLENGE RULES</a>.</strong></span>
      </label>
      <div class="clear"></div>
    </div>';
  $return .= '</div>';
  
  if($atts['status']==='open') {
    $return .= '<div class="submission-form-message"></div>';
    $return .= '<div class="field-group">';
      $return .= '<input type="submit" id="submit-form" name="submit-form" value="Submit" class="field-submit" />';
    $return .= '</div>';
  }
  
  $return .= '</form>';
  $return .= '</div>';
  return $return;
}


add_shortcode('judges_list', 'shortcodeJudges');
function shortcodeJudges($atts=null) {
  extract(shortcode_atts(array(
      'staus' => 'open',
  ), $atts));
  
  global $post;
  $return = '';
  
  $judges = get_field('judges', $post->ID);
  if($judges) {
    $return .= '<div id="judges-list">';
    foreach($judges as $judge) {
      $return .= '<div class="judge">';
        $return .= '<img src="'.$judge['image'].'" alt="'.$judge['name'].'" class="img-fluid" />';
        $return .= '<h4>'.$judge['name'].'</h4>';
        $return .= '<div class="title">'.$judge['title'].'</div>';
        $return .= '<div class="url"><a href="'.$judge['url'].'" target="_blank">'.remove_http($judge['url']).'</a></div>';
        $return .= '<div class="about">'.apply_filters('the_content', $judge['about']).'</div>';
      
      $return .= '</div>';
    }
    $return .= '</div>';
  }
  return $return;
}

function remove_http($url) {
   $disallowed = array('http://', 'https://');
   foreach($disallowed as $d) {
      if(strpos($url, $d) === 0) {
         return str_replace($d, '', $url);
      }
   }
   return $url;
}


function eric_submissions() {
  global $wpdb;
  $judge_id = get_current_user_id();
  
  $return = '';
  $strqry = "SELECT s.secret_key, s.solution_name, s.solution_asset, sm.leader_name, sm.leader_country, e.score, e.submit_status "
          . "FROM $wpdb->submissions s "
          . "LEFT JOIN $wpdb->submission_members sm ON s.ID=sm.submission_id "
          . "LEFT JOIN $wpdb->evaluation e ON s.ID=e.submission_id AND e.judge_id='$judge_id' AND e.submit_status IN ('draft', 'submit') "
          . "WHERE 1=1 "
          . "ORDER BY s.solution_name ASC";
  
  $submissions = $wpdb->get_results($strqry);
  
  if($submissions) {
    $return .= '<div class="tbl-row tbl-row-head clearfix">';
      $return .= '<div class="tbl-col col-sn">No.</div>';
      $return .= '<div class="tbl-col col-project-name">Project Name</div>';
      $return .= '<div class="tbl-col col-team-leader">Team Leader</div>';
      $return .= '<div class="tbl-col col-country">Country</div>';
      $return .= '<div class="tbl-col col-image">Image</div>';
      $return .= '<div class="tbl-col col-evaluation">Evaluation</div>';
      $return .= '<div class="tbl-col col-score">Score</div>';
      $return .= '<div class="tbl-col col-status">Status</div>';
    $return .= '</div>';
    $counter=1;
    foreach($submissions as $submission) {
      $evaluation_link_url = EVALUATION_PAGE_URL.'/?secret='.$submission->secret_key;
      $return .= '<div class="tbl-row">';
        $return .= '<div class="tbl-col col-sn">'.$counter.'</div>';
        $return .= '<div class="tbl-col col-project-name"><a href="'.SUBMISSION_VIEW_PAGE_URL.'/?secret='.$submission->secret_key.'">'.$submission->solution_name.'</a></div>';
        $return .= '<div class="tbl-col col-team-leader">'.$submission->leader_name.'&nbsp;</div>';
        $return .= '<div class="tbl-col col-country">'.$submission->leader_country.'&nbsp;</div>';
        $return .= '<div class="tbl-col col-image">'.(($submission->solution_asset) ? '<a href="'.$submission->solution_asset.'" target="_blank">Yes</a>': 'No').'</div>';
        $return .= '<div class="tbl-col col-evaluation">';
          if($submission->submit_status === 'submit') {
            $return .= '<strong>Evaluation completed</strong>';
          } else {
            $return .= '<span class="evaluate-now"><a href="'.$evaluation_link_url.'"><strong>Evaluate now</strong></a></span>';
          }
        $return .= '</div>';
        
        $return .= '<div class="tbl-col col-score">';
          if($submission->submit_status === 'draft' OR $submission->submit_status === 'submit' ) {
            $return .= '<strong>'.(int)$submission->score.'</strong>';
          } else{
            $return .= '<a href="'.$evaluation_link_url.'">Not scored</a>';
          }
        $return .= '</div>';
        $return .= '<div class="tbl-col col-stauts">';
        
          if($submission->submit_status === 'draft') {
            $return .= '<span class="btn-submit-evaluation" data-secret="'.$submission->secret_key.'"><a href="javascript:void();"><strong>Submit now</strong></a></span>';
          } elseif ($submission->submit_status === 'submit' ) {
            $return .= '<strong>SUBMITTED</strong>';
          } else{
            $return .= '<a href="'.$evaluation_link_url.'">Not scored</a>';
          }
        $return .= '</div>';
        
        $return .= '<div class="clearfix"></div>';
      $return .= '</div>';
      $counter++;
    }
  }
  
  //<a href="'.EVALUATION_PAGE_URL.'/?secret='.$submission->secret_key.'">'.(($submission->submit_status=='submit') ? 'Evaluation Complete': 'Evaluate Now').'</a>
  echo $return;
}

function eric_submission_info($secret=null) {
  global $wpdb;
  $return = '';
  
  if(is_null($secret)) {
    return "Invalid Request!";
  }
  $submission = $wpdb->get_row("SELECT s.solution_name, s.solution_asset, s.secret_key, sm.leader_name, sm.leader_country  FROM $wpdb->submissions s LEFT JOIN $wpdb->submission_members sm ON s.ID=sm.submission_id WHERE secret_key='$secret'");
  if($submission) {
    $return .= '<div class="project-info clearfix">';
      $return .= '<div class="tbl-col col-solution-name">Project Name<br /><span>'.$submission->solution_name.'</span></div>';
      $return .= '<div class="tbl-col col-team-leader">Team Leader<br /><span>'.$submission->leader_name.'</span></div>';
      $return .= '<div class="tbl-col col-country">Country<br /><span>'.$submission->leader_country.'</span></div>';
      $return .= '<div class="tbl-col col-asset">Image<br /><span>'.(($submission->solution_asset) ? '<a href="'.$submission->solution_asset.'" target="_blank">Yes</a>': 'No').'</span></div>';
      $return .= '<div class="tbl-col col-asset">Submission<br /><span><a href="'.SUBMISSION_VIEW_PAGE_URL.'/?secret='.$submission->secret_key.'" target="_blank">Full Entry</a></span></div>';
    $return .= '</div>';
  }
  echo $return;
}

function eric_submission_view($secret=null) {
  global $wpdb;
  $return = '';
  
  if(is_null($secret)) {
    return "Invalid Request!";
  }
  $submission = $wpdb->get_row("SELECT s.*, sm.* FROM $wpdb->submissions s LEFT JOIN $wpdb->submission_members sm ON s.ID=sm.submission_id WHERE secret_key='$secret'", ARRAY_A);
  
  if($submission) {
    $return .= '<h2 class="page-heading">Submission: '.$submission['solution_name'].'</h2>';
    $return .= '<div class="solution-details clearfix">';
      $return .= '<h4 class="section-title"><strong>TEAM LEADER</strong></h4>';
      $return .= '<table>';
        $return .= '<tr><td width="40%" class="question">Team Leader Name</td><td width="60%">'.$submission['leader_name'].'</td></tr>';
        $return .= '<tr><td class="question">Team Leader Email</td><td>'.$submission['leader_email'].'</td></tr>';
        $return .= '<tr><td class="question">Team Leader location (city/state)</td><td>'.$submission['leader_location'].'</td></tr>';
        $return .= '<tr><td class="question">Team Leader country</td><td>'.$submission['leader_country'].'</td></tr>';
        $return .= '<tr><td class="question">Team Leader phone number</td><td>'.$submission['leader_phone'].' ('.$submission['leader_phone_type'].')</td></tr>';
        $return .= '<tr><td class="question">Team Leader url (ex: LinkedIn, GitHub, personal website)</td><td>'.$submission['leader_url'].'</td></tr>';
        $return .= '<tr><td class="question">Team Leader bio (80 words max)</td><td>'.$submission['leader_bio'].'</td></tr>';
      $return .= '</table>';
      
      for($i=1; $i<=5; $i++) {
        if(strlen($submission['member_name_'.$i]) > 1) {
          $return .= '<div class="hline"></div>';
          $return .= '<h4 class="section-title"><strong>TEAM MEMBER</strong></h4>';
          $return .= '<table>';
            $return .= '<tr><td width="40%" class="question">Team Leader Name</td><td width="60%">'.$submission['member_name_'.$i].'</td></tr>';
            $return .= '<tr><td class="question">Team Leader Email</td><td>'.$submission['member_email_'.$i].'</td></tr>';
            $return .= '<tr><td class="question">Team Leader location (city/state)</td><td>'.$submission['member_location_'.$i].'</td></tr>';
            $return .= '<tr><td class="question">Team Leader country</td><td>'.$submission['member_country_'.$i].'</td></tr>';
            $return .= '<tr><td class="question">Team Leader phone number</td><td>'.$submission['member_phone_'.$i].' ('.$submission['member_phone_type_'.$i].')</td></tr>';
            $return .= '<tr><td class="question">Team Leader url (ex: LinkedIn, GitHub, personal website)</td><td>'.$submission['member_url_'.$i].'</td></tr>';
            $return .= '<tr><td class="question">Team Leader bio (80 words max)</td><td>'.$submission['member_bio_'.$i].'</td></tr>';
          $return .= '</table>';
        }
      }
      
      $return .= '<div class="hline"></div>';
      $return .= '<h4 class="section-title"><strong>AFFILIATION</strong></h4>';
      $return .= $submission['team_affiliated'];
      
      $return .= '<div class="hline"></div>';
      $return .= '<h4 class="section-title"><strong>SOLUTION NAME:</strong> (40 characters max)</h4>';
      $return .= $submission['solution_name'];
      
      $return .= '<div class="hline"></div>';
      $return .= '<h4 class="section-title"><strong>DESCRIPTION:</strong> Describe the value and intended outcomes of the proposed solution (50 words max)</h4>';
      $return .= $submission['solution_description'];
      
      $return .= '<div class="hline"></div>';
      $return .= '<h4 class="section-title"><strong>TARGET AUDIENCE:</strong> Please include details like gender, age/lifestage, socio-economic, region/geography, etc (50 words max)</h4>';
      $return .= $submission['solution_audience'];
      
      $return .= '<div class="hline"></div>';
      $return .= '<h4 class="section-title"><strong>MATURITY:</strong> Degree of solution maturity:</h4>';
      $return .= $submission['solution_maturity'];
      
      $return .= '<div class="hline"></div>';
      $return .= '<h4 class="section-title"><strong>EQUAL RATING:</strong> How does your solution provide unconnected people affordable access to the full diversity of the open Internet? (100 words max)</h4>';
      $return .= $submission['solution_equalrating'];
      
      $return .= '<div class="hline"></div>';
      $return .= '<h4 class="section-title"><strong>SCALABILITY:</strong> What is your plan to scale your solution? Please provide a clear plan and method for achieving scale. Be specific. (200 words max)</h4>';
      $return .= $submission['solution_scalability'];
      
      $return .= '<div class="hline"></div>';
      $return .= '<h4 class="section-title"><strong>USER EXPERIENCE:</strong> In what ways will your solution provide a positive and enduring experience for its users? (100 words max)</h4>';
      $return .= $submission['solution_experience'];
      
      $return .= '<div class="hline"></div>';
      $return .= '<h4 class="section-title"><strong>DIFFERENTIATION:</strong> What benefits does your proposed solution bring compared to those currently available? (100 words max)</h4>';
      $return .= $submission['solution_differntiation'];
      
      $return .= '<div class="hline"></div>';
      $return .= '<h4 class="section-title"><strong>TIME TO MARKET:</strong> When do you expect to bring your solution to market? If it is already in market, please describe your plan to broaden your audience. (100 words max)</h4>';
      $return .= $submission['solution_time_market'];
      
      $return .= '<div class="hline"></div>';
      $return .= '<h4 class="section-title"><strong>FEASIBILITY & SUSTAINABILITY:</strong> What evidence illustrates that your solution will work from a technical and business perspective? (100 words max)</h4>';
      $return .= $submission['solution_feasibility'];
      
      $return .= '<div class="hline"></div>';
      $return .= '<h4 class="section-title"><strong>ROADMAP & PRIZE MONEY:</strong> Please share your plan for how the prize money will be used for development of your proposed solution. (200 words max)</h4>';
      $return .= $submission['solution_roadmap'];
      
      $return .= '<div class="hline"></div>';
      $return .= '<h4 class="section-title"><strong>TEAM:</strong> Why should your team win this challenge? Please note previous relevant projects and collaborations. (100 words max)</h4>';
      $return .= $submission['solution_whywin'];
      
      $return .= '<div class="hline"></div>';
      $return .= '<h4 class="section-title"><strong>OPEN SOURCE:</strong> Are you open sourcing your solution?</h4>';
      $return .= '<strong>'.$submission['opensource_solution'].'</strong>';
      if($submission['opensource_solution']=='No') {
        $return .= '<h4 class="section-title"><br />If no, please review Mozilla&rsquo;s opinion in the FAQ , and describe your alternative path to accomplish similar goals and avoid known pitfalls. (200 words max)</h4>';
        $return .= $submission['opensource_solution_info'];
      }
      
      
      $return .= '<div class="hline"></div>';
      $judge_id = get_current_user_id();
      $submission_id = $wpdb->get_var("SELECT ID FROM $wpdb->submissions WHERE secret_key='$secret'");
      $evaluation_status = $wpdb->get_var("SELECT submit_status FROM $wpdb->evaluation WHERE judge_id='$judge_id' AND submission_id='$submission_id' AND submit_status IN ('draft', 'submit')");
      $evaluation_link_url = EVALUATION_PAGE_URL.'/?secret='.$secret;
      if($evaluation_status == 'submit') {
        $return .= '<a href="'.$evaluation_link_url.'" class="link-button">Evaluation completed</a>';
      } else {
        $return .= '<a href="'.$evaluation_link_url.'" class="link-button">Evaluate now</a>';
      }
//      $return .= '<h4 class="section-title"><strong>VISUAL ASSET</strong></h4>';
//      $return .= (($submission['solution_asset']) ? '<a href="'.$submission['solution_asset'].'" target="_blank">Yes</a>': 'No');
    $return .= '</div>';
  }
  
  echo nl2br(make_clickable($return));
}

function eric_evaluation_form($secret=null) {
  global $wpdb;
  $judge_id = get_current_user_id();
  if(is_null($secret)) {
    return "Invalid Request!";
  }
  
  $submission_id = $wpdb->get_var("SELECT ID FROM $wpdb->submissions WHERE secret_key='$secret'");
  
  $evaluation = $wpdb->get_row("SELECT * FROM $wpdb->evaluation WHERE judge_id='$judge_id' AND submission_id='$submission_id' AND submit_status IN ('draft', 'submit')", ARRAY_A);
  
  if(!($evaluation)) {
    $evaluation = array(
        "score_scalability" => 0,
        "score_human_centric" => 0,
        "score_differentiated" => 0,
        "score_acceleration" => 0,
        "score_team" => 0,
        "total_socre" => 0,
        "benefit_membership" => "Agree",
        "comments" => "",
        "score" => 0,
        "submit_status" => "draft"
    );
  }
  
  $return = '';
  $return .= '<form id="evaluation_form" name="evaluation-form" action="'.EVALUATION_SUBMIT_PAGE_URL.'" method="post" class="ajax-form">';
    if($evaluation['submit_status']==='submit') {
      $return .= '<p class="evaluation-submitted">Evaluation complete for this solution.</p>';
    }
    
    $return .= '<div class="hline"></div>';
    $return .= '<h4>SCALABILITY [max 30 points]</h4>';
    $return .= '<div class="row">';
      $return .= '<div class="col-md-6 col-sm-12">';
        $return .= '<p class="question">How well does the proposed solution describe a clear path to effective and efficient scalability?</p>';
        $return .= '<div class="score-slider"><input type="text" id="score_scalability" name="score_scalability" data-slider-min="0" data-slider-max="30" data-slider-step="1" data-slider-value="'.$evaluation['score_scalability'].'" data-slider-label="score-scalability" class="input-score-slider" /></div>';
        $return .= '<div class="slider-label">Your score is <span id="score-scalability">'.$evaluation['score_scalability'].'</span></div>';
      $return .= '</div>';
      $return .= '<div class="col-md-6 col-sm-12"><div class="score-instructions"><p>This question has the greatest value, 30 points. Suggested ranges:</p><ul><li>30-26: Very strong concept; it’s clear how this team will scale the solution.</li><li>25-21: Concept has great merit but it needs to be evolved – I have confidence this team will be able to scale the solution.</li><li>20-11: Concept has merit and clear value, but it’s unclear how the team will scale it.</li><li>10-1: Viable concept but it’s already out there, it will create more complexity, or there will be real hurdles in achieving scale.</li><li>0: Not a scalable concept</li></ul></div></div>';
    $return .= '</div>';
    
    $return .= '<div class="hline"></div>';
    $return .= '<h4>HUMAN-CENTRIC [max 20 points]</h4>';
    $return .= '<div class="row">';
      $return .= '<div class="col-md-6 col-sm-12">';
        $return .= '<p class="question">Does the solution as described meet the needs of its target audience in a way that meaningfully considers their experience and context?</p>';
        $return .= '<div class="score-slider"><input type="text" id="score_human_centric" name="score_human_centric" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="'.$evaluation['score_human_centric'].'" data-slider-label="score-human_centric"  class="input-score-slider" /></div>';
        $return .= '<div class="slider-label">Your score is <span id="score-human_centric">'.$evaluation['score_human_centric'].'</span></div>';
      $return .= '</div>';
      $return .= '<div class="col-md-6 col-sm-12"><div class="score-instructions"><p>This question has a total value of 20 points. Suggested ranges:<p><ul><li>20-11: Very strong solution; it’s clear that this solution will resonate with its target audience.</li><li>10-6: Viable solution but doesn’t address or meet all the core needs of its target audience or it does not have a clear target audience.</li><li>0: Concept does not meet the needs of the target audience.</li></ul></div></div>';
    $return .= '</div>';
    
    $return .= '<div class="hline"></div>';
    $return .= '<h4>DIFFERENTIATED [max 20 points]</h4>';
    $return .= '<div class="row">';
      $return .= '<div class="col-md-6 col-sm-12">';
        $return .= '<p class="question">Does the solution make a unique contribution to the market from a user, business, or technical standpoint?</p>';
        $return .= '<div class="score-slider"><input type="text" id="score_differentiated" name="score_differentiated" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="'.$evaluation['score_differentiated'].'" data-slider-label="score-differentiated"  class="input-score-slider" /></div>';
        $return .= '<div class="slider-label">Your score is <span id="score-differentiated">'.$evaluation['score_differentiated'].'</span></div>';
      $return .= '</div>';
      $return .= '<div class="col-md-6 col-sm-12"><div class="score-instructions"><p>This question has a total value of 20 points. Suggested ranges:</p><ul><li>20-11: Very strong solution; it’s clear that this concept will make a significant contribution to this space.</li><li>10-1: Viable solution but similar ones already exist.</li><li>0: Concept is not differentiated.</li></ul></div></div>';
    $return .= '</div>';
    
    $return .= '<div class="hline"></div>';
    $return .= '<h4>ACCELERATION [max 10 points]</h4>';
    $return .= '<div class="row">';
      $return .= '<div class="col-md-6 col-sm-12">';
        $return .= '<p class="question">Can this solution be deployed to the market quickly? Will the challenge publicity, expert mentorship, and award money help the team move forward efficiently and effectively?</p>';
        $return .= '<div class="score-slider"><input type="text" id="score_acceleration" name="score_acceleration" data-slider-min="0" data-slider-max="10" data-slider-step="1" data-slider-value="'.$evaluation['score_acceleration'].'" data-slider-label="score-acceleration"  class="input-score-slider" /></div>';
        $return .= '<div class="slider-label">Your score is <span id="score-acceleration">'.$evaluation['score_acceleration'].'</span></div>';
      $return .= '</div>';
      $return .= '<div class="col-md-6 col-sm-12"><div class="score-instructions"><p>This question has a total value of 10 points. Suggested ranges:</p><ul><li>10-5: This solution is setup to be deployed rapidly, and the team will benefit from the prize money and support.</li><li>4-0: This solution is complex and has many dependencies.</li></ul></div></div>';
    $return .= '</div>';
    
    $return .= '<div class="hline"></div>';
    $return .= '<h4>TEAM [max 10 points]</h4>';
    $return .= '<div class="row">';
      $return .= '<div class="col-md-6 col-sm-12">';
        $return .= '<p class="question">Is this a team you feel confident in? Consider several factors: ability to clearly articulate the solution throughout the submission form answers; the pedigree of the team; previous successes of relevant solutions?</p>';
        $return .= '<div class="score-slider"><input type="text" id="score_team" name="score_team" data-slider-min="0" data-slider-max="10" data-slider-step="1" data-slider-value="'.$evaluation['score_team'].'" data-slider-label="score-team"  class="input-score-slider" /></div>';
        $return .= '<div class="slider-label">Your score is <span id="score-team">'.$evaluation['score_team'].'</span></div>';
      $return .= '</div>';
      $return .= '<div class="col-md-6 col-sm-12"><div class="score-instructions"><p>This question has a total value of 10 points. Suggested ranges:</p><ul><li>10-5: Team shows promise in manifesting this solution.</li><li>4-0: Unsure of team’s abilities.</li></ul></div></div>';
    $return .= '</div>';
    
    $return .= '<div class="hline"></div>';
    $return .= '<p class="question">This team will benefit from mentorship from Mozilla experts in areas like policy, business modeling, engineering, and design.<p>';
    $return .= '<div class="form-group-radio clearfix">
      <label for="benefit_membership_agree">
        <input type="radio" name="benefit_membership" id="benefit_membership_agree" value="Agree"'.(($evaluation['benefit_membership']=='Agree') ? ' checked="checked"': '').' /><i></i> <span>Agree</span>
      </label>
      <label for="benefit_membership_disagree">
        <input type="radio" name="benefit_membership" id="benefit_membership_disagree" value="Disagree"'.(($evaluation['benefit_membership']=='Disagree') ? ' checked="checked"': '').' /><i></i> <span>Disagree</span>
      </label>
      <div class="clear"></div>
    </div>';
  
    $return .= '<div class="hline"></div>';
    $return .= '<p class="question">Total score for this submission [max 90 points] : <strong class="total-score">'.$evaluation['score'].'</strong></p>';
    
    $return .= '<div class="hline"></div>';
    $return .= '<p class="question">Please share any comments on this submission [optional]</p>';
    $return .= '<textarea rows="5" name="comments" id="comments" class="form_input">'.$evaluation['comments'].'</textarea>';
    
    $return .= '<div class="hline"></div>';
    if($evaluation['submit_status']==='submit') {
      $return .= '<p class="evaluation-submitted">Evaluation complete for this solution.</p>';
    } else {
      $return .= '<input type="hidden" id="secret" name="secret" value="'.$secret.'">';
      $return .= '<input type="hidden" id="total_score" name="total_score" value="'.$evaluation['score'].'">';
      $return .= '<input type="hidden" id="submit_type" name="submit_type" value="draft">';
      $return .= '<button type="submit" name="btn_submit" class="btn-submit" value="draft">Done</button>';
    }
  $return .= '</form>';
  echo $return;
}


function eric_widget_mentorship() {
  $return = '<div class="widget-definition widget-definition-mentorship">';
    $return .= '<h3 class="widget-title">Mentorship</h3>';
    $return .= '<div class="widget-meta">men·tor·ship<br />/men-tawr,ship/</div>';
    $return .= '<p>1. A way to create outsized impact from limited interventions</p>
      <p>2. Transforming Equal Rating Innovation Challenge semifinalists with the power of the Mozilla community</p>';
    $return .= '</div>';
  return $return;
}

function eric_widget_mentor() {
  $return = '<div class="widget-definition widget-definition-mentor">';
    $return .= '<h3 class="widget-title">Mentor</h3>';
    $return .= '<div class="widget-meta">men·tor<br />/ˈmenˌtôr/</div>';
    $return .= '<p><small>noun</small><br /><br />1. a wise and trusted counselor or teacher</p>
      <p>2. an influential senior sponsor or supporter</p>';
    $return .= '</div>';
  return $return;
}

add_shortcode('semifinalists_list', 'shortcodeSemifinalists');
function shortcodeSemifinalists($atts=null) {
  extract(shortcode_atts(array(
      'staus' => 'open',
  ), $atts));
  
  global $post;
  $return = '';
  
  $semifinalists = get_field('semifinalists', $post->ID);
  if($semifinalists) {
    $return .= '<div id="semifinalists-list">';
    $return .= '<div class="row">';
    $counter = 0;
    foreach($semifinalists as $semifinalist) {
      if($counter === 2) {
        $return .= '<div class="col-md-4 col-sm-12">';
          $return .= '<img src="'.THEME_PATH.'/images/banner_demoday.jpg" alt=" Watch the semifinalists Demo Day Live" class="img-fluid banner-demoday hidden-sm-down" />';
        $return .= '</div>';
        $return .= '<div class="clearfix"></div>';
        $counter++;
      }
    
      $return .= '<div class="col-md-4 col-sm-12">';
        $return .= '<div class="semifinalist">';
          $return .= '<img src="'.$semifinalist['logo'].'" alt="'.$semifinalist['name'].'" class="img-fluid" />';
          $return .= '<h4>'.$semifinalist['name'].'</h4>';
          $return .= '<div class="title">'.$semifinalist['title'].'</div>';
          $return .= '<div class="url"><a href="'.$semifinalist['url'].'" target="_blank">'.remove_http($semifinalist['url']).'</a></div>';
          $return .= '<div class="description">'.apply_filters('the_content', $semifinalist['description']).'</div>';
        $return .= '</div>';
      $return .= '</div>';
      
      $counter++;
    }
    $return .= '<img src="'.THEME_PATH.'/images/banner_demoday.jpg" alt=" Watch the semifinalists Demo Day Live" class="img-fluid banner-demoday hidden-sm-up" />';
    $return .= '</div>';
    $return .= '</div>';
  }
  return $return;
}
