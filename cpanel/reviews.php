<?php

?>

<div class="pt-breadcrumb">
	<div class="pt-title">
		<i class="icon-star icons ic"></i> <?=$lang['dash']['reviews']?>
		<p><a href="<?=path?>"><?=$lang['header']['dashboard']?></a> <i class="fas fa-long-arrow-alt-right"></i> <?=$lang['dash']['reviews']?></p>
	</div>
</div>

<div class="pt-resaurants">
	<div class="pt-resaurant">
		<?php
		$sql = $db->query("SELECT * FROM ".prefix."reviews ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
		if($sql->num_rows):
		while($rs = $sql->fetch_assoc()):
		?>
		<div class="pt-resaurant pt-reviews">
			<div class="modal-header">
				<div class="float-left">
					<?=fh_stars_alt($rs['stars'], 5-$rs['stars'])?>
					<b><?=$rs['title']?></b>
					<div><a href="<?=path?>/restaurants.php?id=<?=$rs['restaurant']?>&t=<?=fh_seoURL(db_get("restaurants", "name", $rs['restaurant']))?>"><?=db_get("restaurants", "name", $rs['restaurant'])?></a></div>
				</div>

				<div class="float-right">
					by <?php echo fh_user($rs['author']) ?> - <?php echo fh_ago($rs['created_at']) ?>
				</div>
			</div>
			<p><?=$rs['content']?></p>
		</div>
		<?php endwhile; ?>
		<?php else: ?>
			<div class="text-center"><?=$lang['alerts']['no-data']?></div>
		<?php endif; ?>
		<?php $sql->close(); ?>
		<?php echo fh_pagination("reviews",$limit, path."/dashboard.php?pg=reviews&") ?>
	</div>
</div>
