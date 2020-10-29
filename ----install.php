<?php


include __DIR__.'/configs/connection.php';

?>
<title>Puerto Install</title>
<style>
	body { background: #F7F7F7; }
	.install-box { width:450px;margin:20px auto 0 auto;background: #FFF;font-family:tahoma;font-size:14px;box-shadow:0 0 5px #CCC; }
	.install-box h1 { padding: 24px 20px;margin:0;font-size:18px;color: #555;    border-bottom: 1px solid #F7F7F7; }
	.install-box p { padding:20px;margin:0;color: #777;line-height: 1.6; }
	.install-box ul { padding: 0 20px;font-size: 12px;line-height: 1.4; }
	.install-box .button {font-size:18px;background:#DF4444;color:#FFF;text-decoration:none;display:block;margin-top:20px;text-align:center;padding:10px 0;border-radius: 3px;width: 100%; }
	.input { padding:10px 20px 0px 20px; }
	.input p { padding:0; font-size:12px; }
	label { font-weight:bold; font-size:12px; margin-left:5px; margin-bottom: 6px; color: #555; display:block; }
	input { padding:10px; font-size:12px; border:1px solid #DDD; width:100%;  }
	input[type=submit] { padding:10px; font-size:12px; color:#FFF; border:1px solid #DF4444; background:#DF4444; width:auto;  }
	.p-h, .p-h a {
    inline-block: ;
    padding: 2px 6px;
    background: #EEE;
    border-radius: 3px;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    color: #555;
    text-shadow: 0 1px 0 #FFF;
	}
	ul {
		margin:0 24px
	}
	ul li {
		margin: 6px 0;
	}
	.red {
		color: red;
	}
</style>


<?php

$step = (isset($_GET['step']) ? (int)($_GET['step']) : '');

if($step == ''):

?>
<div class="install-box">
	<form method="post" action="install.php?step=1">

	<h1></h1>
	<p>
	
	</p>
	<ul>
		<li>my Email: <span class="p-h"></span></li>
		<li>my Facebook account <span class="p-h"><a href="https://fb.com"></a></span></li>
		<li>on the Instagram <span class="p-h"><a href="https://instagram.com/"></a></span></li>
		<li><span class="p-h"><a href="http://codecanyon.net/"></a></span></li>
	</ul>
	<p>
	<br><br />
	<br /><br />

	<label>Admin Username</label><input type="text" name="admin" />
	<label>Admin Password:</label><input type="password" name="password" />
	<label>Admin Email:</label><input type="text" name="email" />
	<button type="submit" class="button">Install Puerto Script</button>
	</p>
		</form>
</div>





<?php

else:

	$admin = (isset($_POST['admin']) ? mysqli_real_escape_string($db, $_POST['admin']): '');
	$pass = (isset($_POST['password']) ?mysqli_real_escape_string($db, $_POST['password']): '');
	$email = (isset($_POST['email']) ?mysqli_real_escape_string($db, $_POST['email']): '');


	if(!$admin || !$pass || !$email){
		die('Please fill all the infos! <meta http-equiv="refresh" content="3;url=install.php">');
	}

	function sc_pass($data) {
		return sha1($data);
	}


	$db->query("
	CREATE TABLE `".prefix."configs` (
	  `id` tinyint(3) UNSIGNED NOT NULL,
	  `variable` varchar(255) DEFAULT NULL,
	  `value` text
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;
	") or die($db->error);

	$db->query("INSERT INTO `".prefix."configs` (`id`, `variable`, `value`) VALUES
	(1, 'site_logo', 'uploads/settings/.png'),
	(2, 'site_title', ''),
	(3, 'site_url', ''),
	(4, 'site_description', ''),
	(5, 'site_keywords', ''),
	(6, 'site_image', ''),
	(7, 'site_register', ''),
	(8, 'site_forget', ''),
	(9, 'site_smtp_auth', '1'),
	(10, 'site_smtp_port', '587'),
	(11, 'site_author', ''),
	(12, 'site_country', 'US'),
	(13, 'site_noreply', '),
	(14, 'fotget_password_msg', ''),
	(15, 'email_verification_msg', ''),
	(16, 'site_plans', '0'),
	(17, 'login_facebook', '1'),
	(18, 'login_twitter', '1'),
	(19, 'login_google', '1'),
	(20, 'login_fbAppId', ''),
	(21, 'login_fbAppSecret', ''),
	(22, 'login_fbAppVersion', ''),
	(23, 'login_twConKey', ''),
	(24, 'login_twConSecret', ''),
	(25, 'login_ggClientId', ''),
	(26, 'login_ggClientSecret', ''),
	(27, 'site_paypal_id', ''),
	(28, 'site_paypal_live', '0'),
	(29, 'site_currency_name', 'USD'),
	(30, 'site_currency_symbol', '$'),
	(31, 'site_smtp', '0'),
	(32, 'site_smtp_host', 'localhost'),
	(33, 'site_smtp_username', ''),
	(34, 'site_smtp_password', ''),
	(35, 'site_smtp_encryption', 'none'),
	(36, 'site_favicon', 'uploads/settings/ODAtZmF2ZWljb24-_1591272924.png'),
	(37, 'site_paypal_client_id', ''),
	(38, 'site_paypal_client_secret', ''),
	(39, 'site_users', '0'),
	(40, 'site_facebook', ''),
	(41, 'site_twitter', ''),
	(42, 'site_instagram', ''),
	(43, 'site_youtube', ''),
	(44, 'site_skype', '');
	") or die($db->error);

	$db->query("
	CREATE TABLE `".prefix."cuisines` (
	  `id` int(11) NOT NULL,
	  `name` varchar(100) DEFAULT NULL,
	  `image` varchar(200) DEFAULT NULL,
	  `created_at` int(11) DEFAULT NULL,
	  `updated_at` int(11) DEFAULT NULL,
	  `author` int(11) DEFAULT '0'
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	") or die($db->error);


	$db->query("
	CREATE TABLE `".prefix."images` (
	  `id` int(11) NOT NULL,
	  `author` int(11) DEFAULT '0',
	  `table_name` varchar(20) DEFAULT NULL,
	  `table_id` int(11) DEFAULT '0',
	  `created_at` int(11) DEFAULT NULL,
	  `sort` int(11) DEFAULT '0',
	  `url` varchar(255) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	") or die($db->error);


	$db->query("
	CREATE TABLE `".prefix."items` (
	  `id` int(11) NOT NULL,
	  `name` varchar(255) DEFAULT NULL,
	  `selling_price` varchar(8) DEFAULT NULL,
	  `reduce_price` varchar(8) DEFAULT NULL,
	  `description` text,
	  `restaurant` int(11) DEFAULT '0',
	  `menu` int(11) DEFAULT '0',
	  `cuisine` int(11) DEFAULT '0',
	  `sizes` text,
	  `extra` text,
	  `created_at` int(11) DEFAULT NULL,
	  `updated_at` int(11) DEFAULT NULL,
	  `author` int(11) DEFAULT '0',
	  `status` tinyint(1) DEFAULT '0',
	  `instock` tinyint(1) DEFAULT '0',
	  `image` varchar(255) DEFAULT NULL,
	  `ingredients` varchar(255) DEFAULT NULL,
	  `delivery_price` float DEFAULT '0',
	  `delivery_time` varchar(50) DEFAULT NULL,
	  `home` int(11) DEFAULT '0'
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	") or die($db->error);


	$db->query("
	CREATE TABLE `".prefix."menus` (
	  `id` int(11) NOT NULL,
	  `name` varchar(100) DEFAULT NULL,
	  `created_at` int(11) DEFAULT NULL,
	  `updated_at` int(11) DEFAULT NULL,
	  `author` int(11) DEFAULT '0',
	  `restaurant` int(11) DEFAULT '0',
	  `sort` int(11) DEFAULT '0'
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	") or die($db->error);

	$db->query("
	CREATE TABLE `".prefix."orders` (
	  `id` int(11) NOT NULL,
	  `transaction_id` varchar(100) DEFAULT NULL,
	  `payment_amount` varchar(10) DEFAULT NULL,
	  `payment_status` varchar(50) DEFAULT NULL,
	  `invoice_id` varchar(200) DEFAULT NULL,
	  `created_at` int(11) DEFAULT NULL,
	  `order_cart` text,
	  `billing_info` text,
	  `author` int(11) DEFAULT '0',
	  `status` tinyint(1) DEFAULT '0',
	  `restaurant` int(11) DEFAULT '0',
	  `item` int(11) DEFAULT '0',
	  `user` int(11) DEFAULT '0',
	  `ip` varchar(50) DEFAULT NULL,
	  `os` varchar(50) DEFAULT NULL,
	  `browser` varchar(50) DEFAULT NULL,
	  `device` varchar(50) DEFAULT NULL,
	  `country_name` varchar(50) DEFAULT NULL,
	  `country_code` varchar(5) DEFAULT NULL,
	  `state` varchar(50) DEFAULT NULL,
	  `city_name` varchar(50) DEFAULT NULL,
	  `delivery_date` int(11) DEFAULT NULL,
	  `shipping_date` int(11) DEFAULT NULL,
	  `gender` tinyint(1) DEFAULT '0'
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	") or die($db->error);

	$db->query("
	CREATE TABLE `".prefix."pages` (
	  `id` int(11) NOT NULL,
	  `title` varchar(200) DEFAULT NULL,
	  `content` longtext,
	  `created_at` int(11) DEFAULT '0',
	  `updated_at` int(11) DEFAULT '0',
	  `footer` tinyint(1) DEFAULT '0',
	  `link` varchar(255) DEFAULT NULL,
	  `sort` smallint(6) DEFAULT '0',
	  `keywords` text,
	  `description` text
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	") or die($db->error);

	$db->query("
	INSERT INTO `".prefix."pages` (`id`, `title`, `content`, `created_at`, `updated_at`, `footer`, `link`, `sort`, `keywords`, `description`) VALUES
	(1, 'About', '[b]Who are we?[/b]\r\nis a technology company that connects people with the best in their cities. We do this by empowering local businesses and in turn, generate new ways for people to earn, work and live. We started by facilitating door-to-door delivery, but we see this as just the beginning of connecting people with possibility — easier evenings, happier days, bigger savings accounts, wider nets and stronger communities.\r\n\r\n[b]Delivering good to Customers[/b]\r\nWith your favorite restaurants at your fingertips,  satisfies your cravings and connects you with possibilities — more time and energy for yourself and those you love.\r\n', 1472750541, 1593690346, 0, '0', 1, 'a:3:{i:0;s:4:\"key1\";i:1;s:4:\"key2\";i:2;s:4:\"key3\";}', ''),
	(2, 'Contact', 'You can contact us at contact@email.com for your contact questions, opinions, suggestions or skills.\r\nKilic Ali Pasa Cad. No: 12 K: 1 karakãy, Istanbul, Turkey\r\nCana Bilisim Hizmetleri ve Ticaret A.Åž.\r\n\r\nTax Identification Number 1111438913\r\n0212 223 59 00', 1472750541, 1593691345, 0, '0', 2, '', '')
	") or die($db->error);

	$db->query("
	CREATE TABLE `".prefix."payments` (
	  `id` int(11) NOT NULL,
	  `plan` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	  `payment_id` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	  `payer_id` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	  `token` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	  `price` float(10,2) DEFAULT NULL,
	  `currency` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	  `status` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	  `date` int(11) DEFAULT '0',
	  `author` int(11) DEFAULT '0'
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	") or die($db->error);

	$db->query("
	CREATE TABLE `".prefix."plans` (
	  `id` int(11) NOT NULL,
	  `plan` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	  `price` float(10,2) DEFAULT NULL,
	  `currency` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	  `desc1` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	  `desc2` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	  `desc3` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	  `desc4` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	  `desc5` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	  `desc6` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	  `desc7` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	  `desc8` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	  `desc9` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	  `created_at` int(11) DEFAULT '0',
	  `restaurants` int(11) DEFAULT '0',
	  `menus` int(11) DEFAULT '0',
	  `items` int(11) DEFAULT '0',
	  `orders` int(11) DEFAULT '0',
	  `export_statistics` tinyint(1) DEFAULT '0',
	  `invoices` tinyint(1) DEFAULT '0',
	  `statistics` tinyint(1) DEFAULT '0',
	  `stripe` tinyint(1) DEFAULT '0',
	  `show_ads` tinyint(1) DEFAULT '0',
	  `support` tinyint(1) DEFAULT '0'
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	") or die($db->error);

	$db->query("
	INSERT INTO `".prefix."plans` (`id`, `plan`, `price`, `currency`, `desc1`, `desc2`, `desc3`, `desc4`, `desc5`, `desc6`, `desc7`, `desc8`, `desc9`, `created_at`, `restaurants`, `menus`, `items`, `orders`, `export_statistics`, `invoices`, `statistics`, `stripe`, `show_ads`, `support`) VALUES
	(1, 'Free Plan', 0.00, '$', '1 Restaurant', '3 Restaurant menus', '6 Restaurant items', '10 Orders a month', 'Paypal payment', 'Statistics', 'Export statistics', 'Invoices', 'Priority support', 0, 1, 3, 3, 3, 0, 0, 0, 0, 0, 0),
	(2, 'Basic Plan', 9.99, '$', '3 Restaurant', '6 Restaurant menus', '20 Restaurant items', '20 Orders a month', 'Paypal payment', 'Statistics', 'Export statistics', 'Invoices', 'Priority support', 0, 3, 5, 12, 6, 0, 0, 0, 0, 0, 0),
	(3, 'Regular Plan', 19.99, '$', '6 Restaurant', '12 Restaurant menus', '50 Restaurant items', '40 Orders a month', 'Paypal/Stripe payment', 'Statistics', 'Export statistics', 'Invoices', 'Priority support', 0, 8, 10, 18, 10, 0, 1, 1, 1, 0, 0),
	(4, 'Pro Plan', 24.99, '$', 'Unlimited Restaurant', 'Unlimited Restaurant menus', 'Unlimited Restaurant items', 'Unlimited Orders a month', 'Paypal/Stripe payment', 'Statistics', 'Export statistics', 'Invoices', 'Priority support', 0, 99999999, 99999999, 99999999, 99999999, 1, 1, 1, 1, 1, 1);
	") or die($db->error);

	$db->query("
	CREATE TABLE `".prefix."restaurants` (
	  `id` int(11) NOT NULL,
	  `name` varchar(100) DEFAULT NULL,
	  `phone` varchar(20) DEFAULT NULL,
	  `email` varchar(200) DEFAULT NULL,
	  `delivery_time` varchar(20) DEFAULT NULL,
	  `delivery_fees` varchar(8) DEFAULT NULL,
	  `cuisine` varchar(255) DEFAULT NULL,
	  `services` tinyint(1) DEFAULT NULL,
	  `country` varchar(3) DEFAULT NULL,
	  `city` varchar(50) DEFAULT NULL,
	  `state` varchar(50) DEFAULT NULL,
	  `zipcode` varchar(10) DEFAULT NULL,
	  `address` varchar(255) DEFAULT NULL,
	  `maps` varchar(255) DEFAULT NULL,
	  `photo` varchar(255) DEFAULT NULL,
	  `cover` varchar(255) DEFAULT NULL,
	  `created_at` int(11) DEFAULT NULL,
	  `updated_at` int(11) DEFAULT NULL,
	  `author` int(11) DEFAULT '0',
	  `status` tinyint(1) DEFAULT '0',
	  `facebook` varchar(200) DEFAULT NULL,
	  `twitter` varchar(200) DEFAULT NULL,
	  `website` varchar(100) DEFAULT NULL,
	  `instagram` varchar(200) DEFAULT NULL,
	  `youtube` varchar(200) DEFAULT NULL,
	  `working_hours` text,
	  `rating` float DEFAULT '0',
	  `payment` varchar(10) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	") or die($db->error);

	$db->query("
	CREATE TABLE `".prefix."reviews` (
	  `id` int(11) NOT NULL,
	  `author` int(11) DEFAULT '0',
	  `user` int(11) DEFAULT '0',
	  `restaurant` int(11) DEFAULT '0',
	  `item` int(11) DEFAULT '0',
	  `content` text,
	  `title` varchar(200) DEFAULT NULL,
	  `stars` tinyint(1) DEFAULT '0',
	  `created_at` int(11) DEFAULT '0'
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	") or die($db->error);

	$db->query("
	CREATE TABLE `".prefix."subscribers` (
	  `id` int(11) NOT NULL,
	  `email` varchar(200) DEFAULT NULL,
	  `content` text,
	  `created_at` int(11) DEFAULT '0'
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	") or die($db->error);


	$db->query("
	CREATE TABLE `".prefix."testimonials` (
	  `id` int(11) NOT NULL,
	  `author` int(11) DEFAULT '0',
	  `content` text,
	  `created_at` int(11) DEFAULT '0',
	  `status` tinyint(1) DEFAULT '0'
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	") or die($db->error);

	$db->query("
	INSERT INTO `".prefix."testimonials` (`id`, `author`, `content`, `created_at`, `status`) VALUES
	(1, 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.', 1591039936, 1);
	") or die($db->error);

	$db->query("
	CREATE TABLE `".prefix."users` (
	  `id` int(10) UNSIGNED NOT NULL,
	  `firstname` varchar(100) DEFAULT NULL,
	  `lastname` varchar(100) DEFAULT NULL,
	  `username` varchar(255) DEFAULT NULL,
	  `password` varchar(255) DEFAULT NULL,
	  `photo` varchar(255) DEFAULT NULL,
	  `cover` varchar(255) DEFAULT NULL,
	  `date` int(11) DEFAULT NULL,
	  `level` tinyint(1) UNSIGNED DEFAULT '0',
	  `email` varchar(255) DEFAULT NULL,
	  `socials` varchar(255) DEFAULT NULL,
	  `social_id` varchar(255) DEFAULT NULL,
	  `social_name` varchar(255) DEFAULT NULL,
	  `gender` tinyint(1) UNSIGNED DEFAULT '0',
	  `country` varchar(3) DEFAULT NULL,
	  `city` varchar(150) DEFAULT NULL,
	  `state` varchar(150) DEFAULT NULL,
	  `address` text,
	  `birth` varchar(255) DEFAULT NULL,
	  `statistics` text,
	  `moderat` varchar(255) DEFAULT '0',
	  `verified` tinyint(1) UNSIGNED DEFAULT '0',
	  `balance` float UNSIGNED DEFAULT '0',
	  `description` varchar(255) DEFAULT NULL,
	  `language` tinyint(1) UNSIGNED DEFAULT NULL,
	  `updated_at` int(10) UNSIGNED DEFAULT NULL,
	  `trash` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
	  `plan` tinyint(1) DEFAULT '0',
	  `txn_id` varchar(200) DEFAULT NULL,
	  `lastpayment` int(11) DEFAULT NULL,
	  `phone` varchar(20) DEFAULT NULL
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;
	") or die($db->error);


	$db->query("
	CREATE TABLE `".prefix."withdraws` (
	  `id` int(11) NOT NULL,
	  `author` int(11) DEFAULT NULL,
	  `price` float DEFAULT NULL,
	  `created_at` int(11) DEFAULT NULL,
	  `accepted_at` int(11) DEFAULT NULL,
	  `status` tinyint(1) DEFAULT '0',
	  `email` varchar(255) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	") or die($db->error);


	$db->query("ALTER TABLE `".prefix."configs` ADD PRIMARY KEY (`id`);") or die($db->error);

	$db->query("ALTER TABLE `".prefix."cuisines` ADD PRIMARY KEY (`id`);") or die($db->error);

	$db->query("ALTER TABLE `".prefix."images` ADD PRIMARY KEY (`id`);") or die($db->error);

	$db->query("ALTER TABLE `".prefix."items` ADD PRIMARY KEY (`id`);") or die($db->error);

	$db->query("ALTER TABLE `".prefix."menus` ADD PRIMARY KEY (`id`);") or die($db->error);

	$db->query("ALTER TABLE `".prefix."orders` ADD PRIMARY KEY (`id`);") or die($db->error);

	$db->query("ALTER TABLE `".prefix."pages` ADD PRIMARY KEY (`id`);") or die($db->error);

	$db->query("ALTER TABLE `".prefix."payments` ADD PRIMARY KEY (`id`);") or die($db->error);

	$db->query("ALTER TABLE `".prefix."plans` ADD PRIMARY KEY (`id`);") or die($db->error);

	$db->query("ALTER TABLE `".prefix."restaurants` ADD PRIMARY KEY (`id`);") or die($db->error);

	$db->query("ALTER TABLE `".prefix."reviews` ADD PRIMARY KEY (`id`);") or die($db->error);

	$db->query("ALTER TABLE `".prefix."subscribers` ADD PRIMARY KEY (`id`);") or die($db->error);

	$db->query("ALTER TABLE `".prefix."testimonials` ADD PRIMARY KEY (`id`);") or die($db->error);

	$db->query("ALTER TABLE `".prefix."users` ADD PRIMARY KEY (`id`);") or die($db->error);

	$db->query("ALTER TABLE `".prefix."withdraws` ADD PRIMARY KEY (`id`);") or die($db->error);



	$db->query("ALTER TABLE `".prefix."configs` MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;") or die($db->error);

	$db->query("ALTER TABLE `".prefix."cuisines` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;") or die($db->error);

	$db->query("ALTER TABLE `".prefix."images` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;") or die($db->error);

	$db->query("ALTER TABLE `".prefix."items` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;") or die($db->error);

	$db->query("ALTER TABLE `".prefix."menus` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;") or die($db->error);

	$db->query("ALTER TABLE `".prefix."orders` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;") or die($db->error);

	$db->query("ALTER TABLE `".prefix."pages` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;") or die($db->error);

	$db->query("ALTER TABLE `".prefix."payments` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;") or die($db->error);

	$db->query("ALTER TABLE `".prefix."plans` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;") or die($db->error);

	$db->query("ALTER TABLE `".prefix."restaurants` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;") or die($db->error);

	$db->query("ALTER TABLE `".prefix."reviews` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;") or die($db->error);

	$db->query("ALTER TABLE `".prefix."subscribers` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;") or die($db->error);

	$db->query("ALTER TABLE `".prefix."testimonials` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;") or die($db->error);

	$db->query("ALTER TABLE `".prefix."users` MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;") or die($db->error);

	$db->query("ALTER TABLE `".prefix."withdraws` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;") or die($db->error);


	$db->query("
		INSERT INTO `".prefix."users` (`username`, `password`, `date`, `level`, `email`) VALUES
		('{$admin}', '".sc_pass($pass)."', '".time()."', 6, '{$email}');
	") or die($db->error);




	$db->query("ALTER TABLE `".prefix."restaurants` ADD `latitude` VARCHAR(100) NULL AFTER `payment`, ADD `longitude` VARCHAR(100) NULL AFTER `latitude`;");
	$db->query("ALTER TABLE `".prefix."restaurants` ADD `neworders` TINYINT(1) NULL DEFAULT '1' AFTER `longitude`;");


	$db->query("INSERT INTO `".prefix."configs` (`id`, `variable`, `value`) VALUES (NULL, 'taxes', '10');");
	$db->query("INSERT INTO `".prefix."configs` (`id`, `variable`, `value`) VALUES (NULL, 'site_stripe_key', '');");
	$db->query("INSERT INTO `".prefix."configs` (`id`, `variable`, `value`) VALUES (NULL, 'site_stripe_secret', '');");
	$db->query("INSERT INTO `".prefix."configs` (`id`, `variable`, `value`) VALUES (NULL, 'ipinfo', '9db5fed4cf44c2');");

	$db->query("CREATE TABLE `".prefix."taxes` (
	  `id` int(11) NOT NULL,
	  `order_id` int(11) DEFAULT '0',
	  `taxes` float DEFAULT '0',
	  `created_at` int(11) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

	$db->query("ALTER TABLE `".prefix."taxes` ADD PRIMARY KEY (`id`);");

	$db->query("ALTER TABLE `".prefix."taxes` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");


?>


<div class="install-box">
	<h1>Blackdish Install</h1>
	<p>
		

		</p>
		<ul>
			<li>my Email: <span class="p-h"></span></li>
			<li>my Facebook account <span class="p-h"><a href=""></a></span></li>
			<li>on the Instagram <span class="p-h"><a href=""></a></span></li>
			<li> <span class="p-h"><a href=""></a></span></li>
		</ul>
		<p>
		<br><br>
		<span class="red">Please do not forget to delete the installation file 'install.php'.</span><br>
		<a href="index.php" class="button">Go to index</a>
	</p>
</div>

<?php
endif;
