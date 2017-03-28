<?php
/**
 * Template Name: Export Evaluations
 * Description: The template for export data to Excel or CSV format
 */
$valid = false;
if ( !is_user_logged_in() && $pagenow != 'wp-login.php' ){
  wp_redirect( wp_login_url(site_url()), 302 );
  exit;
} elseif (!current_user_can('administrator') && !is_admin()) {
  wp_redirect( SITE_URL.'/404/', 301 );
  exit;
} else {
  global $wpdb;
  $wpdb->show_errors();
  
  $exportType = 'csv';
  $strqry = "SELECT s.solution_name, u.display_name, e.* FROM $wpdb->submissions s "
          . "JOIN $wpdb->evaluation e ON s.ID=e.submission_id AND e.submit_status IN ('draft', 'submit') "
          . "LEFT JOIN $wpdb->users u ON u.ID=e.judge_id "
          . "WHERE 1=1 "
          . "ORDER BY s.solution_name ASC";
      
  $data = $wpdb->get_results($strqry, ARRAY_A);
  
  $headers = array(
      'submit_datetime' => 'Last Updated',
      'solution_name' => 'Project Name',
      'display_name' => 'Judge',
      'score_scalability' => 'SCALABILITY [max 30 points]',
      'score_human_centric' => 'HUMAN-CENTRIC [max 20 points]',
      'score_differentiated' => 'DIFFERENTIATED [max 20 points]',
      'score_acceleration' => 'ACCELERATION [max 10 points]',
      'score_team' => 'TEAM [max 10 points]',
      'benefit_membership' => 'Will Benefit from Mentorship',
      'score' => 'Total Score',
      'comments' => 'Comments on Submission',
      'submit_status' => 'Evlauation Status'
  );
  $exportData['records'] = $data;
  $exportData['headers'] = $headers;

  exportDataCSV($exportData, 'ERIC_JUDGES_EVALUATIONS');
}

//Export CSV File
function exportDataCSV($data, $file_name){
  $file_name .= '_'.time().'.csv';
  header("Content-Type: text/csv; charset=utf-8");
  header("Content-Disposition: attachment; filename=$file_name");
  $output = fopen('php://output', 'w');

//  // output the column headings
  fputcsv($output, $data['headers']);

  // fetch the data
  foreach($data['records'] as $r) {
    $row = array();
    foreach($data['headers'] as $key=>$val) {
      $row[] = $r[$key];
    }
    fputcsv($output, $row);
  }
}

//Export CSV File
function exportDataXLS($data, $file_name){
  $file_name .= '_'.time().'xls';
  header("Content-Type: application/vnd.ms-excel");
  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Content-Type: application/force-download");
  header("Content-Type: application/octet-stream");
  header("Content-Type: application/download");
  header("Content-Disposition: attachment;filename=$file_name");
  header("Content-Transfer-Encoding: binary ");

  $style = 'border: 1px solid #999; border-collapse: collapse;';
  echo '<table style="'.$style.'">';
  if($data['headers']){
    echo '<tr valign="top">';
      foreach($data['headers'] as $header){
        echo '<th style="'.$style.'">'.$header.'</th>';
      }
    echo '</tr>';
  }

  if($data['records']){
    foreach($data['records'] as $record) {
      echo '<tr style="vertical-align: top;">';
      foreach($record as $row){
        echo '<td style="'.$style.'">'.$row.'</td>';
      }
      echo '</tr>';
    }
  }
  echo '</table>';
}