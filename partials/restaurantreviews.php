<div class="pt-breadcrumb">
	<div class="pt-title"><i class="icon-star icons ic"></i> <?=$lang['restaurant']['reviews']?></div>
</div>

<div class="pt-resaurants">
	<div class="pt-resaurant">
		<?php
		$sql = $db->query("SELECT * FROM ".prefix."reviews WHERE user = '".us_id."' ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
		if($sql->num_rows):
		while($rs = $sql->fetch_assoc()):
		?>
		<div class="pt-resaurant pt-reviews">
				<div class="modal-header">
					<div class="float-left">
						<?=fh_stars_alt($rs['stars'], 5-$rs['stars'])?>
						<b><?=$rs['title']?></b>
					</div>

					<div class="float-right">
						<?=$lang['restaurant']['by']?> <?php echo fh_user($rs['author']) ?> - <?php echo fh_ago($rs['created_at']) ?>
					</div>
				</div>
				<p><?=$rs['content']?></p>
		</div>
		<?php endwhile; ?>
		<?php else: ?>
			<div class="text-center"><?=$lang['alerts']['no-data']?></div>
		<?php endif; ?>
		<?php $sql->close(); ?>
	</div>
	<?php echo fh_pagination("reviews WHERE user = '".us_id."'",$limit, path."/restaurant.php?pg=reviews&") ?>
</div>
