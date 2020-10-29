<?php


function db_rows($table, $field = 'id'){
	global $db;
	$sql = $db->query("SELECT {$field} FROM ".prefix."{$table}") or die($db->error);
	$rs  = $sql->num_rows;
	$sql->close();
	return $rs;
}

function db_get($table, $field, $id, $where='id', $other=false){
	global $db;
	$sql = $db->query("SELECT {$field} FROM ".prefix."{$table} WHERE {$where} = '{$id}' {$other}") or die($db->error);
	if($sql->num_rows > 0){
		$rs = $sql->fetch_row();
		$sql->close();
		return $rs[0];
	}
}

function db_insert($table, $array) {
	global $db;
	$columns = implode(',', array_keys($array));
	$values  = "'" . implode("','", array_values($array)) . "'";
	$query   = "INSERT INTO ".prefix."{$table} ({$columns}) VALUES ({$values})";
	return $db->query($query) or die($db->error);
}

function db_update($table, $array, $id, $id_col = 'id', $other = '') {
	global $db;
	$columns = array_keys($array);
	$values  = array_values($array);
	$count   = count($columns);

	$update  = '';
	for($i=0;$i<$count;$i++)
		$update .= "{$columns[$i]} = '{$values[$i]}'" . ($count == $i+1 ? '' : ', ');

	$query   = "UPDATE ".prefix."{$table} SET {$update} WHERE {$id_col} = '{$id}' {$other}";
	return $db->query($query) or die($db->error);
}

function db_delete($table, $id, $id_col = 'id', $more = '') {
	global $db;
	$query = "DELETE FROM ".prefix."{$table} WHERE {$id_col} = '{$id}' {$more}";
	return $db->query($query) or die($db->error);
}

function db_rs($data) {
	global $db;
	$sql = $db->query("SELECT * FROM ".prefix.$data);
	$rs  = $sql->num_rows ? $sql->fetch_assoc() : '';
	$sql->close();
	return $rs;
}

function db_global(){
	global $db;
	$sql = $db->query("SELECT * FROM ".prefix."configs") or die($db->error);
	if($sql){
		while( $rs = $sql->fetch_assoc() )
			define( $rs['variable'], $rs['value'] );

		$sql->close();
	}
}

function db_update_global($var, $val){
	return db_update("configs", ['value' => "{$val}"], $var, 'variable');
}

function db_login_details(){
	global $db;
	$log_session = ( isset($_SESSION['login']) ? (int)$_SESSION['login'] : ( isset($_COOKIE['login']) ? (int)$_COOKIE['login'] : 0 ) );

  if( isset($log_session) && $log_session != 0 ){
   $sql = $db->query( "SELECT * FROM ".prefix."users WHERE id = '{$log_session}'" ) or die($db->error);
   $rs  = $sql->fetch_assoc();
   foreach ( $rs as $key => $val )
         define( 'us_'. $key, $val);

   $sql->close();
  } else {
      $sql = $db->query( "DESCRIBE ".prefix."users" ) or die($db->error);
			while( $rs = $sql->fetch_assoc() ){
				define( 'us_' . $rs['Field'], (in_array(str_replace(' unsigned', '', $rs['Type']), ['tinyint(1)','int(11)','int(10)']) ? 0 : ''));
			}

      $sql->close();
  }
}

function db_unserialize($data){
	if($data){
		$uns = unserialize($data[0]);
		return $uns ? $uns[$data[1]] : 0;
	} else {
		return 0;
	}
}

function db_serialize_update($data){
	if($data){
		$uns = unserialize($data[0]);
		$uns[$data[1]] = $data[2];
		return serialize($uns);
	} else {
		return 0;
	}
}







