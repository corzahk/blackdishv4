<?php


include __DIR__."/header.php";

?>

<div class="pt-section pt-best">
	<div class="container">
		<div class="pt-section-title">
			<h3><?=$lang['home']['nearby']?></h3>
			<p><?=str_replace('[br]', '<br />', $lang['home']['nearby_desc'])?></p>
		</div>

		<div class="row">
		<?php

		$nearby = $db->query("SELECT *, ( 3959 * acos( cos( radians({$ipall['latitude']}) ) * cos( radians( latitude ) )
		 * cos( radians( longitude ) - radians({$ipall['longitude']}) ) + sin( radians({$ipall['latitude']}) )
		 * sin( radians( latitude ) ) ) ) AS distance
		FROM ".prefix."restaurants HAVING distance < 20
		ORDER BY distance LIMIT 6;") or die ($db->error);

		if($nearby->num_rows):
	 	while($nearby_rs = $nearby->fetch_assoc()):
	 	?>
		 <div class="col-3">
			 <div class="pt-item">
				 <div class="pt-thumb"><img src="<?=path?>/<?=$nearby_rs['photo']?>" alt="<?=$nearby_rs['name']?>" onerror="this.src='<?=noimage?>'"></div>
				 <div class="pt-title"><a href="<?=path?>/restaurants.php?id=<?=$nearby_rs['id']?>&t=<?=fh_seoURL($nearby_rs['name'])?>"><h3><?=$nearby_rs['name']?></h3></a></div>
				 <div class="pt-stars"><?php echo fh_stars($nearby_rs['id'], "restaurant") ?></div>
				 <div class="pt-address"><i class="fas fa-map-marker-alt"></i> <?=$nearby_rs['city']?> - <?=$countries[$nearby_rs['country']]?></div>
			 </div>
		 </div>
		 <?php endwhile; ?>
		 <?php else: ?>
			 <div class="text-center"><?=$lang['alerts']['no-data']?></div>
		 <?php endif; ?>
		 <?php $nearby->close(); ?>
		</div>
	</div>
</div>

<div class="pt-section pt-best">
	<div class="container">
		<div class="pt-section-title">
			<h3><?=$lang['home']['best']?></h3>
			<p><?=str_replace('[br]', '<br />', $lang['home']['best_desc'])?></p>
		</div>

		<div class="row">
			<?php
			$sql = $db->query("SELECT i.*, r.name AS rname FROM ".prefix."items AS i LEFT JOIN ".prefix."restaurants AS r ON(r.id = i.restaurant) WHERE i.home = 1 LIMIT 6");
			while ($rs = $sql->fetch_assoc()):
			?>
			<div class="col-4">
				<div class="pt-post">
					<div class="pt-thumb"><img src="<?=path.'/'.$rs['image']?>" onerror="this.src='<?=noimage?>'"></div>
					<div class="pt-details">
						<div class="pt-option">
							<?php if (db_get("restaurants", "neworders", $rs['restaurant'])): ?>
							<a data-toggle="modal" href="#addtocartModal" data-id="<?=$rs['id']?>" class="pt-addtobasket pt-addtocart tips"><i class="icons icon-basket"></i><b><?=$lang['home']['addtocart']?></b></a>
							<?php else: ?>
							<a class="pt-addtobasket pt-addtocart tips bg-danger"><i class="icons icon-close"></i><b><?=$lang['home']['unavailable']?></b></a>
							<?php endif; ?>
						</div>
						<a href="#" class="pt-price"><?=dollar_sign.$rs['selling_price']?></a>
						<div class="pt-title"><h1><a href="<?=path?>/restaurants.php?id=<?=$rs['restaurant']?>&t=<?=fh_seoURL($rs['rname'])?>"><?=$rs['name']?></a></h1></div>
						<div class="pt-info">
							<span><i class="icons icon-clock"></i> <?=($rs['delivery_time'] ? $rs['delivery_time'] : '--')?></span>
							<span class="pt-stars"><?php echo fh_stars($rs['id'], "item") ?></span>
						</div>
						<div class="pt-tags">
							<a href="<?=path?>/cuisines.php?id=<?=$rs['cuisine']?>&t=<?=fh_seoURL(db_get("cuisines", "name", $rs['cuisine']))?>"><?=db_get("cuisines", "name", $rs['cuisine'])?></a>
						</div>
					</div>
				</div>
			</div>
			<?php endwhile; ?>
			<?php $sql->close(); ?>
		</div><!-- End Row -->

		<div class="pt-link">
			<a href="<?=path?>/cuisines.php"><?=$lang['home']['more']?> <i class="fas fa-long-arrow-alt-right"></i></a>
		</div>

	</div><!-- End container -->

