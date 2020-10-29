<?php


include __DIR__."/header.php";

if(!us_level){
	fh_go(path);
	exit;
}

?>
<div class="pt-breadcrumb-p">
	<div class="container">
		<h3><?=$lang['myorders']['title']?></h3>
		<p><?=$lang['myorders']['desc']?></p>
	</div>
</div>

<div class="container">

	<div class="pt-cart-body">
		<?php
		$sql = $db->query("SELECT * FROM ".prefix."orders WHERE author = '".us_id."' ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
		if($sql->num_rows):
		while($rs = $sql->fetch_assoc()):
			$cart = json_decode($rs['order_cart'], true);
			$rsi  = db_rs("items WHERE id = '{$cart['item_id']}'");

			$item_size = isset($cart['item_size']) ? db_unserialize([$rsi['sizes'], $cart['item_size']]) : '';
		?>
		<div class="pt-cart-body">
			<div class="media">
				<div class="media-left"><div class="pt-thumb"><img src="<?=path?>/<?=$rsi['image']?>" alt="<?=$rsi['name']?>" onerror="this.src='<?=noimage?>'"></div></div>
				<div class="media-body">
					<div class="pt-dtable">
						<div class="pt-vmiddle">
							<div class="pt-title"><h3><a href="#"><?=$rsi['name']?><?php if($item_size): ?><strong class="pt-color"> (<?=$item_size['name']?>)</strong><?php endif; ?></a></h3></div>
							<div class="pt-extra">
								<strong><i class="fas fa-money-bill-wave"></i> <?=$cart['item_quantities']?> x <a><?=dollar_sign.($item_size ? $item_size['price'] : $rsi['selling_price'])?></a></strong>
								<strong> - <i class="far fa-clock"></i> <?=fh_ago($rs['created_at'])?></strong>
								<a href="<?=path?>/restaurants.php?id=<?=$rs['restaurant']?>"><strong> - <i class="fas fa-store"></i> <?=db_get("restaurants", "name", $rs['restaurant'])?></strong></a>
							</div>
							<div class="pt-extra"><small><?=str_replace("+", " ", $cart['item_note'])?></small></div>
							<div class="pt-extra">
								<?php
								if($cart['item_extra']):
								foreach($cart['item_extra'] as $k => $extra):
									$extra = db_unserialize([$rsi['extra'], $extra]);
								?>
									<span><?=$extra['name']?> <b class="pt-extraprice"><?=dollar_sign.$extra['price']?></b></span>
								<?php
								endforeach;
								endif;
								?>
							</div>
							<div class="pt-options">
								<?php if($rs['status']!=2): ?>
									<a href="#" class="pt-delivered tips" data-id="<?=$rs['id']?>"><i class="fas fa-check"></i><b><?=$lang['myorders']['make_it_delivered']?></b></a>
								<?php endif; ?>
								<?php if($rs['status']==2): ?>
								<a data-toggle="modal" href="#myModal" class="pt-additemreview tips" data-id="<?=$rsi['id']?>"><i class="fas fa-star"></i> <b><?=$lang['myorders']['add_your_review']?></b></a>
								<a class="pt-delivered"><i class="fas fa-check"></i> <?=$lang['myorders']['delivered']?></a>
								<?php elseif($rs['status']==1): ?>
									<a class="pt-delivered wdth bg-v"><i class="fas fa-truck"></i> <?=$lang['myorders']['intheway']?></a>
								<?php else: ?>
								<a class="pt-awaiting"><i class="fas fa-clock"></i> <?=$lang['myorders']['awaiting']?></a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endwhile; ?>
		<?php echo fh_pagination("orders WHERE author = '".us_id."'",$limit, path."/myorders.php?") ?>
		<?php include __DIR__."/partials/newreview.php"; ?>
		<?php else: ?>
			<div class="text-center"><?=$lang['alerts']['no-data']?></div>
		<?php endif; ?>
	</div>

</div>

<?php
include __DIR__."/footer.php";