function sc_check_email($email){
	$address = strtolower(trim($email));
	return (preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",$address));
}

function sc_pass($data) {
	return sha1($data);
}

function strip_tags_content($text, $tags = '', $invert = FALSE){
    preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
    $tags = array_unique($tags[1]);

    if(is_array($tags) AND count($tags) > 0) {
        if($invert == FALSE) {
            return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
        } else {
            return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
        }
    } elseif($invert == FALSE) {
        return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
    }
    return $text;
}

function sc_sec($data, $html = false) {
	global $db;
	if(gettype($data) == "array")
		return sc_array($data);
	$post = $db->real_escape_string($data);
	$post = trim($post);
	$post = ($html) ? htmlspecialchars($post) : htmlspecialchars(strip_tags_content($post));
	return $post;
}

function sc_array($data, $dataType = 'char'){
	$array = array();
	$data  = array_filter($data);
  if(count($data)){
    foreach( $data AS $k => $d )
      $array[$k] = $dataType == 'int' ? (int)($d) : sc_sec($d);
  }
	return $array;
}

function sc_cookie($cook){
	$cook = json_decode($cook, true);
	$data = [];
	foreach ($cook as $key => $value) {
		$data[$key] = sc_sec($value);
	}
	return json_encode($data);
}

function sc_folderName ($str = ''){
  $str = strip_tags($str);
  $str = preg_replace('/[\r\n\t ]+/', ' ', $str);
  $str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);
  $str = strtolower($str);
  $str = html_entity_decode( $str, ENT_QUOTES, "utf-8" );
  $str = htmlentities($str, ENT_QUOTES, "utf-8");
  $str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
  $str = str_replace(' ', '-', $str);
  $str = rawurlencode($str);
  $str = str_replace('%', '-', $str);
  return $str;
}




function fh_cp_amount($table, $column, $other = ''){
	global $db;
	$sql = $db->query("SELECT $column FROM ".prefix.$table." ".$other);
	$amount = 0;
	while ($rs = $sql->fetch_assoc()) {
		$amount += $rs[$column];
	}
	return dollar_sign.number_format((float)$amount, 2, '.', '');
}

function fh_send_email( $name, $email, $order_link, $order_title, $type ){
	global $lang;

	return '<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F4F5F5">
		<tbody>
			<tr>
				<td style="border-collapse:collapse" width="600" bgcolor="#F4F5F5" valign="top" align="center">
				<table width="600" border="0" cellpadding="0" cellspacing="0">
					<tbody><tr><td style="border-collapse:collapse" width="219" height="70" bgcolor="#F4F5F5" align="left" valign="middle"><a href="" target="_blank"><img style="outline:none;text-decoration:none;color:#40a9a8" src="'.path.'/'.site_logo.'" height="70" border="0"></a></td></tr></tbody>
				</table>
			<table width="600" border="0" cellpadding="0" cellspacing="0"><tbody><tr><td style="border-collapse:collapse" width="600" height="15" bgcolor="#ff9f0e"></td></tr></tbody></table>
			<table width="600" border="0" cellpadding="0" cellspacing="0">
				<tbody>
					<tr><td colspan="3" style="border-collapse:collapse" width="600" height="35" bgcolor="#FFFFFF"></td></tr>
					<tr>
						<td style="border-collapse:collapse" width="40" height="3" bgcolor="#FFFFFF"></td>
						<td style="border-collapse:collapse;line-height:24px" width="520" height="3" align="left" valign="top" bgcolor="#FFFFFF">
							<font style="text-decoration:none;color:#333e48;font-size:16px;font-weight:400;font-family:helvetica,arial,sans-serif">
								<p><b>'.$lang['email']["{$type}"].'</b> <br></p>
								<p>'.str_replace("{n}", $name, $lang['email']['hi']).'</p>
								<p>'.str_replace("{o}", '<a href="'.$order_link.'" target="_blank" style="color: #ff9f0e;">'.$order_title.'</a>', $lang['email']["{$type}_msg"]).'</p>
								<p><a href="'.$order_link.'" target="_blank" style="background: #ff9f0e;color: #FFF;font-size: 18px;padding: 8px 16px;display: inline-block;text-decoration:none;font-weight:bold;">'.$lang['email']['go'].'</a></p>
								<p>'.str_replace("{l}", '<a href="'.path.'/pages.php?id=2&contact" style="color: #ff9f0e;" target="_blank">'.$lang['email']['let'].'</a>', $lang['email']['contact']).'</p><br>
							</font>
					</td>
					<td style="border-collapse:collapse" width="40" height="3" bgcolor="#FFFFFF"></td>
				</tr>
				</tbody>
			</table>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F4F5F5">
				<tbody>
					<tr>
					<td style="border-collapse:collapse" width="50%" bgcolor="#F4F5F5">&nbsp;</td>
					<td style="border-collapse:collapse" width="600" bgcolor="#F4F5F5" valign="top" align="center">
						<table width="530" border="0" cellpadding="0" cellspacing="0" bgcolor="#F4F5F5">
							<tbody>
								<tr><td style="border-collapse:collapse" width="530" height="20" bgcolor="#F4F5F5"></td></tr>
								<tr>
									<td style="border-collapse:collapse" width="530" height="2" bgcolor="#F4F5F5" valign="top" align="left">
										<font style="text-decoration:none;color:#a7a7a7;font-size:13px;font-family:helvetica,arial,sans-serif">
											'.str_replace(["{e}","{s}"], ['<a href="mailto:'.$email.'" target="_blank">'.$email.'</a>',site_title], $lang['email']['footer']).'
											<br><br>
											© 2020 '.site_title.'
										</font>
										<br><br>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
					<td style="border-collapse:collapse" width="50%" bgcolor="#F4F5F5">&nbsp;</td>
				</tr>
			</tbody>
			</table>
			</td>
		</tr>
	</tbody>
	</table>';
}