</div><!-- End section -->

<div class="pt-section">
	<div class="container">
		<div class="pt-section-title">
			<h3><?=$lang['home']['how']?></h3>
			<p><?=str_replace('[br]', '<br />', $lang['home']['how_desc'])?></p>
		</div>

		<div class="row">
			<div class="col-4">
				<div class="pt-how">
					<span><i class="fas fa-pizza-slice"></i></span>
					<h3><?=$lang['home']['how1']?></h3>
					<p><?=$lang['home']['how1_desc']?></p>
				</div>
			</div>
			<div class="col-4">
				<div class="pt-how">
					<span><i class="far fa-credit-card"></i></span>
					<h3><?=$lang['home']['how2']?></h3>
					<p><?=$lang['home']['how2_desc']?></p>
				</div>
			</div>
			<div class="col-4">
				<div class="pt-how">
					<span><i class="far fa-paper-plane"></i></span>
					<h3><?=$lang['home']['how3']?></h3>
					<p><?=$lang['home']['how3_desc']?></p>
				</div>
			</div>
		</div>

	</div>
</div><!-- End section -->


<div class="pt-section">
	<div class="container">
		<div class="pt-section-title">
			<h3><?=$lang['home']['customers']?></h3>
			<p><?=str_replace('[br]', '<br />', $lang['home']['customers_desc'])?></p>
		</div>
		<div class="pt-testimonials">
			<div class="owl-carousel owl-theme">
				<?php
				$sql = $db->query("SELECT * FROM ".prefix."testimonials WHERE status = 1 LIMIT 10");
				while ($rs = $sql->fetch_assoc()):
				?>
				<div class="item">
				<div class="pt-item">
					<div class="pt-thumb">
						<img src="<?=db_get("users", "photo", $rs['author'])?>" onerror="this.src='<?=nophoto?>'">
					</div>
					<div class="pt-content"><?=$rs['content']?></div>
					<div class="pt-stars">
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
					</div>
					<div class="pt-author"><?=db_get("users", "username", $rs['author'])?></div>
				</div>
				</div>
				<?php endwhile; ?>
				<?php $sql->close(); ?>
			</div>
		</div>
	</div>
</div><!-- End section -->


<div class="pt-section">
	<div class="container">
		<div class="pt-section-title">
			<h3><?=str_replace('[br]', '<br />', $lang['home']['help'])?></h3>
		</div>
		<div class="pt-subscribe">
			<form id="sendsubscribe">
				<div class="pt-input">
					<input type="text" name="email" placeholder="youremail@email.com" />
					<button type="submit"><?=$lang['home']['help_btn']?></button>
				</div>
			</form>
		</div>
	</div>
</div><!-- End section -->



<?php
include __DIR__."/footer.php";


$path = dirname(__FILE__).'/uploads-temp';
$fi = new FilesystemIterator($path, FilesystemIterator::SKIP_DOTS);

if(iterator_count($fi)>1){
if ($handle = opendir($path)) {
  while (false !== ($file = readdir($handle))) {
    if (time() > (filectime($path.'/'.$file) + 86400)) {
      if(!preg_match('/\.html$/i', $file)) {
				if(file_exists($path.'/'.$file))
        	unlink($path.'/'.$file);
      }
    }
  }
}
}
