<?php

include __DIR__."/header.php";

$data = [];
foreach ($_POST as $key => $value) {
	if(in_array($key, ['name', 'email', 'phone', 'address', 'city', 'state', 'postal_code', 'country', 'gender']))
		$data[$key] = sc_sec($value);
}

$amount = (float)($_POST['amount']);

if ( fh_empty($data['name'], $data['email'], $data['address'], $data['city'], $data['state'], $data['postal_code'], $data['country'], $data['gender'], $amount) ) {
	echo fh_alerts("All inputs are required!".$amount, "danger", path."/cart.php", 4);
	include __DIR__."/footer.php";
	exit;
}

if (empty($_POST['stripeToken'])) {
	echo fh_alerts("The response is missing the payments id!", "danger", path."/index.php", 2);
	include __DIR__."/footer.php";
	exit;
}


$stripeSecret = site_stripe_secret;
\Stripe\Stripe::setApiKey($stripeSecret);


$token       = sc_sec($_POST['stripeToken']);
$amount      = $amount*100;
$currency    = dollar_name;
$description = stripslashes(html_entity_decode(sc_cookie($_COOKIE['addtocart'])));
$api_error   = "";


try {
	$charge = \Stripe\Charge::create(array(
		'amount'      => $amount,
		'currency'    => $currency,
		'description' => $description,
    'source'      => $token
	));
} catch(Exception $e) {
	$api_error = $e->getMessage();
}


if(empty($api_error) && $charge){

	$chargeJson = $charge->jsonSerialize();

	if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){
			$transactionID  = $chargeJson['balance_transaction'];
			$paidAmount     = $chargeJson['amount'];
			$paidAmount     = ($paidAmount/100);
			$paidCurrency   = $chargeJson['currency'];
			$payment_status = $chargeJson['status'];

			$billing_info = json_encode($data);


			$data = [
				'transaction_id' => $transactionID,
				'payment_amount' => $paidAmount,
				'payment_status' => $payment_status,
				'invoice_id'     => $token,
				'created_at'     => time(),
				'billing_info'   => $billing_info,
				'gender'         => $data['gender'],
				'author'         => us_id,
				'ip'             => get_ip,
				'os'             => get_os,
				'browser'        => get_browser,
				'device'         => get_device,
				'country_name'   => get_country_name,
				'country_code'   => get_country_code,
				'state'          => get_state,
				'city_name'      => get_city_name
			];

			if($payment_status != 'succeeded'){
				echo '<div id="loading">'.fh_alerts($lang['alerts']['wrong'], "danger", path."/index.php", 2).'</div>';
				include __DIR__."/footer.php";
				exit(1);
			}


			$data_order_price = 0;
			foreach (json_decode($_COOKIE['addtocart'], true) as $key => $value) {
				foreach ($value as $k => $v) {
					$data['order_cart'] = sc_cookie($v);
					$data_order_cart    = json_decode($data['order_cart'], true);
					$data_order_price   += $data_order_cart['item_price'] * $data_order_cart['item_quantities'] + (float)($data_order_cart['item_delivery']);

					if($data_order_cart['item_extra']){
						foreach($data_order_cart['item_extra'] as $k => $extra){
							$extra            = db_unserialize([db_get("items", "extra", $key), $extra]);
							$item_extra_price = $extra['price'] * $data_order_cart['item_quantities'];
							$data_order_price += $item_extra_price;
						}
					}


					$data['item'] = $key;
					$data['restaurant'] = db_get("items", "restaurant", $key);
					$data['user']       = db_get("restaurants", "author", $data['restaurant']);
					if(!db_rows("orders WHERE transaction_id = '{$data['transaction_id']}' && order_cart = '{$data['order_cart']}'")){

						db_insert("orders", $data);

						$taxes = (taxes/100)*$data_order_price;

						$data_taxes = [
							"taxes"      => $taxes,
							'created_at' => time(),
							"order_id"   => db_get("orders", "id", "author", us_id, "&& transaction_id = '{$data['transaction_id']}' && order_cart = '{$data['order_cart']}'"),
						];

						$data_order_price = $data_order_price-$taxes;

						db_insert("taxes", $data_taxes);
						db_update("users", ['balance' => (db_get("users", "balance", $data['user']) + $data_order_price)], $data['user']);

					}
					$data_order_price = 0;

					/* SEND NOTIFICATION TO restaurant */

					$s_itemname   = db_get("items", "name", $key);
					$s_email      = db_get("users", "email", $data['user']);
					$s_username   = db_get("users", "username", $data['user']);

					$mail->addAddress($s_email, $s_username);
					$mail->isHTML(true);
					$mail->Subject = $lang['email']['paid_t'].' '.$s_itemname;
					$mail->Body    = fh_send_email($s_username, $s_email, path."/restaurant.php?pg=orders", $s_itemname, "paid");
					if( $mail->send() ){
						$alert = [
							'type'  =>'success',
							'alert' => fh_alerts("Send succesfully.", 'success')
						];
					} else {
						$alert = [
							'type'  =>'danger',
							'alert' => fh_alerts($lang['alerts']['wrong'])
						];
					}
				}
			}

			echo '<div id="loading">'.fh_alerts($lang['alerts']['payment'], "success", path."/index.php?pg=ordersuccess", 3).'</div>';


	}

}
