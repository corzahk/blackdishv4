<?php

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

$data = [];
foreach ($_POST as $key => $value) {
	if(in_array($key, ['name', 'email', 'phone', 'address', 'city', 'state', 'postal_code', 'country', 'gender']))
		$data[$key] = sc_sec($value);
}

if ( fh_empty($data['name'], $data['email'], $data['address'], $data['city'], $data['state'], $data['postal_code'], $data['country'], $data['gender']) ) {
	$alert = ["alert" => fh_alerts("All inputs are required!"), "type" => "danger"];
	echo json_encode($alert);
	exit;
}

setcookie("belling_info", json_encode($data), time() + (86400 * 365));


$payer = new Payer();
$payer->setPaymentMethod('paypal');


$itm_arr = [];
$itm_totalprice = 0;
$itm_shippingprice = 0;
$itm_taxes = 0;
if(isset($_COOKIE['addtocart'])):
 foreach(json_decode($_COOKIE['addtocart'], true) as $cart_id => $carts):
 	foreach($carts as $it_id => $cart):
 		if(!empty(str_replace('[]','', $cart))):
 			$cart = json_decode($cart, true);
 			$sql = $db->query("SELECT * FROM ".prefix."items WHERE id = '{$cart_id}'");
 			$rs = $sql->fetch_assoc();
 			$sql->close();

 			$item_size = isset($cart['item_size']) ? db_unserialize([$rs['sizes'], $cart['item_size']]) : '';

 			$itm_name  = $rs['name'];
 			$itm_qnt   = $cart['item_quantities'];
 			$itm_price = (float)($item_size ? $item_size['price'] : $rs['selling_price']);
 			$itm_size  = ($item_size ? " ({$item_size['name']})" : '');

 			$item01 = new Item();
 			$item01->setName("{$itm_name}{$itm_size}")->setCurrency(dollar_name)->setQuantity($itm_qnt)->setSku(rand())->setPrice($itm_price);

 			$itm_arr[] = $item01;
			$itm_totalprice += $itm_price*$itm_qnt;
			$itm_shippingprice += $rs['delivery_price'];

			if($cart['item_extra']):
 			foreach($cart['item_extra'] as $k => $extra):
 				$extra = db_unserialize([$rs['extra'], $extra]);
				$item02 = new Item();
	 			$item02->setName("Extra: {$extra['name']}")->setCurrency(dollar_name)->setQuantity($itm_qnt)->setSku(rand())->setPrice($extra['price']);
				$itm_arr[] = $item02;
				$itm_totalprice += $extra['price']*$itm_qnt;
 			endforeach;
 			endif;

 		endif;
 	endforeach;
 endforeach;
endif;


$itemList = new ItemList();
$itemList->setItems($itm_arr);

$details = new Details();
$details->setShipping($itm_shippingprice)->setTax($itm_taxes)->setSubtotal($itm_totalprice);

$itm_setTotalprice = $itm_totalprice+($itm_taxes)+($itm_shippingprice);


$amount = new Amount();
$amount->setCurrency(dollar_name)->setTotal($itm_setTotalprice)->setDetails($details);

$transaction = new Transaction();
$transaction->setAmount($amount)->setItemList($itemList)->setDescription("Payment description")->setInvoiceNumber(uniqid());

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl($paypalConfig['return_url'])->setCancelUrl($paypalConfig['cancel_url']);

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
