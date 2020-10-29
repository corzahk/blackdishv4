<?php


include __DIR__."/head.php";

?>

<div id="full-page-container">
<div class="pt-wrapper">
	<div class="pt-header">
		<div class="pt-header-top">
			<?=(page != "index" ?'<div class="over"><span class="pt-bg"></span></div>':"")?>

			<div class="container">
				<div class="pt-logo"><a href="<?=path?>"><img src="<?=path?>/<?=site_logo?>" alt="<?=site_title?>"></a></div>
				<div class="pt-menu">
					<ul>
						<li><a href="<?=path?>"><?=$lang['header']['home']?></a></li>
						<li><a href="<?=path?>/cuisines.php"><?=$lang['header']['explore']?></a></li>
						<li><a href="<?=path?>/restaurants.php"><?=$lang['header']['restaurants']?></a></li>
						<li><a href="<?=path?>/pages.php?id=1&t=about"><?=$lang['header']['about']?></a></li>
						<li><a href="<?=path?>/pages.php?id=2&t=contact"><?=$lang['header']['contact']?></a></li>
						<li><a href="<?=path?>/plans.php"><?=$lang['header']['plans']?></a></li>
						<li class="pt-mobile-menu">
							<a href="#"><i class="icon-menu icons"></i></a>
							<ul class="pt-drop">
								<li><a href="<?=path?>"><?=$lang['header']['home']?></a></li>
								<li><a href="<?=path?>/cuisines.php"><?=$lang['header']['explore']?></a></li>
								<li><a href="<?=path?>/restaurants.php"><?=$lang['header']['restaurants']?></a></li>
								<li><a href="<?=path?>/pages.php?id=1&t=about"><?=$lang['header']['about']?></a></li>
								<li><a href="<?=path?>/pages.php?id=2&t=contact"><?=$lang['header']['contact']?></a></li>
								<li><a href="<?=path?>/plans.php"><?=$lang['header']['plans']?></a></li>
							</ul>
						</li>
						<li class="pt-cart">
							<a href="<?=path?>/cart.php">
								<i class="icon-basket icons"></i>
								<b><?=(isset($_COOKIE['addtocart'])?count(json_decode($_COOKIE['addtocart'],true), 1)-count(json_decode($_COOKIE['addtocart'],true)):'0')?></b>
							</a>
						</li>
						<?php if(us_level): ?>
							<li class="pt-img">
								<div class="pt-thumb"><img src="<?=path?>/<?=us_photo?>" onerror="this.src='<?=nophoto?>'"></div>
							</li>
							<li class="pt-author">
								<?php
								$head_orders = db_rows("orders WHERE status = 0 and user = '".us_id."'");
								if($head_orders) echo "<b>".$head_orders."</b>";
								?>
								<span class="pt-showmenudetails"><?=us_username?> <i class="fas fa-caret-down"></i></span>
								<ul class="pt-drop">
									<?php if(us_level == 6): ?>
									<li><a href="<?=path?>/dashboard.php"><i class="icons icon-speedometer"></i> <?=$lang['header']['dashboard']?></a></li>
									<?php endif; ?>
									<li><a href="<?=path?>/myorders.php"><i class="icons icon-wallet"></i> <?=$lang['header']['my_orders']?></a></li>
									<?php if(us_plan): ?>
									<li><a href="<?=path?>/restaurant.php"><i class="fas fa-store"></i> <?=$lang['header']['your_restaurant']?></a></li>
									<?php endif; ?>
									<li><a href="#testimonialModal" data-toggle="modal"><i class="far fa-comment"></i> <?=$lang['header']['testimonial']?></a></li>
									<li><a href="#passwordModal" data-toggle="modal"><i class="icons icon-lock-open"></i> <?=$lang['header']['change_password']?></a></li>
									<li><a href="<?=path?>/userdetails.php"><i class="fas fa-pencil-alt"></i> <?=$lang['header']['edit_details']?></a></li>
									<li><a href="#" class="pt-logout"><i class="icons icon-power"></i> <?=$lang['header']['logout']?></a></li>
								</ul>
							</li>
						<?php else: ?>
							<li class="pt-login"><a data-toggle="modal" href="#loginModal"><i class="icon-user icons"></i> <?=$lang['header']['login']?></a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div><!-- End header top -->

		<?php if(page == "index"): ?>
		<div class="pt-header-content">
			<div class="container">
				<div class="pt-body">
					<h1><?=str_replace('[br]', '<br />', $lang['header']['title'])?></h1>
					<p>
						<?=$lang['header']['subtitle']?>
					</p>
					<a href="<?=path?>/cuisines.php"><?=$lang['header']['btn']?> <i class="fas fa-long-arrow-alt-right"></i></a>
					<div class="pt-info">
						<div>
							<span><i class="icons icon-clock"></i></span>
							<h3><?=$lang['header']['today']?></h3>
							<p><?=$lang['header']['working_hours']?></p>
						</div>
						<div>
							<span><i class="icons icon-phone"></i></span>
							<h3><?=$lang['header']['phone']?></h3>
							<p><?=$lang['header']['call']?></p>
						</div>
					</div>
				</div>
				<div class="pt-thumb">
					<span class="pt-bg"></span>
					<img src="<?=path?>/img/burger.png" onerror="this.src='<?=noimage?>'" />
				</div>
			</div>
		</div><!-- End header Content -->
		<?php endif; ?>
	</div><!-- End header -->
