<?php

if( $_SERVER['REQUEST_METHOD'] === 'POST' && us_level ){

	$p_name  = isset($_POST['name']) ? sc_sec($_POST['name'])   : '';
	$p_rest  = isset($_POST['rest']) ? sc_sec($_POST['rest'])   : 0;
	$p_id    = isset($_POST['id']) ? (int)($_POST['id'])   : 0;

	if(empty($p_name) || !$p_rest){
		$alert = ["alert" => fh_alerts("All fields marked with * are required!"), "type" => "danger"];
	} else {

		$data = [
			"name"       => $p_name,
			"restaurant" => $p_rest,
			"author"     => us_id
		];

		if( $p_id && (db_rows("menus WHERE id = '{$p_id}' && author = '".us_id."'") || us_level == 6) ){
			$data['updated_at'] = time();
			db_update('menus', $data, $p_id);
		} else {
			$data['created_at'] = time();
			$data['author']     = us_id;
			db_insert('menus', $data);
		}

		$alert = ["alert" => fh_alerts("Success! all done!!", "success"), "type" => "success"];

	}

	echo json_encode($alert);
}
