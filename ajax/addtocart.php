<?php


if( $_SERVER['REQUEST_METHOD'] === 'POST' ){

	$p_id         = isset($_POST['item_id']) ? (int)($_POST['item_id'])                 : 0;
	$p_size       = isset($_POST['item_size']) ? (int)($_POST['item_size'])             : 0;
	$p_quantities = isset($_POST['item_quantities']) ? (int)($_POST['item_quantities']) : 0;
	$p_note       = isset($_POST['item_note']) ? sc_sec($_POST['item_note'])            : '';
	$p_extra      = isset($_POST['item_extra']) ? sc_array($_POST['item_extra'], 'int') : 0;

	$item_size = isset($p_size) ? db_unserialize([db_get("items", "sizes", $p_id), $p_size]) : '';

	if(!fh_access("orders")){
		$alert = ["alert" => fh_alerts($lang['alerts']['noorders']), "type" => "danger"];
		echo json_encode($alert);
		exit;
	}

	if(!$p_id || !$p_quantities){
		$alert = ["alert" => fh_alerts($lang['alerts']['cartquantity']), "type" => "danger"];
	} else {

		$data = [
			"item_id"         => $p_id,
			"item_size"       => $p_size,
			"item_quantities" => $p_quantities,
			"item_note"       => $p_note,
			"item_extra"      => $p_extra,
			"item_price"      => $p_size ? $item_size['price'] : db_get("items", "selling_price", $p_id),
			"item_delivery"   => db_get("items", "delivery_price", $p_id)
		];

		$cookie_data = [];

		function in_array_r($needle, $haystack, $strict = false) {
	    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
          return true;
        }
	    }
	    return false;
		}

		if( !isset($_COOKIE["addtocart"]) ) {
			$cookie_data[$p_id][] = json_encode($data);
			setcookie("addtocart", json_encode($cookie_data), time() + (86400 * 365));
		} else {
			$cookie_data = json_decode($_COOKIE["addtocart"], true);
			if(!in_array_r(str_replace(" ", "+",json_encode($data)), $cookie_data)){
				$cookie_data[$p_id][] = json_encode($data);
			}
			setcookie("addtocart", json_encode($cookie_data), time() + (86400 * 365));
			$alert['dd'] = print_r($cookie_data,true);
		}

		$alert = ["alert" => fh_alerts($lang['alerts']['cartsuccess'], "success"), "type" => "success"];

	}

	echo json_encode($alert);
}
