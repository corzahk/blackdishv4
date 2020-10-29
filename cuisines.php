<?php


include __DIR__."/header.php";

?>

<div class="pt-breadcrumb-p">
	<div class="container">
		<h3><?=$lang['cuisines']['title']?></h3>
		<p><?=$lang['cuisines']['desc']?></p>
	</div>
</div>

<div class="container">

<?php if ($id): ?>

	<div class="row">
		<?php
		$sql = $db->query("SELECT * FROM ".prefix."items  WHERE cuisine = '{$id}' ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
		if($sql->num_rows):
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
					<div class="pt-title"><h1><a href="#"><?=$rs['name']?></a></h1></div>
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
		<?php else: ?>
		<div class="text-center"><?=$lang['alerts']['no-data']?></div>
		<?php endif; ?>
		<?php echo fh_pagination("items  WHERE cuisine = '{$id}'",$limit, path."/cuisines.php?id={$id}&") ?>

	</div><!-- End Row -->

<?php else: ?>

	<div class="row">
		<?php
		$sql = $db->query("SELECT * FROM ".prefix."cuisines ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
		if($sql->num_rows):
		while($rs = $sql->fetch_assoc()):
		?>
		<div class="col-3">
			<div class="pt-item">
				<a href="<?=path?>/cuisines.php?id=<?=$rs['id']?>&t=<?=fh_seoURL($rs['name'])?>">
				<div class="pt-thumb"><img src="<?=path?>/<?=$rs['image']?>" alt="<?=$rs['name']?>" onerror="this.src='<?=noimage?>'"></div>
				<div class="pt-title"><h3><?=$rs['name']?></h3></div>
				</a>
			</div>
		</div>
		<?php endwhile; ?>
		<?php else: ?>
			<div class="text-center"><?=$lang['alerts']['no-data']?></div>
		<?php endif; ?>
		<?php $sql->close(); ?>
	</div>
	<?php echo fh_pagination("cuisines",$limit, path."/cuisines.php?") ?>

<?php endif; ?>

</div>


<?php
include __DIR__."/footer.php";
