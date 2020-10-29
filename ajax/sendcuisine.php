<?php


if( $_SERVER['REQUEST_METHOD'] === 'POST' ){

	$p_name  = isset($_POST['name']) ? sc_sec($_POST['name'])   : '';
	$p_image = isset($_POST['image']) ? sc_sec($_POST['image']) : '';
	$p_id    = isset($_POST['id']) ? (int)($_POST['id'])   : 0;

	if(empty($p_name) || empty($p_image)){
		$alert = ["alert" => fh_alerts("All fields marked with * are required!"), "type" => "danger"];
	} else {

		if( $p_id ){
			$p_img = ($p_image != db_get("cuisines", "image", $p_id)) ? 'uploads/users/'.sc_folderName(us_username).'/cuisines'.str_replace('uploads-temp', '', $p_image) : $p_image;
			$p_image = $p_image != db_get("cuisines", "image", $p_id) ? $p_image : '';
		} else {
			$p_img = $p_image ? 'uploads/users/'.sc_folderName(us_username).'/cuisines'.str_replace('uploads-temp', '', $p_image) : '';
		}

		$data = [
			"name"       => $p_name,
			"image"      => $p_img,
			"author"     => us_id
		];

		if( $p_id ){
			$data['updated_at'] = time();
			db_update('cuisines', $data, $p_id);
		} else {
			$data['created_at'] = time();
			$data['author']     = us_id;
			db_insert('cuisines', $data);
		}

		if(!empty($p_image)){
			if(file_exists(__DIR__.'/../'.$p_image)){
				$answer_i_rename = 'uploads/users/'.sc_folderName(us_username).'/cuisines'.str_replace('uploads-temp', '', $p_image);
				fh_newImgFolder(__DIR__.'/../uploads/users/'.sc_folderName(us_username).'/cuisines');
				rename($p_image, $answer_i_rename);
			}
		}


		$alert = ["alert" => fh_alerts("The cuisine has been inserted successfully!", "success"), "type" => "success"];

	}

	echo json_encode($alert);
}
