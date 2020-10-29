<?php

if( $_SERVER['REQUEST_METHOD'] === 'POST' && us_level ){

	$p_oldpass  = isset($_POST['oldpass']) ? sc_sec($_POST['oldpass'])   : '';
	$p_newpass  = isset($_POST['newpass']) ? sc_sec($_POST['newpass'])   : 0;

	if((us_password && empty($p_oldpass)) || empty($p_newpass)){
		$alert = [
			'type'  =>'danger',
			'alert' => fh_alerts("all fields are required!")
		];
	} elseif(us_password && sc_pass($p_oldpass) != us_password){
		$alert = [
			'type'  =>'danger',
			'alert' => fh_alerts("old password is uncorrect!")
		];
	} elseif(strlen($p_newpass) < 6){
			$alert = [
				'type'  =>'danger',
				'alert' => fh_alerts("new password must be sup than 6 letters!")
			];
	} else {
		db_update("users", ['password' => sc_pass($p_newpass)], us_id);
		$alert = [
			'type'  =>'success',
			'alert' => fh_alerts("Success! all done!!", 'success')
		];
	}
	echo json_encode($alert);

}