function fh_social_login( $socialname, $profile ){
	global $lang, $db;

	switch($socialname){
		case 'facebook':
			$socialid  = $profile['id'];
			$username  = $profile['name'];
			$firstname = $profile['first_name'];
			$lastname  = $profile['last_name'];
			$email     = $profile['email'];
			$photo     = $profile['picture']['url'];
			$description  = '';
		break;
		case 'google':
			$socialid  = $profile['id'];
			$username  = $profile['name'];
			$firstname = $profile['given_name'];
			$lastname  = $profile['family_name'];
			$email     = $profile['email'];
			$photo     = $profile['picture'];
			$description  = '';
		break;
		case 'twitter':
			$socialid  = $profile->id;
			$username  = $profile->name;
			$firstname = '';
			$lastname  = '';
			$email     = 'no email address';
			$photo     = $profile->profile_image_url;
			$description  = $profile->description;
		break;
	}


	if(db_rows("users WHERE username = '{$username}' || email = '{$email}'")){
		$sql = $db->query("SELECT id, moderat FROM ".prefix."users WHERE (username = '{$username}' || email = '{$email}') && social_name = '{$socialname}' && social_id = '{$socialid}'");
		if($sql->num_rows){
			$rs = $sql->fetch_assoc();
			$_SESSION['login']  = $rs['id'];
			db_update('users', ["photo"=> $photo], $rs['id']);
			echo "<div class='padding'>".fh_alerts($lang['login']['alert']['success'], "success", path."/index.php")."</div>";
		} else {
			echo "<div class='padding'>".fh_alerts($lang['login']['alert']['social'], "danger", path."/index.php")."</div>";
		}
	} else {
		db_insert('users', [
			"username"    => $username,
			"firstname"   => $firstname,
			"lastname"    => $lastname,
			"email"       => $email,
			"social_id"   => $socialid,
			"social_name" => $socialname,
			"photo"       => $photo,
			"date"        => time(),
			"level"       => 1
		]);
		$_SESSION['login']  = db_get('users', 'id', $username, 'username', "&& social_name = '{$socialname}' && social_id = '{$socialid}'");
		echo "<div class='padding'>".fh_alerts($lang['login']['alert']['success'], "success", path."/index.php")."</div>";
	}
}

function fh_go($href = '',$tm = 0){
	echo '<meta http-equiv="refresh" content="'.$tm.'; URL='.$href.'">';
}

function fh_stars($id, $col, $stars = true){
	$total = db_rows("reviews WHERE {$col} = '{$id}'");
	$five  = db_rows("reviews WHERE {$col} = '{$id}' && stars = 5");
	$four  = db_rows("reviews WHERE {$col} = '{$id}' && stars = 4");
	$three = db_rows("reviews WHERE {$col} = '{$id}' && stars = 3");
	$two   = db_rows("reviews WHERE {$col} = '{$id}' && stars = 2");
	$one   = db_rows("reviews WHERE {$col} = '{$id}' && stars = 1");

	$res   = $total ? ($five*5+$four*4+$three*3+$two*2+$one)/($total) : 0;

	if($stars){
		if(in_array($res, [1, 2, 3, 4, 5])) $res = fh_stars_alt($res, (int)(5-$res));
		elseif($res>1&&$res<2) $res = fh_stars_alt(1, 3, true);
		elseif($res>2&&$res<3) $res = fh_stars_alt(2, 2, true);
		elseif($res>3&&$res<4) $res = fh_stars_alt(3, 1, true);
		elseif($res>4&&$res<5) $res = fh_stars_alt(4, 0, true);
		elseif($res>5) $res = fh_stars_alt(5, 0);
		else $res = fh_stars_alt(0, 5);
		$res .= "<b>({$total})</b>";
	}

	return $res;
}

