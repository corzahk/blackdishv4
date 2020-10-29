<?php

if( $_SERVER['REQUEST_METHOD'] === 'POST' ){

	$p_name          = isset($_POST['name']) ? sc_sec($_POST['name'])                   : '';
	$p_phone         = isset($_POST['phone']) ? sc_sec($_POST['phone'])                 : '';
	$p_phone_code    = isset($_POST['phone_code']) ? sc_sec($_POST['phone_code'])       : '';
	$p_email         = isset($_POST['email']) ? sc_sec($_POST['email'])                 : '';
	$p_delivery_time = isset($_POST['delivery_time']) ? sc_sec($_POST['delivery_time']) : '';
	$p_delivery_fees = isset($_POST['delivery_fees']) ? sc_sec($_POST['delivery_fees']) : '';
	$p_cuisine       = isset($_POST['cuisine']) ? sc_array($_POST['cuisine'], 'int')    : '';
	$p_services      = isset($_POST['services']) ? (int)($_POST['services'])            : 0;
	$p_country       = isset($_POST['country']) ? sc_sec($_POST['country'])             : '';
	$p_city          = isset($_POST['city']) ? sc_sec($_POST['city'])                   : '';
	$p_state         = isset($_POST['state']) ? sc_sec($_POST['state'])                 : '';
	$p_address       = isset($_POST['address']) ? sc_sec($_POST['address'])             : '';
	$p_zip           = isset($_POST['zip']) ? sc_sec($_POST['zip'])                     : '';
	$p_maps          = isset($_POST['maps']) ? sc_sec($_POST['maps'])                   : '';
	$p_profile       = isset($_POST['profile']) ? sc_sec($_POST['profile'])             : '';
	$p_cover         = isset($_POST['cover']) ? sc_sec($_POST['cover'])                 : '';
	$p_eprofile      = isset($_POST['eprofile']) ? sc_sec($_POST['eprofile'])             : '';
	$p_ecover        = isset($_POST['ecover']) ? sc_sec($_POST['ecover'])                 : '';
	$p_facebook      = isset($_POST['facebook']) ? sc_sec($_POST['facebook'])           : '';
	$p_twitter       = isset($_POST['twitter']) ? sc_sec($_POST['twitter'])             : '';
	$p_instagram     = isset($_POST['instagram']) ? sc_sec($_POST['instagram'])         : '';
	$p_youtube       = isset($_POST['youtube']) ? sc_sec($_POST['youtube'])             : '';
	$p_latitude      = isset($_POST['latitude']) ? sc_sec($_POST['latitude'])             : '';
	$p_longitude     = isset($_POST['longitude']) ? sc_sec($_POST['longitude'])             : '';
	$p_working_hours = isset($_POST['working_hours']) ? json_encode(sc_array($_POST['working_hours'])) : '';
	$p_neworders     = isset($_POST['neworders']) ? 1 : 0;

	$p_id            = isset($_POST['id']) ? (int)($_POST['id'])             : 0;

	if(fh_empty($p_name, $p_phone, $p_email, $p_delivery_time, $p_cuisine, $p_services, $p_country, $p_city, $p_address)){
		$alert = ["alert" => $lang['alerts']['required'], "type" => "danger"];
	} else {

		$p_phone   = !empty($p_phone) ? "(+$p_phone_code) ".$p_phone : '';
		$p_cuisine = !empty($p_cuisine) ? implode(',', $p_cuisine) : '';
		if(!$p_id){
			$p_profile = !empty($p_profile) ? 'uploads/users/'.sc_folderName(us_username).'/'.str_replace('uploads-temp', '', $p_profile) : '';
			$p_cover   = !empty($p_cover) ? 'uploads/users/'.sc_folderName(us_username).'/'.str_replace('uploads-temp', '', $p_cover) : '';
		} else {
			$p_profile = !empty($p_profile) ? 'uploads/users/'.sc_folderName(us_username).'/'.str_replace('uploads-temp', '', $p_profile) : $p_eprofile;
			$p_cover   = !empty($p_cover) ? 'uploads/users/'.sc_folderName(us_username).'/'.str_replace('uploads-temp', '', $p_cover) : $p_ecover;
		}

		$data = [
			"name"          => $p_name,
			"phone"         => $p_phone,
			"email"         => $p_email,
			"delivery_time" => $p_delivery_time,
			"delivery_fees" => $p_delivery_fees,
			"cuisine"       => $p_cuisine,
			"services"      => $p_services,
			"country"       => $p_country,
			"city"          => $p_city,
			"state"         => $p_state,
			"address"       => $p_address,
			"zipcode"       => $p_zip,
			"maps"          => $p_maps,
			"photo"         => $p_profile,
			"cover"         => $p_cover,
			"facebook"      => $p_facebook,
			"twitter"       => $p_twitter,
			"instagram"     => $p_instagram,
			"youtube"       => $p_youtube,
			"latitude"      => $p_latitude,
			"longitude"     => $p_longitude,
			"neworders"     => $p_neworders,
			"working_hours" => str_replace("[]", "", $p_working_hours)
		];
		if($p_id){
			$data["updated_at"] = time();
			db_update('restaurants', $data, $p_id);
		} else {
			$data["created_at"] = time();
			$data["author"]     = us_id;
			db_insert('restaurants', $data);
		}


		if(isset($_POST['images_tmp'])){
			foreach ($_POST['images_tmp'] as $key => $val) {
				$ff = sc_sec($val);
				$alert['img'] = $ff;
				$alert['img1'] = file_exists(__DIR__.'/../'.$ff);
				if(file_exists(__DIR__.'/../'.$ff)){
					$answer_i_rename = 'uploads/users/'.sc_folderName(us_username).str_replace('uploads-temp', '', $ff);
					fh_newImgFolder(__DIR__.'/../uploads/users/'.sc_folderName(us_username));
					rename($ff, $answer_i_rename);
					db_insert('images', [
						"table_name" => 'restaurants',
						"table_id"   => db_get("restaurants", "id", $p_name, "name", "&& author = '".us_id."' ORDER BY id DESC LIMIT 1"),
						"created_at" => time(),
						"author"     => us_id,
						"url"        => $answer_i_rename
					]);
				}
			}
		}

		$alert = ["alert" => $lang['alerts']['alldone'], "type" => "success"];

	}

	echo json_encode($alert);
}
