<?php

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;


if (empty(sc_sec($_POST['item_number']))) {
	echo fh_alerts("This script should not be called directly", "danger");
	exit;
}

$db_plan = isset($_POST['item_name']) ? sc_sec($_POST['item_name']) : '';
$db_id   = isset($_POST['item_number']) ? (int)(str_replace("Plan#", "",$_POST['item_number'])) : '';


if($db_id == 1 && !us_plan){

	db_update("users", ["plan" => $db_id, "lastpayment" => time()], us_id);

	db_insert("payments", [
		"plan"       => $db_id,
		"payment_id" => "",
		"payer_id"   => "",
		"token"      => "",
		"price"      => "0.00",
		"date"       => time(),
		"author"     => us_id,
		"status"     => "completed",
	]);

	$alert = ["alert" => fh_alerts($lang['alerts']['payment'], "success"), "type" => "success"];
	$alert['url'] = path."/restaurant.php?pg=details";
	echo json_encode($alert);
	exit;
}



$payer = new Payer();
$payer->setPaymentMethod('paypal');


$itm_arr = [];

$pln_name = $db_plan;
$pln_price = db_get("plans", "price", $db_id);


$item01 = new Item();
$item01->setName($pln_name)->setCurrency(dollar_name)->setQuantity(1)->setSku(rand())->setPrice($pln_price);

$itm_arr[] = $item01;

$itemList = new ItemList();
$itemList->setItems($itm_arr);

$amount = new Amount();
$amount->setCurrency(dollar_name)->setTotal($pln_price);

$transaction = new Transaction();
$transaction->setAmount($amount)->setItemList($itemList)->setDescription("Payment description")->setInvoiceNumber(uniqid());

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl($paypalConfig['return_url_plan'])->setCancelUrl($paypalConfig['cancel_url']);

$payment = new Payment();
$payment->setIntent("sale")->setPayer($payer)->setRedirectUrls($redirectUrls)->setTransactions(array($transaction));

try {
    $payment->create($apiContext);
} catch (PayPal\Exception\PayPalConnectionException $ex) {
    echo $ex->getCode();
    echo $ex->getData();
    die($ex);
} catch (Exception $ex) {
    die($ex);
}

$alert = ["alert" => fh_alerts("Please wait, We are redirecting you to PayPal!", "success"), "type" => "success"];
$alert['url'] = $payment->getApprovalLink();
echo json_encode($alert);

exit(1);
