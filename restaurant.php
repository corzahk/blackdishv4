<?php


include __DIR__."/header.php";

if(!us_level || !us_plan){
	fh_go(path);
	exit;
}
?>
<div class="pt-breadcrumb-p">
	<div class="container">
		<h3><?=$lang['restaurant']['title1']?></h3>
		<p><?=$lang['restaurant']['desc1']?></p>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-4">
			<div class="pt-cart-body">
				<h4><?=$lang['restaurant']['tools']?></h4>
				<ul class="pt-menu">
					<li><a href="<?=path?>/restaurant.php"><i class="fas fa-store"></i> <?=$lang['restaurant']['restaurant']?></a></li>
					<li><a href="<?=path?>/restaurant.php?pg=orders"><i class="icons icon-wallet"></i> <?=$lang['restaurant']['orders']?> <?php if($head_orders) echo "<b>".db_rows("orders WHERE status = 0 and user = '".us_id."'")."</b>"; ?></a></li>
					<li><a href="<?=path?>/restaurant.php?pg=details"><i class="fas fa-pencil-alt"></i> <?=$lang['restaurant']['details']?></a></li>
					<li><a href="<?=path?>/restaurant.php?pg=menu"><i class="icons icon-organization"></i> <?=$lang['restaurant']['menu']?></a></li>
					<li><a href="<?=path?>/restaurant.php?pg=items"><i class="fas fa-pizza-slice"></i> <?=$lang['restaurant']['items']?></a></li>
					<li><a href="<?=path?>/restaurant.php?pg=reviews"><i class="fas fa-star"></i> <?=$lang['restaurant']['reviews']?></a></li>
					<li><a href="<?=path?>/restaurant.php?pg=withdraw"><i class="fas fa-money-bill-wave"></i> <?=$lang['restaurant']['withdraw']?> (<?=dollar_sign.us_balance?>)</a></li>
			</div>
		</div>
		<div class="col-8">
			<div class="pt-cart-body">
				<?php
				switch ($pg) {
					case "orders": include __DIR__ . "/partials/restaurantorders.php"; break;
					case "menu": include __DIR__ . "/partials/restaurantmenu.php"; break;
					case "items": include __DIR__ . "/partials/restaurantitems.php"; break;
					case "details": include __DIR__ . "/partials/restaurantdetails.php"; break;
					case "booking": include __DIR__ . "/partials/restaurantbooking.php"; break;
					case "reviews": include __DIR__ . "/partials/restaurantreviews.php"; break;
					case "withdraw": include __DIR__ . "/partials/restaurantwithdraw.php"; break;

					default: include __DIR__ . "/partials/restaurantdashboard.php"; break;
				}
				?>
			</div>
		</div>
	</div>
</div>

<?php
include __DIR__."/footer.php";
