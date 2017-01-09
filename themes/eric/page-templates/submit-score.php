<?php
/**
 * The template for submitting evaluation scores
 * Template Name: Submit Evalution
 */

// prevent direct access
//$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
//strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
//
//if(!$isAjax) {
//  $user_error = 'Access denied - not an AJAX request...';
//  trigger_error($user_error, E_USER_ERROR);
//}


if(is_user_logged_in()) {
  global $wpdb;
  $wpdb->show_errors();

  $errors = new WP_Error();
  $ipaddress = $_SERVER['REMOTE_ADDR'];
  $time_local = current_time( 'mysql', $gmt = 0 );
  $time_gmt = current_time( 'mysql', $gmt = 1 );

  $judge_id = get_current_user_id();

  $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
  $secret = filter_input(INPUT_POST, 'secret', FILTER_SANITIZE_STRING);
  $submission_id = $wpdb->get_var("SELECT ID FROM $wpdb->submissions WHERE secret_key='$secret'");

  if($action=='submit') {
    $dataUpdate = array( 
        'submit_status' => 'submit',
        'submit_datetime' => $time_gmt,
        'ip_address' => addslashes($ipaddress)
    );
    $data_format = array( '%s', '%s', '%s');
    $where = array('submission_id' => $submission_id, 'judge_id' => $judge_id, 'submit_status' => 'draft');
    if($wpdb->update($wpdb->evaluation, $dataUpdate, $where, $data_format)) {
      $result['success'] = 1;
      $result['message'] = "Thank You.";
    } else {
      $result['success'] = 0;
      $result['message'] = "Error Ouccred!";
    }
    
    header( 'content-type: application/json; charset=utf-8' );
    echo json_encode( $result );
    exit();
    
  } else {
    $dataUpdate = array( 
        'submit_status' => 'update',
        'submit_datetime' => $time_gmt,
        'ip_address' => addslashes($ipaddress)
    );
    $data_format = array( '%s', '%s', '%s');
    $where = array('submission_id' => $submission_id, 'judge_id' => $judge_id, 'submit_status' => 'draft');
    $wpdb->update($wpdb->evaluation, $dataUpdate, $where, $data_format);


    $dataInsert = array (
        'submission_id' => $submission_id,
        'judge_id' => $judge_id,
        'score_scalability' => (int)filter_input(INPUT_POST, 'score_scalability', FILTER_SANITIZE_STRING),
        'score_human_centric' => (int)filter_input(INPUT_POST, 'score_human_centric', FILTER_SANITIZE_STRING),
        'score_differentiated' => (int)filter_input(INPUT_POST, 'score_differentiated', FILTER_SANITIZE_STRING),
        'score_acceleration' => (int)filter_input(INPUT_POST, 'score_acceleration', FILTER_SANITIZE_STRING),
        'score_team' => (int)filter_input(INPUT_POST, 'score_team', FILTER_SANITIZE_STRING),
        'score' => (int)filter_input(INPUT_POST, 'total_score', FILTER_SANITIZE_STRING),
        'benefit_membership' => filter_input(INPUT_POST, 'benefit_membership', FILTER_SANITIZE_STRING),
        'comments' => addslashes(filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_STRING)),
        'submit_status' => 'draft', //filter_input(INPUT_POST, 'submit_type', FILTER_SANITIZE_STRING),
        'submit_datetime' => $time_gmt,
        'ip_address' => addslashes($ipaddress)
    );

    if($wpdb->insert( $wpdb->evaluation, $dataInsert)){
      $result['success'] = 1;
    } else {
      $result['success'] = 0;
    }

    header( 'content-type: application/json; charset=utf-8' );
    echo json_encode( $result );
    exit();
  }
} else {
  wp_redirect(SITE_URL);
}