function fh_stars_alt($v1, $v2, $v3=false){
	$res = '';
	for($x=1; $x<=$v1; $x++) $res .= '<i class="fas fa-star"></i>';
	$res .= $v3 ? '<i class="fas fa-star-half-alt"></i>' : '';
	for($x=1; $x<=$v2; $x++) $res .= '<i class="far fa-star"></i>';
	return $res;
}


function fh_order_price($order){
	$rs_order  = db_rs("orders WHERE id = '{$order}'");
	if(!empty($rs_order)){
		$tt_price = 0;
		$cart     = json_decode($rs_order['order_cart'], true);
		$rsi      = db_rs("items WHERE id = '{$cart['item_id']}'");

		$item_size  = isset($cart['item_size']) ? db_unserialize([$rsi['sizes'], $cart['item_size']]) : '';
		$item_price = ($item_size ? $item_size['price'] : $rsi['selling_price']) * $cart['item_quantities'];

		$item_price = isset($cart['item_price']) ? $cart['item_price'] * $cart['item_quantities'] : $item_price;
		$item_delivery = isset($cart['item_delivery']) ? $cart['item_delivery'] : 0;

		$tt_price  += $item_price+(float)($item_delivery);

		if($cart['item_extra']){
			foreach($cart['item_extra'] as $k => $extra){
				$extra            = db_unserialize([$rsi['extra'], $extra]);
				$item_extra_price = $extra['price'] * $cart['item_quantities'];
				$tt_price        += $item_extra_price;
			}
		}
		return $tt_price;
	}
	return 0;
}

function fh_empty(){
  foreach(func_get_args() as $arg){
		if(empty($arg)) return true;
    else continue;
	}
  return false;
}

function fh_seoURL($title){
	$turkish = array("ı", "ğ", "ü", "ş", "ö", "ç");
	$english   = array("i", "g", "u", "s", "o", "c");
	$title = str_replace($turkish, $english, $title);
	$title = strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($title, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));

	return $title;
}

function fh_newImgFolder($folder){
	if(!is_dir($folder)){
		return mkdir($folder, 0777, true);
	} else {
		return 0;
	}
}

function pt_col($col){
	if($col%3 == 0) {
		return "col3";
	} elseif($col%2 == 0) {
		return "col3";
	} else {
		return "col3";
	}
}

function fh_title(){
	global $id;
	$title = '';
	switch (page) {
		case 'survey': $title = db_get("survies", "title", $id).' - '.site_title; break;
		case 'plans': $title = 'Plans - '.site_title; break;
		case 'dashboard': $title = 'Dashboard - '.site_title; break;
		case 'rapport': $title = 'Rapport - '.site_title; break;
		case 'responses': $title = 'Responses - '.site_title; break;
		case 'newsurvey': $title = 'New Survey - '.site_title; break;
		case 'userdetails': $title = 'Details - '.site_title; break;

		default: $title = site_title; break;
	}
	return $title;
}

function fh_access($type) {
	global $db;
	$access = true;
	if(us_level == 6 || site_plans) $access = true;
	else {
		switch ($type) {
			case 'restaurants':
				if(db_rows("restaurants WHERE author = '".us_id."'") >= restaurants)
					$access = false;
			break;
			case 'menus':
				if(db_rows("menus WHERE author = '".us_id."' GROUP BY restaurant") >= menus)
					$access = false;
			break;
			case 'items':
				if(db_rows("items WHERE author = '".us_id."' GROUP BY restaurant") >= menus)
					$access = false;
			break;
			case 'orders':
				if(db_rows("orders WHERE user = '".us_id."' && FROM_UNIXTIME(created_at,'%m-%Y') = '".date('m-Y')."'") >= orders)
					$access = false;
			break;
			case 'statistics':
				if(!statistics)
					$access = false;
			break;
			case 'invoices':
				if(!invoices)
					$access = false;
			break;
		}
	}
	return $access;
}

