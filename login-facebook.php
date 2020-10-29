<?php
session_start();
require_once(__DIR__.'/configs.php');
require_once(__DIR__.'/configs/src/Facebook/autoload.php');
$fb = new Facebook\Facebook([
	'app_id'                => fbAppId,
	'app_secret'            => fbAppSecret,
	'default_graph_version' => fbAppVersion,
]);
$helper      = $fb->getRedirectLoginHelper();
$_SESSION['FBRLH_state']=$_GET['state'];
$permissions = ['email'];


try {
	if (isset($_SESSION['facebook_access_token'])) {
		$accessToken = $_SESSION['facebook_access_token'];
	} else {
  		$accessToken = $helper->getAccessToken();
	}
} catch(Facebook\Exceptions\FacebookResponseException $e) {
 	echo 'Graph returned an error: ' . $e->getMessage();
  	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
  	exit;
}


if (isset($accessToken)) {
	if (isset($_SESSION['facebook_access_token'])) {
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	} else {
		$_SESSION['facebook_access_token'] = (string) $accessToken;
		$oAuth2Client                      = $fb->getOAuth2Client();
		$longLivedAccessToken              = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
		$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}

	
	if (isset($_GET['code'])) {
		header("Location: ".path."/login-facebook-rd.php");
	}
} else {
	$loginUrl = $helper->getLoginUrl(path."/login-facebook.php", $permissions);
	echo "<a href=\"{$facebookLoginUrl}\">Log in with Facebook!</a>";
}
