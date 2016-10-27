<?php
/**
 * The template for key facts statistics page
 * Template Name: Upload File
 * 
 */

$upload_dir = wp_upload_dir();
//var_dump($upload_dir);
//var_dump($upload_dir['basedir']);
//wp_mkdir_p($upload_dir['basedir'].'/submissions');

// You need to add server side validation and better error handling here
$data = array();
if(isset($_GET['files'])) {  
  $error = false;
  $files = array();

  $upload_dir = wp_upload_dir();
  
  
  
  $uploaddir = $upload_dir['basedir'] . '/submissions/';
  $uploadurl = $upload_dir['baseurl'] . '/submissions/';
  
  $supported_types = array (
      'image/jpg',
      'image/jpeg',
      'image/gif',
      'image/png'
  );
  $max_file_size = 1024 * 1024 * 2; //2MB
  
  foreach($_FILES as $file) {
    $file_size = $file['size'];
    if($file_size > $max_file_size || $file_size==0){
      $error = true;
      $error_message = 'File blank or larger the limit.'+"\n";
    }
    $uploaded_type = $file['type'];
    if(!in_array($uploaded_type, $supported_types)) {
      $error = true;
      $error_message = 'Invalid file type.'+"\n";
    }
    
    $upload_filename = time() .'_'.$file['name'];
    
    if($error===false AND move_uploaded_file($file['tmp_name'], $uploaddir .basename($upload_filename))) {
      $files[] = $uploadurl.$upload_filename;
    } else {
      $error = true;
      $error_message = 'There was an error uploading your files';
    }
  }
  $data = ($error) ? array('error' => $error_message) : array('files' => $files);
} else {
  $data = array('success' => 'Form was submitted', 'formData' => $_POST);
}
echo json_encode($data);