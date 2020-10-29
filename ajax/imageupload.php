<?php


if(us_level){
	$imgurl = '';
	$dir_dest = 'uploads-temp';

	$handle = new \Verot\Upload\Upload($_FILES['file']);
	if ($handle->uploaded) {
		$handle->allowed        = array('image/jpeg','image/jpg','image/gif','image/png','image/bmp');
		$handle->file_safe_name = true;
		$fileNewName = base64_encode($handle->file_src_name_body)."_".time();
		$handle->file_new_name_body = $fileNewName;

	  $handle->process($dir_dest);
	  if ($handle->processed) {
			$imgurl = $dir_dest.'/' . $handle->file_dst_name;
	  } else {

	  }
		$handle->clean();
	}

	echo $imgurl;
}
