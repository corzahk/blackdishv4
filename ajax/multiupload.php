<?php


$output = [];

if(isset($_FILES['images'])){
	$files = [];
	foreach ($_FILES['images'] as $k => $l) {
	  foreach ($l as $i => $v) {
	  if (!array_key_exists($i, $files))
	    $files[$i] = array();
	    $files[$i][$k] = $v;
	  }
	}

	$paths = [];
	$file_output = [];
	$i = 0;
	foreach ($files as $file) {
		$handle = new \Verot\Upload\Upload($file);
	  if ($handle->uploaded) {
			$handle->allowed            = array('image/jpeg','image/jpg','image/gif','image/png','image/bmp');
			$handle->file_new_name_body = md5(uniqid());
			if ($handle->image_src_x > 600){
				$handle->image_resize          = true;
				$handle->image_ratio_y         = true;
				$handle->image_x               = 600;
			}
	    $handle->Process("uploads-temp/");

	    if ($handle->processed) {
				$file_output[$i]['message'] = 'OK';
				$file_output[$i]['success'] = true;
				$file_output[$i]['path']    = "uploads-temp". DIRECTORY_SEPARATOR . $handle->file_dst_name;
				$file_output[$i]['name']    = $handle->file_src_name_body;
				$paths[]               = "uploads-temp". DIRECTORY_SEPARATOR . $handle->file_dst_name;
	    } else {
	      $output[$i]['message'] = 'Error: '.$handle->error;
				$output[$i]['success'] = false;
				$output[$i]['path']    = '';
				$output[$i]['name']    = '';
	    }
	  } else {
	    $output[$i]['message'] = 'Error: '.$handle->error;
			$output[$i]['success'] = false;
			$output[$i]['path']    = '';
			$output[$i]['name']    = '';
	  }
	  unset($handle);
		$i++;
	}
}

$output['file_output'] = $file_output;
$output['paths'] = $paths;
echo json_encode($output);
