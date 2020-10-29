<?php


if($_SERVER['REQUEST_METHOD'] === 'POST'){
	if(us_level){
		$reg_firstname  = isset($_POST['reg_firstname']) ? sc_sec($_POST['reg_firstname'])   : '';
		$reg_lastname   = isset($_POST['reg_lastname']) ? sc_sec($_POST['reg_lastname'])     : '';
		$reg_name       = isset($_POST['reg_username']) ? sc_sec($_POST['reg_username'])     : '';
		$reg_pass       = isset($_POST['reg_pass']) ? sc_sec($_POST['reg_pass'])             : '';
		$reg_email      = isset($_POST['reg_email']) ? sc_sec($_POST['reg_email'])           : '';
		$reg_phone      = isset($_POST['reg_phone']) ? sc_sec($_POST['reg_phone'])           : '';
		$reg_phone_code = isset($_POST['reg_phone_code']) ? sc_sec($_POST['reg_phone_code']) : '';

		$reg_gender    = isset($_POST['reg_gender']) ? (int)($_POST['reg_gender'])        : 0;
		$reg_plan      = isset($_POST['reg_plan']) ? (int)($_POST['reg_plan'])            : 0;
		$reg_photo     = isset($_POST['reg_photo']) ? sc_sec($_POST['reg_photo'])         : '';
		$reg_country   = isset($_POST['reg_country']) ? sc_sec($_POST['reg_country'])     : '';
		$reg_state     = isset($_POST['reg_state']) ? sc_sec($_POST['reg_state'])         : '';
		$reg_city      = isset($_POST['reg_city']) ? sc_sec($_POST['reg_city'])           : '';
		$reg_address   = isset($_POST['reg_address']) ? sc_sec($_POST['reg_address'])     : '';
		$reg_uid       = isset($_POST['reg_id']) ? (int)($_POST['reg_id'])       : 0;

		$reg_id     = ($reg_uid && us_level == 6 ? $reg_uid    : us_id );

		$u_username = ($reg_uid && us_level == 6 ? $reg_name   : us_username );
		$u_email    = ($reg_uid && us_level == 6 ? $reg_email  : us_email );
		$u_photo    = ($reg_uid && us_level == 6 ? db_get("users", "photo", $reg_id)  : us_photo );
		$reg_plan   = (us_level             == 6 ? $reg_plan : db_get("users", "plan", $reg_plan) );

		if(empty($reg_name) || empty($reg_email)){
			$alert = [
				'type'  =>'danger',
				'alert' => fh_alerts($lang['signup']['alert']['required'])
			];
		} elseif(!preg_match('/^[\p{L}\' -]+$/u',$reg_name)){
			$alert = [
				'type'  =>'danger',
				'alert' => fh_alerts($lang['signup']['alert']['char_username'])
			];
		} elseif($reg_name && (strlen($reg_name) < 3 || strlen($reg_name) > 15)){
			$alert = [
				'type'  =>'danger',
				'alert' => fh_alerts($lang['signup']['alert']['limited_username'])
			];
		} elseif($reg_name != $u_username && db_rows("users WHERE username = '".$reg_name."'")){
			$alert = [
				'type'  =>'danger',
				'alert' => fh_alerts($lang['signup']['alert']['exist_username'])
			];
		} elseif($reg_pass && (strlen($reg_pass) < 6 || strlen($reg_pass) > 12)){
			$alert = [
				'type'  =>'danger',
				'alert' => fh_alerts($lang['signup']['alert']['limited_pass'])
			];
		} elseif(!sc_check_email($reg_email)){
			$alert = [
				'type'  =>'danger',
				'alert' => fh_alerts($lang['signup']['alert']['check_email'])
			];
		} elseif($reg_email != $u_email && db_rows("users WHERE email = '".$reg_email."'")){
			$alert = [
				'type'  =>'danger',
				'alert' => fh_alerts($lang['signup']['alert']['exist_email'])
			];
		} else {

			$reg_phone   = !empty($reg_phone) ? "(+$reg_phone_code) ".$reg_phone : '';
			$data = [
				'firstname'  => "{$reg_firstname}",
				'lastname'   => "{$reg_lastname}",
				'username'   => "{$reg_name}",
				'email'      => "{$reg_email}",
				'address'    => "{$reg_address}",
				'country'    => "{$reg_country}",
				'city'       => "{$reg_city}",
				'state'      => "{$reg_state}",
				'gender'     => "{$reg_gender}",
				'photo'      => "{$reg_photo}",
				'plan'       => "{$reg_plan}",
				'phone'      => "{$reg_phone}",
				'updated_at' => time()
			];

			if($reg_pass) $data['password'] = sc_pass($reg_pass);

			if($reg_photo != $u_photo){
				if(file_exists(__DIR__.'/../'.$reg_photo)){
					$answer_i_rename = 'uploads/users/'.sc_folderName(us_username).'/profile'.str_replace('uploads-temp', '', $reg_photo);
					fh_newImgFolder(__DIR__.'/../uploads/users/'.sc_folderName(us_username).'/profile');
					rename($reg_photo, $answer_i_rename);
					$data['photo']     = $answer_i_rename;
				}
			}

			db_update("users", $data, $reg_id);

			$alert = [
				'type'  =>'success',
				'alert' => fh_alerts($lang['details']['alert']['success'], 'success')
			];

		}

		echo json_encode($alert);
	}
}
