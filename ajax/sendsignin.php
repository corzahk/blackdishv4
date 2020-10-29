<?php


if($_SERVER['REQUEST_METHOD'] === 'POST'){
	if(!us_level){
		$data_name = sc_sec($_POST['sign_name']);
		$data_pass = sc_sec($_POST['sign_pass']);
		$data_type = isset($_POST['sign_type']) ? 1 : 0;

		if(empty($data_name) || empty($data_pass)){
			$alert = [
				'type'  =>'danger',
				'alert' => fh_alerts($lang['login']['alert']['required'])
			];
		} else {
			if(db_rows('users WHERE username = "'.$data_name.'" || email = "'.$data_name.'"')){
				$sql = $db->query("SELECT id, password, moderat FROM ".prefix."users WHERE (username = '{$data_name}' || email = '{$data_name}') && password = '".sc_pass($data_pass)."'");
				if($sql->num_rows){
					$rs = $sql->fetch_assoc();
					if($rs['moderat'] == 0){ // moderat [0=>'active', 1=>'ban', 2=>'need email acivation']
						if($data_type){
							setcookie('login', $rs['id'], time + 31536000);
						} else {
							$_SESSION['login']  = $rs['id'];
						}

						$alert = [
							'type'  =>'success',
							'alert' => fh_alerts($lang['login']['alert']['success'], 'success')
						];
					} elseif($rs['moderat'] == 2){
						$alert = [
							'type'  =>'danger',
							'alert' => fh_alerts($lang['login']['alert']['activation'], 'warning')
						];
					} elseif($rs['moderat'] == 3){
						$alert = [
							'type'  =>'danger',
							'alert' => fh_alerts($lang['login']['alert']['approve'], 'warning')
						];
					} else {
						$alert = [
							'type'  =>'success',
							'alert' => fh_alerts($lang['login']['alert']['moderat'], 'warning')
						];
					}
				} else {
					$alert = [
						'type'  =>'danger',
						'alert' => fh_alerts($lang['login']['alert']['error'])
					];
				}
			} else {
				$alert = [
					'type'  =>'danger',
					'alert' => fh_alerts($lang['login']['alert']['error'])
				];
			}
		}

		echo json_encode($alert);
	}
}
