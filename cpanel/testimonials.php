<?php

?>

<div class="pt-breadcrumb">
	<div class="pt-title">
		<i class="icon-speech icons ic"></i> <?=$lang['header']['testimonial']?>
		<p>
			<a href="<?=path?>"><?=$lang['header']['dashboard']?></a> <i class="fas fa-long-arrow-alt-right"></i> <?=$lang['header']['testimonial']?>
		</p>
	</div>
</div>

<div class="pt-resaurants">
	<div class="pt-resaurant">
		<?php
		$sql = $db->query("SELECT * FROM ".prefix."testimonials ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
		if($sql->num_rows):
		while($rs = $sql->fetch_assoc()):
		?>
		<div class="pt-resaurant pt-reviews<?=(!$rs['status']?' bg-status':'')?>">
			<div class="modal-header">
				<div class="float-left">
						by <?php echo fh_user($rs['author']) ?> - <?php echo fh_ago($rs['created_at']) ?>
				</div>

				<div class="float-right">
					<div>
					<a href="#" class="pt-btn tips pt-delete" data-id="<?=$rs['id']?>" data-type="testimonial"><i class="fas fa-trash-alt"></i><b><?=$lang['dash']['delete']?></b></a>
					<?php if (!$rs['status']): ?>
						<a href="#" class="pt-btn tips bg-gr pt-testimonialstatus" data-id="<?=$rs['id']?>" data-type="publish"><i class="fas fa-check"></i><b><?=$lang['dash']['publish']?></b></a>
					<?php else: ?>
						<a href="#" class="pt-btn tips bg-r pt-testimonialstatus" data-id="<?=$rs['id']?>" data-type="unpublish"><i class="fas fa-times"></i><b><?=$lang['dash']['unpublish']?></b></a>
					<?php endif; ?>
					</div>
				</div>
			</div>
			<p><?=$rs['content']?></p>
		</div>
		<?php endwhile; ?>
		<?php else: ?>
			<div class="text-center"><?=$lang['alerts']['no-data']?></div>
		<?php endif; ?>
		<?php $sql->close(); ?>
		<?php echo fh_pagination("testimonials",$limit, path."/dashboard.php?pg=testimonials&") ?>
	</div>
</div>
