<?php


include __DIR__ . "/configs.php";

if(!isset($_SERVER['HTTP_REFERER'])){
	echo '<meta http-equiv="refresh" content="0;url='.path.'">';
	exit;
}

$alert = [];

switch ($pg) {
	case 'addtocart'      : include __DIR__ . "/ajax/addtocart.php"; break;
	case 'getmodalitem'   : include __DIR__ . "/ajax/getmodalitem.php"; break;
	case 'sendpaypalitem' : include __DIR__ . "/ajax/sendpaypalitem.php"; break;
	case 'sendpaypalplan' : include __DIR__ . "/ajax/sendpaypalplan.php"; break;
	case 'sendplans'      : include __DIR__ . "/ajax/sendplans.php"; break;
	case 'sendrestaurant' : include __DIR__ . "/ajax/sendrestaurant.php"; break;
	case 'sendcuisine'    : include __DIR__ . "/ajax/sendcuisine.php"; break;
	case 'sendmenu'       : include __DIR__ . "/ajax/sendmenu.php"; break;
	case 'senditem'       : include __DIR__ . "/ajax/senditem.php"; break;
	case 'imageupload'    : include __DIR__ . "/ajax/imageupload.php"; break;
	case 'multiupload'    : include __DIR__ . "/ajax/multiupload.php"; break;

	case 'login'          : include __DIR__ . "/ajax/sendsignin.php"; break;
	case 'sendsignup'     : include __DIR__ . "/ajax/sendsignup.php"; break;

	case 'senduserdetails': include __DIR__ . "/ajax/senduserdetails.php"; break;
	case 'sendpassword'   : include __DIR__ . "/ajax/sendpassword.php"; break;
	case 'sendreview'     : include __DIR__ . "/ajax/sendreview.php"; break;


	case 'sendsettings'   : include __DIR__ . "/ajax/sendsettings.php"; break;
	case 'sendpage'       : include __DIR__ . "/ajax/sendpage.php"; break;


	case 'logout':
		if($_SERVER['REQUEST_METHOD'] === 'POST' && us_level){
			session_destroy();
			unset($_COOKIE['login_keep']);
			setcookie('login_keep', null, -1);
		}
	break;


	case 'sendwithdraw':
		if($_SERVER['REQUEST_METHOD'] === 'POST' && us_level){
			$amount = isset($_POST['amount']) ? sc_sec($_POST['amount']) : '';
			$email  = isset($_POST['email']) ? sc_sec($_POST['email']) : '';
			if(!sc_check_email($email)){
				$alert = [
					'type'  =>'danger',
					'alert' => fh_alerts($lang['signup']['alert']['check_email'])
				];
			} elseif(!$amount || us_balance < $amount){
				$alert = ["alert" => fh_alerts($lang['alerts']['withdraw_amount'], "danger"), "type" => "danger"];
			} else {
				db_insert("withdraws", ["email" => $email, "created_at" => time(), "price" => $amount, "author" => us_id]);
				db_update("users", ["balance" => us_balance - $amount], us_id);
				$alert = ["alert" => fh_alerts($lang['alerts']['alldone'], "success"), "type" => "success"];
			}
			echo json_encode($alert);
		}
	break;

	case 'withdraw':
		if(us_level==6){
			$request = ( $request == "accept" ? 1 : 2 );
			db_update("withdraws", ["status" => $request, "accepted_at" => time()], $id);
			$alert = ["alert" => fh_alerts($lang['alerts']['alldone'], "success"), "type" => "success"];
			echo json_encode($alert);
		}
	break;

	case 'itemhome':
		if(us_level==6){
			$request = ( $request == "accept" ? 1 : 2 );
			db_update("items", ["home" => 1], $id);
			$alert = ["alert" => fh_alerts($lang['alerts']['alldone'], "success"), "type" => "success"];
			echo json_encode($alert);
		}
	break;

	case 'search':
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			$searsh = sc_sec($_POST["search"]);
		 	$aa = '';
		 	$sql = $db->query("SELECT * FROM ".prefix."items WHERE name LIKE '%{$searsh}%'");
		 	$aa .='<ul class="pt-drop">';
			if(!empty($searsh)) {
			 	if($sql->num_rows){
				 	while($rs=$sql->fetch_assoc()){
					 	$aa .= "<li><a href='".path."/restaurants.php?id=".$rs['restaurant']."&t=".fh_seoURL(db_get("restaurants", "name", $rs['restaurant']))."'>{$rs['name']}</a></li>";
				 	}
				} else {
					$aa .= "<li>{$lang['alerts']['no-data']}</li>";
				}
			} else {
				$aa .= "<li>{$lang['alerts']['no-data']}</li>";
			}
			$aa .='</ul>';
			 echo $aa;
		}
	break;

	case 'lang':
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$id = isset($_POST['id'])?sc_sec($_POST['id']):'';
		$alert = ['type'  =>'success'];

		setcookie( "lang" , $id, time()+3600*24*30*6 );
		echo json_encode($alert);
	}
	break;

	case 'sendsubscribe':
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			$email = isset($_POST['email']) ? sc_sec($_POST['email']) : '';
			if(!sc_check_email($email)){
				$alert = [
					'type'  =>'danger',
					'alert' => fh_alerts($lang['signup']['alert']['check_email'])
				];
			} elseif(db_rows("subscribers WHERE email = '{$email}'")){
				$alert = ["alert" => fh_alerts($lang['signup']['alert']['exist_email'], "danger"), "type" => "danger"];
			} else {
				db_insert("subscribers", ["email" => $email, "created_at" => time()]);
				$alert = ["alert" => fh_alerts($lang['alerts']['alldone'], "success"), "type" => "success"];
			}
			echo json_encode($alert);
		}
	break;

	case 'sendtestimonial':
		if( us_level || !db_rows("testimonials WHERE author = '".us_id."'") ){
			$testimonial = isset($_POST['testimonial']) ? sc_sec($_POST['testimonial'])   : '';
			if(!empty($testimonial)){
				db_insert("testimonials",[
					"created_at" => time(),
					"author"     => us_id,
					'content'    => $testimonial
				]);
				$alert = ["alert" => fh_alerts($lang['alerts']['alldone'], "success"), "type" => "success"];
			} else {
				$alert = ["alert" => fh_alerts($lang['alerts']['required']), "type" => "danger"];
			}
			echo json_encode($alert);
		}
	break;

	case 'editmenu':
		if( us_level == 6 || db_rows("menus WHERE id = '{$id}' && author = '".us_id."'") ){
			echo json_encode(db_rs("menus WHERE id = '{$id}'"));
		}
	break;

	case 'editcuisine':
		if( us_level == 6 ){
			echo json_encode(db_rs("cuisines WHERE id = '{$id}'"));
		}
	break;

	case 'delete':
		if($request == 'menu') $request = 'menus';
		elseif($request == 'item') $request = 'items';
		elseif($request == 'testimonial') $request = 'testimonials';
		elseif($request == 'page') $request = 'pages';
		elseif($request == 'user') $request = 'users';
		elseif($request == 'cuisine') $request = 'cuisines';
		elseif($request == 'restaurant') $request = 'restaurants';
		else $request = '';

		if( $request && (us_level == 6 || db_rows("{$request} WHERE id = '{$id}' && author = '".us_id."'")) ){
			db_delete($request, $id);
			echo true;
		}
	break;

	case 'orderstatus':
		if( us_level && db_rows("orders WHERE id = '{$id}' && (user = '".us_id."' || author = '".us_id."')") ){
			$status = $request == 'intheway' ? 1 : 2;
			$datee  = $request == 'intheway' ? 'shipping_date' : 'delivery_date';
			db_update("orders",   ['status' => $status, $datee => time() ], $id);


			$s_type  = $request == 'intheway' ? 'shipped' : 'delivered';

			$s_itemname   = db_get("items", "name", db_get("orders", "item", $id));
			$s_email      = db_get("users", "email", db_get("orders", "author", $id));
			$s_username   = db_get("users", "username", db_get("orders", "author", $id));

			$mail->addAddress($s_email, $s_username);
			$mail->isHTML(true);
			$mail->Subject = site_title.' '.$lang['email'][$s_type];
			$mail->Body    = fh_send_email($s_username, $s_email, path."/myorders.php", $s_itemname, $s_type);
			if( $mail->send() ){
				$alert = [
					'type'  =>'success',
					'alert' => fh_alerts("Send succesfully.", 'success')
				];
				echo json_encode($alert);
			} else {
				$alert = [
					'type'  =>'danger',
					'alert' => fh_alerts($lang['alerts']['wrong'])
				];
				echo json_encode($alert);
			}
		}
	break;

	case 'testimonialstatus':
		if( us_level == 6 ){
			$status = $request == 'publish' ? 1 : 0;
			db_update("testimonials",   ['status' => $status], $id);
		}
	break;

	case 'cartquantitychange':
		$item_id = (int)($_POST['item_id']);
		$item_aid = (int)($_POST['item_aid']);
		$item_qnt = (int)($_POST['qnt']);
		$cookie_arr = json_decode($_COOKIE['addtocart'], true);
		$data = json_decode($cookie_arr[$item_aid][$item_id], true);
		$data['item_quantities'] = $item_qnt;
		$cookie_arr[$item_aid][$item_id] = json_encode($data);
		setcookie("addtocart", json_encode($cookie_arr), time() + (86400 * 365));
	break;

	case 'cartremoveextra':
		$extra_cart = (int)($_POST['extra_cart']);
		$extra_item = (int)($_POST['extra_item']);
		$extra_id = (int)($_POST['extra_id']);
		$cookie_arr = json_decode($_COOKIE['addtocart'], true);
		$data = json_decode($cookie_arr[$extra_cart][$extra_item], true);
		unset($data['item_extra'][$extra_id]);
		$cookie_arr[$extra_cart][$extra_item] = json_encode($data);
		setcookie("addtocart", json_encode($cookie_arr), time() + (86400 * 365));
	break;

	case 'cartremoveitem':
		$extra_cart = (int)($_POST['extra_cart']);
		$extra_item = (int)($_POST['extra_item']);
		$cookie_arr = json_decode($_COOKIE['addtocart'], true);
		unset($cookie_arr[$extra_cart][$extra_item]);
		setcookie("addtocart", json_encode($cookie_arr), time() + (86400 * 365));
	break;

	case 'orders-os':
	case 'orders-devices':
	case 'orders-cpgender':

		if($pg == "orders-os") $varr = 'os';
		elseif($pg == "orders-devices") $varr = 'device';
		elseif($pg == "orders-cpgender") $varr = 'gender';

		if($pg == "orders-cpgender") $varrr = "";
		else $varrr = "WHERE user = '".us_id."'";

		$aa = ["data" => [], "labels" => [], "colors" => [], "title" => ""];

		$sql = $db->query("SELECT {$varr}, count(id) AS co FROM ".prefix."orders {$varrr} GROUP BY {$varr}");
		if($sql->num_rows){
			while ($rs = $sql->fetch_assoc()) {
				$aa['data'][] = $rs['co'];
				if($pg == "orders-cpgender") $aa['labels'][] = empty($rs[$varr]) ? $lang['unknown'] : ($rs[$varr] == 1 ? 'Male' : 'Female');
				else $aa['labels'][] = empty($rs[$varr]) ? $lang['unknown'] : $rs[$varr];

				$colors = randomColor();
				$aa['colors'][] = "#".$colors['hex'];
			}
		}
		$aa['title'] = "";

		echo json_encode($aa);
	break;

	case 'orders-cporders':
		$aa = [];
		if($request == "days"){
			$start    = new DateTime('now');
			$end      = new DateTime('- 7 day');
			$diff     = $end->diff($start);
			$interval = DateInterval::createFromDateString('-1 day');
			$period   = new DatePeriod($start, $interval, $diff->days);

			foreach ($period as $date) {
				$aa['data'][] = db_rows("orders WHERE FROM_UNIXTIME(created_at,'%m-%d-%Y') = '".$date->format('m-d-Y')."'");
				$aa['labels'][] = $date->format('M d');
			}

		  $aa['data'] = array_reverse($aa['data']);
		  $aa['labels'] = array_reverse($aa['labels']);
		  $aa['title'] = $lang['dash']['ordersdays'];
		} elseif($request == "months"){
			$aa = [];
			for ($i=1; $i <=12 ; $i++) {
				$aa['data'][] = db_rows("orders WHERE MONTH(FROM_UNIXTIME(created_at)) = '{$i}' GROUP BY id");
				$aa['labels'][] = date('F', mktime(0, 0, 0, $i, 10));
			}

		  $aa['title'] = $lang['dash']['ordersdays'];
		}

		echo json_encode($aa);
	break;

}
