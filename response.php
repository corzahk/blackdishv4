<?php


use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

include __DIR__."/header.php";

if (empty($_GET['paymentId']) || empty($_GET['PayerID'])) {
	echo fh_alerts("The response is missing the payments id!", "danger", path."/index.php", 2);
	include __DIR__."/footer.php";
	exit;
}


$paymentId = sc_sec($_GET['paymentId']);
$payment   = Payment::get($paymentId, $apiContext);

$execution = new PaymentExecution();
$execution->setPayerId(sc_sec($_GET['PayerID']));

try {
    $payment->execute($execution, $apiContext);

    try {
        $payment = Payment::get($paymentId, $apiContext);

				$billing_info = isset($_COOKIE['belling_info']) ? sc_cookie($_COOKIE['belling_info']) : '';
				$gender       = json_decode($billing_info, true);
				$data = [
          'transaction_id' => $payment->getId(),
          'payment_amount' => $payment->transactions[0]->amount->total,
          'payment_status' => $payment->getState(),
          'invoice_id'     => $payment->transactions[0]->invoice_number,
					'created_at'     => time(),
					'billing_info'   => $billing_info,
					'gender'         => $gender['gender'],
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


				$billing_info = json_decode($billing_info, true);
				$billing_info['name'] = explode("+", $billing_info['name']);

				$data_u              = [];
				$data_u["city"]      = us_city ? us_city : str_replace("+", " ", $billing_info['city']);
				$data_u["country"]   = us_country ? us_country : str_replace("+", " ", $billing_info['country']);
				$data_u["state"]     = us_state ? us_state : str_replace("+", " ", $billing_info['state']);
				$data_u["phone"]     = us_phone ? us_phone : str_replace("+", " ", $billing_info['phone']);
				$data_u["address"]   = us_address ? us_address : str_replace("+", " ", $billing_info['address']);
				$data_u["firstname"] = us_firstname ? us_firstname : $billing_info['name'][0];
				$data_u["lastname"]  = us_lastname ? us_lastname : $billing_info['name'][1];


				if ($data['payment_status'] !== 'approved') {
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



				db_update("users", $data_u, us_id);

				echo '<div id="loading">'.fh_alerts($lang['alerts']['payment'], "success", path."/index.php?pg=ordersuccess", 3).'</div>';

    } catch (Exception $e) {
			echo $lang['alerts']['payment_f'];
    }

} catch (Exception $e) {
	echo "Failed to take payment";
}

include __DIR__."/footer.php";