function fh_user($id, $link = true, $cut = false, $count = 25){
	global $db;
	if(!$id){
		return false;
	}
  $sql = $db->query("SELECT id, username, plan FROM ".prefix."users WHERE id = '{$id}'");
  $rs = $sql->fetch_assoc();
	$color = ( $rs['plan']==1 ? '#00cec9' : ( $rs['plan']==2 ? '#ff7675' : ( $rs['plan']==3 ? '#6c5ce7' : '')));
	$username = $rs['username'];
	return ($link) ? '<a href="#"'.($color?' style="color:'.$color.'"':'').'>'.$username.'</a>' : $username;
}

function fh_alerts($alert, $type = 'danger', $redirect = false, $time = 1, $html = true) {
	global $lang;

	$title = $lang['alerts'][$type];
  return ($html) ? '<div class="alert alert-'.$type.'">
            <strong>'.$title.'</strong> '.$alert.'
          </div>'. ($redirect ? '<meta http-equiv="refresh" content="'.$time.';url='.$redirect.'">' : false) : '<strong>'.$title.'</strong> '.$alert;
}

function randomColor(){
  $result = array('rgb' => '', 'hex' => '');
  foreach(array('r', 'b', 'g') as $col){
    $rand = mt_rand(0, 255);
    $dechex = dechex($rand);
    if(strlen($dechex) < 2){
      $dechex = '0' . $dechex;
    }
    $result['hex'] .= $dechex;
  }
  return $result;
}

function fh_ip(){
  foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
    if (array_key_exists($key, $_SERVER) === true){
    	foreach (explode(',', $_SERVER[$key]) as $ip){
        $ip = trim($ip);

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
          return $ip;
        }
      }
    }
  }
}

function fh_get_num($str) {
  preg_match_all('/\d+/', $str, $matches);
  return $matches[0];
}


function fh_ago($tm = '', $at = true, $rcs = 0) {
	global $lang;
	$cur_tm = time();
	$pr_year = $cur_tm - 3600*24*365;
	$pr_month = $cur_tm - 3600*24*31;
	if( $tm > $pr_month ){
		$dif    = $cur_tm-$tm;
		$pds = array();
		foreach ($lang['timedate'] as $kk){
			$pds[] = $kk;
			if( $kk == 'decade' ) break;
		}

		$lngh   = array(1,60,3600,86400,604800,2630880,31570560,315705600);
		for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);

		$no = floor($no); if($no <> 1 && !$lang['rtl']) $pds[$v] .=($lang['lang'] == 'en' ? 's': ''); $x=sprintf("%d %s ",$no,$pds[$v]);
		if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
		if($lang['rtl']) return " {$lang['timedate']['time_ago']} {$x}";
		else return "{$x} {$lang['timedate']['time_ago']}";
	} else {
    if($lang['lang'] == 'en'){
        return ($at?date('d M, Y \a\t H:i', $tm):date('d M, Y', $tm));
    } else {
        return ($at?date('d M, Y \a\t H:i', $tm):date('d M, Y', $tm));
    }
	}
}


