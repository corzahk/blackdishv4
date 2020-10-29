<?php


use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

include __DIR__."/header.php";

$paymentId = isset($_GET['paymentId']) ? sc_sec($_GET['paymentId']) : '';
$payerID   = isset($_GET['PayerID']) ? sc_sec($_GET['PayerID']) : '';
$token     = isset($_GET['token']) ? sc_sec($_GET['token']) : '';

if (empty($paymentId) || empty($payerID)) {
	echo fh_alerts("The response is missing the payments id!", "danger", path."/index.php", 2);
	include __DIR__."/footer.php";
	exit;
}


$payment   = Payment::get($paymentId, $apiContext);

$execution = new PaymentExecution();
$execution->setPayerId(sc_sec($_GET['PayerID']));

try {
    $payment->execute($execution, $apiContext);

    try {
        $payment = Payment::get($paymentId, $apiContext);


				$pp        = $payment->getTransactions();
				$pp_amount = $pp[0]->amount->total;
				$pp_status = $pp[0]->related_resources[0]->sale->state;

				if(db_rows("plans WHERE price = {$pp_amount}")){
					$get_plan = db_rs("plans WHERE price = {$pp_amount}");
					db_update("users", ["plan" => $get_plan['id'], "lastpayment" => time()], us_id);

					db_insert("payments", [
						"plan"       => $get_plan['id'],
						"payment_id" => $paymentId,
						"payer_id"   => $payerID,
						"token"      => $token,
						"price"      => $pp_amount,
						"date"       => time(),
						"author"     => us_id,
						"status"     => $pp_status,
					]);

					echo '<div id="loading">'.fh_alerts($lang['alerts']['payment'], "success", path."/index.php", 3).'</div>';
				}


    } catch (Exception $e) {
			echo $lang['alerts']['payment_f'];
    }

} catch (Exception $e) {
	echo '<div id="loading">'.fh_alerts("Failed to take payment", "danger", path."/index.php", 3).'</div>';
}

include __DIR__."/footer.php";
