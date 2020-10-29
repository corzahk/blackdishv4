<?php


$rs_rest = db_rs("restaurants WHERE author = '".us_id."' ORDER BY id ASC LIMIT 1");
?>
	<?php if ($rs_rest): ?>
	<div class="pt-restohead">
		<div class="media">
			<div class="media-left"><div class="pt-thumb"><img src="<?php echo $rs_rest['photo'] ?>" onerror="this.src='<?=noimage?>'"></div></div>
			<div class="media-body">
				<div class="pt-dtable">
					<div class="pt-vmiddle">
						<div class="pt-title"><a href="<?php echo path ?>/restaurants.php?id=<?php echo $rs_rest['id'] ?>&t=<?php echo fh_seoURL($rs_rest['name']) ?>"><h3><?php echo $rs_rest['name'] ?></h3></a></div>
						<div class="pt-stars"><?php echo fh_stars($rs_rest['id'], "restaurant") ?></div>
					</div>
				</div>
			</div>
		</div>

	</div>
	<hr>
	<?php else:
		$rs_rest = [];
		$rs_rest['id'] = '';
	?>
	<?php endif; ?>
	<div class="pt-stats">
		<ul>
			<li><b><?=$lang['restaurant']['dash_sales']?></b> <em><?php echo db_rows("orders WHERE user = '".us_id."'") ?></em></li>
			<li>
				<b><?=$lang['restaurant']['dash_earnings']?></b>
				<?php
					$tot_earnings = 0;
					$sql_tot = $db->query("SELECT * FROM ".prefix."orders WHERE user = '".us_id."'");
					if($sql_tot->num_rows){
						while ($rs_tot = $sql_tot->fetch_assoc()) {
							$tot_earnings += fh_order_price($rs_tot['id']);
						}
					}
					$sql_tot->close();
				?>
				<em><?php echo dollar_sign.$tot_earnings; ?></em>
			</li>
			<li><b><?=$lang['restaurant']['dash_balance']?></b> <em><?php echo dollar_sign.us_balance; ?></em></li>
		</ul>
	</div>
	<div class="pt-shortstats">
		<h3><?=$lang['restaurant']['dash_short']?></h3>
		<div class="pt-box">
			<h6><?=$lang['restaurant']['dash_monthsales']?></h6>
			<b><?php echo db_rows("orders WHERE user = '".us_id."' and FROM_UNIXTIME(created_at,'%m-%Y') = '".date("m-Y")."'") ?></b>
		</div>
		<div class="pt-box">
			<h6><?=$lang['restaurant']['dash_monthearn']?></h6>
			<?php
				$month_earnings = 0;
				$sql_r = $db->query("SELECT * FROM ".prefix."orders WHERE user = '".us_id."' and FROM_UNIXTIME(created_at,'%m-%Y') = '".date("m-Y")."'");
				if($sql_r->num_rows){
					while ($rs_r = $sql_r->fetch_assoc()) {
						$month_earnings += fh_order_price($rs_r['id']);
					}
				}
				$sql_r->close();
			?>
			<b><?php echo dollar_sign.$month_earnings; ?></b>
		</div>
		<div class="pt-box">
			<h6><?=$lang['restaurant']['dash_todaysales']?></h6>
			<b><?php echo db_rows("orders WHERE user = '".us_id."' and FROM_UNIXTIME(created_at,'%d-%m-%Y') = '".date("d-m-Y")."'") ?></b>
		</div>
		<div class="pt-box">
			<h6><?=$lang['restaurant']['dash_todayearn']?></h6>
			<?php
				$today_earnings = 0;
				$sql_t = $db->query("SELECT * FROM ".prefix."orders WHERE user = '".us_id."' and FROM_UNIXTIME(created_at,'%d-%m-%Y') = '".date("d-m-Y")."'");
				if($sql_t->num_rows){
					while ($rs_t = $sql_t->fetch_assoc()) {
						$today_earnings += fh_order_price($rs_t['id']);
					}
				}
				$sql_t->close();
			?>
			<b><?php echo dollar_sign.$today_earnings; ?></b>
		</div>
	</div>

	<?php if (fh_access('statistics')): ?>
	<div class="pt-shortstats">
		<h3><?=$lang['restaurant']['dash_os']?></h3>
		<div class="pt-cart-body">
			<canvas id="orders-os" rel="<?=$rs_rest['id']?>"></canvas>
		</div>
	</div>

	<div class="pt-shortstats">
		<h3><?=$lang['restaurant']['dash_devices']?></h3>
		<div class="pt-cart-body">
			<div class="w-60"><canvas id="orders-devices" rel="<?=$rs_rest['id']?>"></canvas></div>

		</div>
	</div>
	<?php endif; ?>