function fh_bbcode($text){
	$match = [
		'/\[B\]/isU',
		'/\[\/B\]/isU',
		'/\[I\]/isU',
		'/\[\/I\]/isU',
		'/\[S\]/isU',
		'/\[\/S\]/isU',
		'/\[U\]/isU',
		'/\[\/U\]/isU',

		'/\[IMG width=(.*) height=(.*)\](.*)\[\/IMG\]/isU',
		'/\[IMG\](.*)\[\/IMG\]/isU',
		'/\[URL=(.+)\]/isU',
		'/\[\/URL\]/isU',

		'/\[COLOR=(.*)\]/isU',
		'/\[\/COLOR\]/isU',
		'/\[SIZE=1\]/isU',
		'/\[SIZE=2\]/isU',
		'/\[SIZE=3\]/isU',
		'/\[SIZE=4\]/isU',
		'/\[SIZE=5\]/isU',
		'/\[SIZE=6\]/isU',
		'/\[SIZE=7\]/isU',
		'/\[SIZE=([0-9]+)\]/isU',
		'/\[\/SIZE\]/isU',

		'/\[LEFT\](.*)\[\/LEFT\]/isU',
		'/\[RIGHT\](.*)\[\/RIGHT\]/isU',
		'/\[CENTER\]/isU',
		'/\[\/CENTER\]/isU',
		'/\[quote\](.*)\[\/quote\]/isU',
		'/\[CODE\](.*)\[\/CODE\]/isU',

		'/\[video\](.*)\[\/video\]/isU',
		'/\[youtube\](.*)\[\/youtube\]/isU',

		'/\[list\](.*)\[\/list\]/isU',
		'/\[list=1\](.*)\[\/list\]/isU',
		'/\[ul\](.*)\[\/ul\]/isU',
		'/\[ol\](.*)\[\/ol\]/isU',
		'/\[\*\](.*)\[\/\*\]/isU',
		'/\[li\](.*)\[\/li\]/isU',

		'/\[\TR\]/isU',
		'/\[\/\TR\]/isU',
		'/\[\TD\]/isU',
		'/\[\/\TD\]/isU',
		'/\[\TABLE\]/isU',
		'/\[\/\TABLE\]/isU',

		'/\[HR\]/isU',
	];

	$replace = [
		'<b>',
		'</b>',
		'<i>',
		'</i>',
		'<strike>',
		'</strike>',
		'<u>',
		'</u>',

		'<img src="$3" style="width:$1px;height:$2px;" />',
		'<img src="$1" />',
		'<a href="$1">',
		'</a>',

		'<span style="color:$1">',
		'</span>',
		'<span style="font-size:8px">',
		'<span style="font-size:12px">',
		'<span style="font-size:14px">',
		'<span style="font-size:16px">',
		'<span style="font-size:18px">',
		'<span style="font-size:20px">',
		'<span style="font-size:22px">',
		'<span style="font-size:16px">',
		'</span>',

		'<p class="text-left">$1</p>',
		'<p class="text-right">$1</p>',
		'<p class="text-center">',
		'</p>',
		'<blockquote>$1</blockquote>',
		'<pre>$1</pre>',

		'<iframe src="https://www.youtube.com/embed/$1" width="560" height="315" frameborder="0"></iframe>',
		'<iframe src="https://www.youtube.com/embed/$1" width="560" height="315" frameborder="0"></iframe>',

		'<ul>$1</ul>',
		'<ul class="decimal">$1</ul>',
		'<ul class="circle">$1</ul>',
		'<ol class="decimal">$1</ol>',
		'<li>$1</li>',
		'<li>$1</li>',
		'<tr>',
		'</tr>',
		'<td>',
		'</td>',
		'<table>',
		'</table>',

		'<hr/>',
	];


	$regex = '/\[font=.*?\]|\[\/font\]/i';
	$text = preg_replace($regex, '', $text);

	return nl2br(preg_replace($match, $replace, $text));
}

function fh_email_p($text, $link = '#', $rep = ''){
	$wrapper = '
		width: 480px;
		margin: 12px auto;
		color: #666;
		font-size: 16px;
		border: 1px solid #EEE;
		padding: 24px;
		border-radius: 3px;
	';
	$button = '
		display: block;
		background: #f43438;
		color: #fff;
		height: 48px;
		line-height: 48px;
		padding: 0 24px;
		font-size: 18px;
		border-radius: 3px;
		text-align: center;
		text-decoration: none;
	';
	$text = '<div style="'.$wrapper.'">'.$text.'</div>';
	$match = [
		'/\{button\}/',
		'/\{button bg=\#([A-Za-z0-9]+)\}/',
		'/\{\/button\}/',
	];
	$replace = [
		'<a href="'.$link.'" style="'.$button.'">',
		'<a href="'.$link.'" style="'.$button.'background:#$1">',
		'</a>',
	];

	$pr_r = preg_replace($match, $replace, $text);
	$pr_r = str_replace('\r\n', '<br>', $pr_r);

	if(!$rep)
		return $pr_r;
	else
		return preg_replace(['/\{name\}/', '/\{email\}/', '/\{title\}/'], $rep, $pr_r);
}
