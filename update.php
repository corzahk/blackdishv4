<?php


include __DIR__.'/configs/connection.php';

?>
<title>Puerto Update</title>
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
	<form method="post" action="update.php?step=1">

	<h1>Welcome to Puerto blackdish</h1>
	<p>
	
	</p>
	<ul>
		<li>my Email: <span class="p-h">info@blackdish.mx</span></li>
		<li>my Facebook account <span class="p-h"><a href="https://fb.com/prof.blackdish">fb.com/prof.blackdish</a></span></li>
		<li>on the Instagram <span class="p-h"><a href="https://instagram.com/blackdish">instagram.com/blackdish</a></span></li>
		<li> <span class="p-h"><a href=""></a></span></li>
	</ul>
	<p>
	 <br><br />
	<button type="submit" class="button">Update Puerto Script</button>
	</p>
		</form>
</div>





<?php

else:


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
	<h1>Congratulations...</h1>
	<p>
		

		</p>
		<ul>
			<li>my Email: <span class="p-h">info@blackdish.mx</span></li>
			<li>my Facebook account <span class="p-h"><a href="https://fb.com/prof.blackdish">fb.com/prof.blackdish</a></span></li>
			<li>on the Instagram <span class="p-h"><a href="https://instagram.com/blackdish">instagram.com/blackdish</a></span></li>
			<li> <span class="p-h"><a href=""></a></span></li>
		</ul>
		<p>
		 and I will back to you with all help you need.<br><br>
		<span class="red">Please do not forget to delete the update file 'update.php'.</span><br>
		<a href="index.php" class="button">Go to index</a>
	</p>
</div>

<?php
endif;
