<?php

if( $_SERVER['REQUEST_METHOD'] === 'POST' && us_level ){

	$p_name           = isset($_POST['name']) ? sc_sec($_POST['name'])                     : '';
	$p_resto          = isset($_POST['resto']) ? sc_sec($_POST['resto'])                   : 0;
	$p_menu           = isset($_POST['menu']) ? sc_sec($_POST['menu'])                     : 0;
	$p_cuisine        = isset($_POST['cuisine']) ? sc_sec($_POST['cuisine'])               : 0;
	$p_desc           = isset($_POST['desc']) ? sc_sec($_POST['desc'])                     : '';
	$p_price          = isset($_POST['price']) ? sc_sec($_POST['price'])                   : '';
	$p_reduce         = isset($_POST['reduce']) ? sc_sec($_POST['reduce'])                 : '';
	$p_ingredients    = isset($_POST['ingredients']) ? sc_sec($_POST['ingredients'])       : '';
	$p_oimage         = isset($_POST['oimage']) ? sc_sec($_POST['oimage'])                 : '';
	$p_image          = isset($_POST['image']) ? sc_sec($_POST['image'])                 : '';
	$p_delivery_price = isset($_POST['delivery_price']) && !empty($_POST['delivery_price']) ? sc_sec($_POST['delivery_price']) : 0;
	$p_delivery_time  = isset($_POST['delivery_time']) ? sc_sec($_POST['delivery_time'])   : '';
	$p_id             = isset($_POST['id']) ? (int)($_POST['id'])   : 0;

	$p_sizes = [];
	$p_sizes_err = 'success';
	if(isset($_POST['size'])){
		foreach ($_POST['size'] as $k => $v) {
			$v = array_filter($v, function($value) { return !is_null($value) && $value !== ''; });
			if(count($v) >= 2){
				foreach ($v as $kk => $vv) {
					$p_sizes[$k][$kk] = sc_sec($vv);
				}
			} else {
				$p_sizes_err = "error";
			}
		}
	}

	$p_extras = [];
	$p_extras_err = 'success';
	if(isset($_POST['extra'])){
		foreach ($_POST['extra'] as $k => $v) {
			$v = array_filter($v, function($value) { return !is_null($value) && $value !== ''; });
			if(count($v) == 2){
				foreach ($v as $kk => $vv) {
					$p_extras[$k][$kk] = sc_sec($vv);
				}
			} else {
				$p_extras_err = "error";
			}
		}
	}



	if(fh_empty($p_name, $p_menu, $p_cuisine, $p_price, $p_resto)){
		$alert = ["alert" => fh_alerts("All fields marked with * are required!"), "type" => "danger"];
	} else {

		if(!$p_id){
			$p_img = !empty($p_image) ? 'uploads/users/'.sc_folderName(us_username).'/items'.str_replace('uploads-temp', '', $p_image) : '';
		} else {
			$p_img = !empty($p_image) ? 'uploads/users/'.sc_folderName(us_username).'/items'.str_replace('uploads-temp', '', $p_image) : $p_oimage;
		}

		$p_sizes  = !empty($p_sizes) ? serialize($p_sizes) : '';
		$p_extras = !empty($p_extras) ? serialize($p_extras) : '';

		$data = [
			"name"           => $p_name,
			"menu"           => $p_menu,
			"cuisine"        => $p_cuisine,
			"description"    => $p_desc,
			"selling_price"  => $p_price,
			"reduce_price"   => $p_reduce,
			"ingredients"    => $p_ingredients,
			"image"          => $p_img,
			"restaurant"     => $p_resto,
			"sizes"          => $p_sizes,
			"extra"          => $p_extras,
			"delivery_price" => $p_delivery_price,
			"delivery_time"  => $p_delivery_time
		];

		if( $p_id && (db_rows("items WHERE id = '{$p_id}' && author = '".us_id."'") || us_level == 6) ){
			$data['updated_at'] = time();
			db_update('items', $data, $p_id);
		} else {
			$data['created_at'] = time();
			$data['author']     = us_id;
			db_insert('items', $data);
		}

		if(isset($p_image)){
			if(file_exists(__DIR__.'/../'.$p_image)){
				$answer_i_rename = 'uploads/users/'.sc_folderName(us_username).'/items'.str_replace('uploads-temp', '', $p_image);
				fh_newImgFolder(__DIR__.'/../uploads/users/'.sc_folderName(us_username).'/items');
				rename($p_image, $answer_i_rename);
			}
		}

		$alert = ["alert" => fh_alerts("Success! all done!!", "success"), "type" => "success"];

	}

	echo json_encode($alert);
}
