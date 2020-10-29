<?php
session_start();
error_reporting(0);
function rewrite_urls($change){
  $match = [

    '/restaurants.php\?id=([0-9]+)&t=([A-Za-z0-9_-]+)/',
    '/restaurants.php/',

    '/cuisines.php\?id=([0-9]+)&t=([0-9a-zA-z]+)/',
    '/cuisines.php/',

    '/pages.php\?id=([0-9]+)&t=([0-9a-zA-z]+)/',
    '/plans.php/',
    '/cart.php/',
    '/myorders.php/',
    '/userdetails.php\?id=([0-9]+)/',
    '/userdetails.php/',

    '/restaurant.php\?pg=([a-zA-z]+)&request=([a-zA-z]+)&id=([0-9]+)/',
    '/restaurant.php\?pg=([a-zA-z]+)&request=([a-zA-z]+)/',
    '/restaurant.php\?pg=([a-zA-z]+)/',
    '/restaurant.php/',

  ];
  $replace = [

    'restaurants/$1/$2',
    'restaurants',

    'cuisines/$1/$2',
    'cuisines',

    'pages/$1/$2',
    'plans',
    'cart',
    'myorders',
    'userdetails/$1',
    'userdetails',

    'restaurant/$1/$2/$3',
    'restaurant/$1/$2',
    'restaurant/$1',
    'restaurant',

  ];

  $change = preg_replace($match, $replace, $change);

	return $change;
}
ob_start("rewrite_urls");


# Language
$lang = [];
if(isset($_COOKIE['lang']) && file_exists(__DIR__.'/lang/'.$_COOKIE['lang'].'.php')){
	include __DIR__.'/lang/'.$_COOKIE['lang'].'.php';
} else {
	include __DIR__.'/lang/en.php';
}

