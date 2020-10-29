<?php

if($_SERVER['REQUEST_METHOD'] === 'POST' && us_level == 6){

	$pg_title       = sc_sec($_POST['site_title']);
	$pg_description = sc_sec($_POST['site_description']);
	$pg_keywords    = sc_sec($_POST['site_keywords']);
	$pg_url         = sc_sec($_POST['site_url']);

	$site_noreply              = sc_sec($_POST['site_noreply']);
	$site_register             = isset($_POST['site_register']) ? (int)($_POST['site_register']) : 0;
	$login_facebook            = isset($_POST['login_facebook']) ? (int)($_POST['login_facebook']) : 0;
	$login_twitter             = isset($_POST['login_twitter']) ? (int)($_POST['login_twitter']) : 0;
	$login_google              = isset($_POST['login_google']) ? (int)($_POST['login_google']) : 0;
	$site_paypal_live          = isset($_POST['site_paypal_live']) ? (int)($_POST['site_paypal_live']) : 0;
	$site_smtp                 = isset($_POST['site_smtp']) ? 1 : 0;
	$login_fbAppId             = sc_sec($_POST['login_fbAppId']);
	$login_fbAppSecret         = sc_sec($_POST['login_fbAppSecret']);
	$login_fbAppVersion        = sc_sec($_POST['login_fbAppVersion']);
	$login_twConKey            = sc_sec($_POST['login_twConKey']);
	$login_twConSecret         = sc_sec($_POST['login_twConSecret']);
	$login_ggClientId          = sc_sec($_POST['login_ggClientId']);
	$login_ggClientSecret      = sc_sec($_POST['login_ggClientSecret']);
	$site_paypal_id            = sc_sec($_POST['site_paypal_id']);
	$site_paypal_client_id     = sc_sec($_POST['site_paypal_client_id']);
	$site_paypal_client_secret = sc_sec($_POST['site_paypal_client_secret']);
	$site_currency_name        = sc_sec($_POST['site_currency_name']);
	$site_currency_symbol      = sc_sec($_POST['site_currency_symbol']);
	$site_smtp_host            = sc_sec($_POST['site_smtp_host']);
	$site_smtp_username        = sc_sec($_POST['site_smtp_username']);
	$site_smtp_password        = sc_sec($_POST['site_smtp_password']);
	$site_smtp_encryption      = sc_sec($_POST['site_smtp_encryption']);
	$site_smtp_auth            = sc_sec($_POST['site_smtp_auth']);
	$site_smtp_port            = sc_sec($_POST['site_smtp_port']);
	$site_logo                 = sc_sec($_POST['site_logo']);
	$site_favicon              = sc_sec($_POST['site_favicon']);
	$site_facebook             = sc_sec($_POST['site_facebook']);
	$site_twitter              = sc_sec($_POST['site_twitter']);
	$site_instagram            = sc_sec($_POST['site_instagram']);
	$site_youtube              = sc_sec($_POST['site_youtube']);
	$site_skype                = sc_sec($_POST['site_skype']);
	$site_stripe_key           = sc_sec($_POST['site_stripe_key']);
	$site_stripe_secret        = sc_sec($_POST['site_stripe_secret']);
	$ipinfo        = sc_sec($_POST['ipinfo']);

	if(empty($pg_title) || empty($pg_description)){
		$alert = [
			'type'  =>'danger',
			'alert' => fh_alerts($lang['alerts']['required'])
		];
	} else {
		db_update_global('site_title', $pg_title);
		db_update_global('site_description', $pg_description);
		db_update_global('site_keywords', $pg_keywords);
		db_update_global('site_url', $pg_url);

		db_update_global('site_noreply', $site_noreply);
		db_update_global('site_register', $site_register);
		db_update_global('login_facebook', $login_facebook);
		db_update_global('login_twitter', $login_twitter);
		db_update_global('login_google', $login_google);
		db_update_global('site_paypal_live', $site_paypal_live);
		db_update_global('site_smtp', $site_smtp);
		db_update_global('login_fbAppId', $login_fbAppId);
		db_update_global('login_fbAppSecret', $login_fbAppSecret);
		db_update_global('login_fbAppVersion', $login_fbAppVersion);
		db_update_global('login_twConKey', $login_twConKey);
		db_update_global('login_twConSecret', $login_twConSecret);
		db_update_global('login_ggClientId', $login_ggClientId);
		db_update_global('login_ggClientSecret', $login_ggClientSecret);
		db_update_global('site_paypal_id', $site_paypal_id);
		db_update_global('site_paypal_client_id', $site_paypal_client_id);
		db_update_global('site_paypal_client_secret', $site_paypal_client_secret);
		db_update_global('site_currency_name', $site_currency_name);
		db_update_global('site_currency_symbol', $site_currency_symbol);
		db_update_global('site_smtp_host', $site_smtp_host);
		db_update_global('site_smtp_username', $site_smtp_username);
		db_update_global('site_smtp_password', $site_smtp_password);
		db_update_global('site_smtp_encryption', $site_smtp_encryption);
		db_update_global('site_smtp_auth', $site_smtp_auth);
		db_update_global('site_smtp_port', $site_smtp_port);
		db_update_global('site_facebook', $site_facebook);
		db_update_global('site_twitter', $site_twitter);
		db_update_global('site_instagram', $site_instagram);
		db_update_global('site_youtube', $site_youtube);
		db_update_global('site_skype', $site_skype);
		db_update_global('site_stripe_key', $site_stripe_key);
		db_update_global('site_stripe_secret', $site_stripe_secret);
		db_update_global('ipinfo', $ipinfo);


		if($site_logo != site_logo){
			if(file_exists(__DIR__.'/../'.$site_logo)){
				$answer_i_rename = 'uploads/settings'.str_replace('uploads-temp', '', $site_logo);
				fh_newImgFolder(__DIR__.'/../uploads/settings');
				rename($site_logo, $answer_i_rename);
				db_update_global('site_logo', $answer_i_rename);
			}
		}

		if($site_favicon != site_favicon){
			if(file_exists(__DIR__.'/../'.$site_favicon)){
				$answer_i_rename = 'uploads/settings'.str_replace('uploads-temp', '', $site_favicon);
				fh_newImgFolder(__DIR__.'/../uploads/settings');
				rename($site_favicon, $answer_i_rename);
				db_update_global('site_favicon', $answer_i_rename);
			}
		}

		$alert = [
			'type'  =>'success',
			'alert' => fh_alerts($lang['dash']['alert']['success'], 'success')
		];
	}
	echo json_encode($alert);
}
