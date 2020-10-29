<div class="pt-breadcrumb">
	<div class="pt-title">
		<i class="icon-wallet icons ic"></i> <?=$lang['restaurant']['it_orders']?>
	</div>
</div>
<br clear="both" />
<hr>

<?php
$sql = $db->query("SELECT * FROM ".prefix."orders WHERE user = '".us_id."' ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
if($sql->num_rows):
	$toott  = 0;
	$tshipp = 0;

while($rs = $sql->fetch_assoc()):
	$cart = json_decode($rs['order_cart'], true);
	$billing = json_decode($rs['billing_info'], true);
	$sqli = $db->query("SELECT * FROM ".prefix."items WHERE id = '{$cart['item_id']}'");
	$rsi  = $sqli->fetch_assoc();
	$sqli->close();

	$item_size = isset($cart['item_size']) ? db_unserialize([$rsi['sizes'], $cart['item_size']]) : '';
?>
<div class="pt-cart-body">
	<div class="media">
		<div class="media-left"><div class="pt-thumb"><img src="<?=path?>/<?=$rsi['image']?>" alt="<?=$rsi['name']?>" onerror="this.src='<?=noimage?>'"></div></div>
		<div class="media-body">
			<div class="pt-dtable">
				<div class="pt-vmiddle">
					<div class="pt-title">
						<h3>
							<a href="#">
								<?=$rsi['name']?><?php if($item_size): ?><strong class="pt-color"> (<?=$item_size['name']?>)</strong><?php endif; ?>
							</a>
						</h3>
					</div>
					<div class="pt-extra">
						<strong class="mr-2"><i class="fas fa-money-bill-wave"></i> <?=$cart['item_quantities']?> x <a><?=dollar_sign.(isset($cart['item_price']) ? $cart['item_price'] : ($item_size ? $item_size['price'] : $rsi['selling_price']))?></a></strong>
						<strong><i class="far fa-clock"></i> <?=fh_ago($rs['created_at'])?></strong>
					</div>
					<div class="pt-extra"><small><?=str_replace("+", " ", $cart['item_note'])?></small></div>
					<div class="pt-extra">
						<?php
						if($cart['item_extra']):
						foreach($cart['item_extra'] as $k => $extra):
							$extra = db_unserialize([$rsi['extra'], $extra]);
						?>
							<span>
								<?=$extra['name']?> <b class="pt-extraprice"><?=dollar_sign.$extra['price']?></b>
							</span>
						<?php
						endforeach;
						endif;
						?>
					</div>
					<div class="pt-options">
						<?php if($rs['status']==2): ?>
						<a class="pt-delivered wdth"><i class="fas fa-check"></i> <?=$lang['myorders']['delivered']?></a>
						<?php elseif($rs['status']==1): ?>
						<a class="pt-awaiting wdth bg-v"><i class="fas fa-truck"></i> <?=$lang['myorders']['intheway']?></a>
						<?php else: ?>
						<a class="pt-awaiting wdth"><i class="fas fa-clock"></i> <?=$lang['myorders']['awaiting']?></a>
						<?php endif; ?>
						<?php if($rs['status']!=2): ?>
						<a href="#" class="pt-delivered tips" data-id="<?php echo $rs['id'] ?>"><i class="fas fa-check"></i><b><?=$lang['myorders']['make_it_delivered']?></b></a>
						<?php endif; ?>
						<?php if($rs['status']==0): ?>
						<a href="#" class="pt-intheway tips" data-id="<?php echo $rs['id'] ?>"><i class="fas fa-truck"></i><b><?=$lang['myorders']['intheway']?></b></a>
						<?php endif; ?>
						<?php if (fh_access('invoices')): ?>
						<a href="#" class="pt-addinvoice tips" data-name="<?php echo time()."_".fh_seoURL($rsi['name']); ?>" data-id="<?php echo $rs['id']; ?>"><i class="fas fa-file-invoice-dollar"></i><b><?=$lang['myorders']['invoice']?></b></a>
						<?php endif; ?>
					</div>

				</div>
			</div>
		</div>
	</div>
	<div class="pt-billing">
		<span><b><?=$lang['myorders']['name']?>:</b> <?=str_replace("+", " ",$billing['name'])?></span>
		<span><b><?=$lang['cart']['phone']?>:</b> <?=$billing['phone']?></span><br />
		<span><b><?=$lang['cart']['address']?>:</b> <?=str_replace("+", " ",$billing['address'])?>, <?=str_replace("+", " ",$billing['city'])?>  <?=$billing['postal_code']?> - <?=str_replace("+", " ",$billing['state'])?>, <?=$billing['country']?></span>
	</div>
</div>

<?php if (fh_access('invoices')): ?>
<div class="d-none">
<div id="invoice_<?php echo $rs['id']; ?>">
	<h1 class="text-center mb-5"><?=$lang['myorders']['invoice']?></h1>
	<div class="card">
		<?php
		$sqlr = $db->query("SELECT * FROM ".prefix."restaurants WHERE id = '{$rs['restaurant']}'");
		$rsr  = $sqlr->fetch_assoc();
		$sqlr->close();
		?>
		<div class="card-header">
			<?=$lang['myorders']['invoice_id']?> <strong class="text-uppercase"><?php echo md5($rs['id']); ?></strong>
			<span class="float-right"><?=$lang['myorders']['invoice_date']?> <strong><?php echo date("d/m/Y H:i"); ?></strong></span>
		</div>
		<div class="card-body">
			<div class="row mb-4">
				<div class="col-sm-6">
					<h6 class="mb-3"><?=$lang['myorders']['invoice_from']?></h6>
					<div><strong><?php echo $rsr['name']; ?></strong></div>
					<div><?php echo $rsr['address']; ?></div>
					<div><?php echo $rsr['city']." ".$rsr['zipcode']." - ".$rsr['state'].", ".$rsr['country']; ?></div>
					<div><?=$lang['cart']['email']?>: <?php echo $rsr['email']; ?></div>
					<div><?=$lang['cart']['phone']?>: <?php echo $rsr['phone']; ?></div>
				</div>

				<div class="col-sm-6">
					<h6 class="mb-3">To:<?=$lang['myorders']['invoice']?></h6>
					<div><strong><?php echo str_replace("+", " ",$billing['name']); ?></strong></div>
					<div><?php echo str_replace("+", " ",$billing['address']); ?></div>
					<div><?php echo str_replace("+", " ",$billing['city'])." ".$billing['postal_code']." - ".str_replace("+", " ",$billing['state']).", ".$billing['country']; ?></div>
					<div><?=$lang['cart']['email']?>: <?php echo $billing['email']; ?></div>
					<div><?=$lang['cart']['phone']?>: <?php echo $billing['phone']; ?></div>
				</div>
			</div>

			<table class="table border">
				<thead class="bg-light">
					<tr>
						<th class="text-center">#</th>
						<th>Item<?=$lang['myorders']['invoice']?></th>
						<th class="text-center"><?=$lang['myorders']['invoice_qty']?></th>
						<th class="text-center"><?=$lang['myorders']['invoice_cost']?></th>
						<th class="text-center"><?=$lang['myorders']['invoice_shipping']?></th>
						<th class="text-center"><?=$lang['myorders']['invoice_total']?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="text-center">1</td>
						<td class="left strong"><?=$rsi['name']?><?php if($item_size): ?><strong class="pt-color"> (<?=$item_size['name']?>)</strong><?php endif; ?></td>
						<td class="text-center"><?=$cart['item_quantities']?></td>
						<td class="text-center"><?=dollar_sign.(isset($cart['item_price']) ? $cart['item_price'] : ($item_size ? $item_size['price'] : $rsi['selling_price']))?></td>
						<td class="text-center"><?=dollar_sign.(isset($cart['item_delivery']) ? $cart['item_delivery'] : 0)?></td>
						<?php $tttot = (isset($cart['item_price']) ? $cart['item_price'] : ($item_size ? $item_size['price'] : $rsi['selling_price'])) + (isset($cart['item_delivery']) ? $cart['item_delivery'] : 0); ?>
						<td class="text-center"><?=dollar_sign.($tttot*$cart['item_quantities'])?></td>
					</tr>
					<?php
					$toott  += ($tttot*$cart['item_quantities']);
					$tshipp += (isset($cart['item_delivery']) ? $cart['item_delivery']*$cart['item_quantities'] : 0);

					if($cart['item_extra']):
						$i = 1;
					foreach($cart['item_extra'] as $k => $extra):
						$i++;
						$extra = db_unserialize([$rsi['extra'], $extra]);
						$toott += ($extra['price']*$cart['item_quantities']);
					?>
					<tr>
						<td class="text-center"><?php echo $i; ?></td>
						<td class="left strong"><?php echo $extra['name']; ?></td>
						<td class="text-center"><?=$cart['item_quantities']?></td>
						<td class="text-center"><?php echo dollar_sign.$extra['price']; ?></td>
						<td class="text-center">--</td>
						<td class="text-center"><?php echo dollar_sign.($extra['price']*$cart['item_quantities']); ?></td>
					</tr>
					<?php
					endforeach;
					endif;
					?>
				</tbody>
			</table>

			<table class="table border float-right w-25">
				<tbody>
					<tr>
						<td class="left"><strong><?=$lang['myorders']['invoice_subtotal']?></strong></td>
						<td class="right"><?php echo dollar_sign.($toott-$tshipp); ?></td>
					</tr>
					<tr>
						<td class="left"><strong><?=$lang['myorders']['invoice_tshipping']?></strong></td>
						<td class="right"><?php echo dollar_sign.$tshipp; ?></td>
					</tr>
					<tr>
						<td class="left"><strong><?=$lang['myorders']['invoice_total']?></strong></td>
						<td class="right"><strong><?php echo dollar_sign.($toott); ?></strong></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
<?php endif; ?>

<?php endwhile; ?>
<?php echo fh_pagination("orders WHERE user = '".us_id."'",$limit, path."/restaurant.php?pg=orders&") ?>
<?php else: ?>
	<div class="text-center"><?=$lang['alerts']['no-data']?></div>
<?php
endif;