function getBaseUrl(){
  $protocol = 'http';
  if ($_SERVER['SERVER_PORT'] == 443 || (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on')) {
    $protocol .= 's';
  }
  $host = $_SERVER['HTTP_HOST'];
  $request = $_SERVER['PHP_SELF'];
  return dirname($protocol . '://' . $host . $request);
}

# Your website path
define("path", getBaseUrl());

include __DIR__."/configs/connection.php";
include __DIR__."/configs/defines.php";
include __DIR__."/configs/countries.php";
include __DIR__."/configs/phone.php";
include __DIR__."/configs/functions.php";
include __DIR__."/configs/pagination.php";
include __DIR__."/configs/class.upload.php";


# Site Details
db_global();

# User Details
db_login_details();

if(in_array(page, ['configs', 'login'])){
  header("HTTP/1.0 404 Not Found");
}

# User Client Info
include __DIR__."/configs/info.class.php";

define("get_ip",           (in_array(page, ["response", "stripe"]) ? UserInfo::get_ip() : "") );
define("get_os",           (in_array(page, ["response", "stripe"]) ? UserInfo::get_os() : "") );
define("get_browser",      (in_array(page, ["response", "stripe"]) ? UserInfo::get_browser() : "") );
define("get_device",       (in_array(page, ["response", "stripe"]) ? UserInfo::get_device() : "") );



#PHPMailer
use PHPMailer\PHPMailer\PHPMailer;

require __DIR__.'/configs/phpmailer/Exception.php';
require __DIR__.'/configs/phpmailer/PHPMailer.php';
require __DIR__.'/configs/phpmailer/SMTP.php';

$mail = new PHPMailer();

if(defined("site_smtp") && site_smtp == 1)
	$mail->isSMTP();

$mail->Host       = (defined("site_smtp_host") && site_smtp_host != '' ? site_smtp_host : '');
$mail->SMTPAuth   = (defined("site_smtp_port") && site_smtp_port == '1' ? true : false);
$mail->Username   = (defined("site_smtp_username") && site_smtp_username != '' ? site_smtp_username : '');
$mail->Password   = (defined("site_smtp_password") && site_smtp_password != '' ? site_smtp_password : '');
$mail->SMTPSecure = (defined("site_smtp_encryption") && site_smtp_encryption != 'none' ? site_smtp_encryption : false);
$mail->Port       = (defined("site_smtp_port") && site_smtp_port != '' ? site_smtp_port : '');

$mail->setFrom((defined("site_noreply") && site_noreply != '' ? site_noreply : ''), site_title);


# Facebook Login App
define("fbAppId",      login_fbAppId);
define("fbAppSecret",  login_fbAppSecret);
define("fbAppVersion", login_fbAppVersion);

$facebookLoginUrl = '#';
if(fbAppId != '' && fbAppSecret != '' && fbAppVersion != ''){
	require __DIR__.'/configs/src/Facebook/autoload.php';
	$fb = new Facebook\Facebook([
		'app_id'                => fbAppId,
		'app_secret'            => fbAppSecret,
		'default_graph_version' => fbAppVersion,
	]);
	$helper      = $fb->getRedirectLoginHelper();
	$permissions = ['email'];
	$facebookLoginUrl    = $helper->getLoginUrl(path."/login-facebook.php", $permissions);
}

# Twitter Login App
define('twConKey',        login_twConKey);
define('twConSecret',     login_twConSecret);
define('twOauthCallback', path."/login-twitter.php");

if(twConKey != '' && twConSecret != ''){
	require_once(__DIR__."/configs/src/Twitter/twitteroauth.php");
	$twitterLoginUrl = path."/login-twitter.php";
}

# Google Login App
define('ggClientId',      login_ggClientId);
define('ggClientSecret',  login_ggClientSecret);
define('ggOauthCallback', path."/login-google.php");
define('ggAppName',       site_title);

if(ggClientId != '' && ggClientSecret != ''){
	require_once(__DIR__."/configs/src/Google/Google_Client.php");
	require_once(__DIR__."/configs/src/Google/contrib/Google_Oauth2Service.php");

	$gClient = new Google_Client();
	$gClient->setApplicationName(ggAppName);
	$gClient->setClientId(ggClientId);
	$gClient->setClientSecret(ggClientSecret);
	$gClient->setRedirectUri(ggOauthCallback);

	$google_oauthV2 = new Google_Oauth2Service($gClient);
	$googleLoginUrl = $gClient->createAuthUrl();
}

# GET Defined vars
$request = (isset($_GET['request']) ? sc_sec($_GET['request']) : '');
$pg      = (isset($_GET['pg']) ? sc_sec($_GET['pg'])           : '');
$token   = (isset($_GET['token']) ? sc_sec($_GET['token'])     : '');
$t       = (isset($_GET['t']) ? sc_sec($_GET['t'])             : '');
$id      = (isset($_GET['id']) ? (int)($_GET['id'])            : '');
$s       = (isset($_GET['s']) ? (int)($_GET['s'])              : '');
$mi      = (isset($_GET['mi']) ? (int)($_GET['mi'])            : '');
$ri      = (isset($_GET['ri']) ? (int)($_GET['ri'])            : '');

# Pagination
$page = (int) (!isset($_GET["page"]) || !$_GET["page"] ? 1 : sc_sec($_GET["page"]));
$limit = 12;
$startpoint = ($page * $limit) - $limit;


# Delete order cookie
if($pg == "ordersuccess"){
	setcookie("addtocart", "", 1);
	unset($_COOKIE['addtocart']);
}

# Currency
define("dollar_sign", site_currency_symbol);
define("dollar_name", site_currency_name);


# Paypal Payement Gateway configuration
define('PAYPAL_CLIENT_ID', (defined("site_paypal_client_id") && site_paypal_client_id != '' ? site_paypal_client_id : ''));
define('PAYPAL_CLIENT_SECRET', (defined("site_paypal_client_secret") && site_paypal_client_secret != '' ? site_paypal_client_secret : ''));
define('PAYPAL_ID', (defined("site_paypal_id") && site_paypal_id != '' ? site_paypal_id : ''));
define('PAYPAL_SANDBOX', (defined("site_paypal_live") && site_paypal_live == 1 ? false : true)); //TRUE (testing) or FALSE (live)

define('PAYPAL_RETURN_URL', path.'/payment-success.php');
define('PAYPAL_CANCEL_URL', path.'/index.php');
define('PAYPAL_NOTIFY_URL', path.'/ipn.php');
define('PAYPAL_CURRENCY', (defined("site_currency_name") && site_currency_name != '' ? site_currency_name : ''));

define('PAYPAL_URL', (PAYPAL_SANDBOX == true)?"https://www.sandbox.paypal.com/cgi-bin/webscr":"https://www.paypal.com/cgi-bin/webscr");


use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

require 'vendor/autoload.php';

$paypalConfig = [
  'client_id'       => PAYPAL_CLIENT_ID,
  'client_secret'   => PAYPAL_CLIENT_SECRET,
  'return_url_plan' => path.'/response-plan.php',
  'return_url'      => path.'/response.php',
  'cancel_url'      => path.'/index.php',
	'sandbox'         => PAYPAL_SANDBOX
];

$apiContext = new ApiContext( new OAuthTokenCredential($paypalConfig['client_id'], $paypalConfig['client_secret']) );
$apiContext->setConfig([ 'mode' => $paypalConfig['sandbox'] ? 'sandbox' : 'live' ]);



use ipinfo\ipinfo\IPinfo;

if(!isset($_COOKIE['ipall'])){
$access_token = ipinfo;
$client       = new IPinfo($access_token);
$details      = $client->getDetails();
setcookie("ipall", json_encode($details->all), time()+3600*24*30);
}

$ipall = isset($_COOKIE['ipall']) ? json_decode(sc_cookie($_COOKIE['ipall']), true) : '';


define("get_country_name", (in_array(page, ["response", "stripe"]) ? (isset($ipall['country_name']) ? $ipall['country_name'] : "") : "") );
define("get_country_code", (in_array(page, ["response", "stripe"]) ?  (isset($ipall['country']) ? $ipall['country'] : "") : "") );
define("get_state",        (in_array(page, ["response", "stripe"]) ?  (isset($ipall['region']) ? $ipall['region'] : "") : "") );
define("get_city_name",    (in_array(page, ["response", "stripe"]) ?  (isset($ipall['city']) ? $ipall['city'] : "") : "") );


# Plans Options
define("restaurants", us_plan ? db_get("plans", "restaurants", us_plan) : '');
define("menus",       us_plan ? db_get("plans", "menus", us_plan) : '');
define("items",       us_plan ? db_get("plans", "items", us_plan) : '');
define("orders",      us_plan ? db_get("plans", "orders", us_plan) : '');

define("export_statistics", us_plan ? db_get("plans", "export_statistics", us_plan) : '');
define("invoices",          us_plan ? db_get("plans", "invoices", us_plan) : '');
define("statistics",        us_plan ? db_get("plans", "statistics", us_plan) : '');
define("stripe",            us_plan ? db_get("plans", "stripe", us_plan) : '');
define("show_ads",          us_plan ? db_get("plans", "show_ads", us_plan) : '');
define("support",           us_plan ? db_get("plans", "support", us_plan) : '');
