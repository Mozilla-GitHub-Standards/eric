<?php
/**
 * The template for performing AJAX requests
 * Template Name: AJAX DATA
 */
global $wpdb, $THEME;
$wpdb->show_errors();

$errors = new WP_Error();
$ipaddress = $_SERVER['REMOTE_ADDR'];
$time_local = current_time( 'mysql', $gmt = 0 );
$time_gmt = current_time( 'mysql', $gmt = 1 );

$action = get_query_var('action');

switch($action) {
	case 'submission':
      $mail_to = 'kapilj@futurescape.co';
      $subject = "[Equal Rating Innovation Challenge] Solution Submission";
      $message = '<p>Dear Team,</p>';
      $message .= '<p>Someone submitted solution to the Equal Rating Innovation Challenge. Please check the details in Google Sheet.</p>';
      $headers  = array('Content-Type: text/html; charset=UTF-8');
      add_filter( 'wp_mail_content_type', 'set_html_content_type' );
      $mailSent = wp_mail($mail_to, $subject, $message, $headers);
      remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
      
      
      //Sending email to team leader
      $mail_to_leader = $_POST['leader_email'];
      $subject_leader = "Equal Rating Innovation Challenge";
      $message_leader = '<p>Hello!</p>';
      $message_leader .= '<p>Thank you for submitting your solution to the Equal Rating Innovation Challenge. If you have any questions, please contact us at <a href="mailto:equalrating@mozilla.com">equalrating@mozilla.com</a></p>';
      $message_leader .= '<p>Regards,<br />Equal Rating Innovation Challenge Team</p>';
      $headers_leader  = array('Content-Type: text/html; charset=UTF-8');
      add_filter( 'wp_mail_content_type', 'set_html_content_type' );
      $mailSent_leader = wp_mail($mail_to_leader, $subject_leader, $message_leader, $headers_leader);
      remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

      $result['success'] = 1;

      header( 'content-type: application/json; charset=utf-8' );
      echo json_encode( $result );
      die();
      break;
}

function set_html_content_type() {
  return 'text/html';
}
