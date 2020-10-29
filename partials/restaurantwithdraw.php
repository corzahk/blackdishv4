<div class="pt-breadcrumb">
	<div class="pt-title"><i class="fas fa-hand-holding-usd ic"></i> <?=$lang['dash']['withdraw']?></div>
	<div class="pt-options">
		<a data-toggle="modal" href="#myModal" class="pt-btn"><i class="fas fa-plus"></i> <?=$lang['restaurant']['new_withdraw']?></a>
	</div>
</div>

<div class="pt-resaurants">
	<div class="pt-resaurant">
		<div class="table-responsive">
		<table class="table">
			<thead>
			<th scope="col"><?=$lang['dash']['p_amount']?></th>
				<th scope="col" class="text-center"></th>
				<th scope="col" class="text-center"><?=$lang['created_at']?></th>
				<th scope="col" class="text-center"><?=$lang['accepted_at']?></th>
			</thead>
			<tbody>
				<?php
				$sql = $db->query("SELECT * FROM ".prefix."withdraws where author = '".us_id."' ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die ($db->error);
				if($sql->num_rows):
				while($rs = $sql->fetch_assoc()):
				?>
				<tr>
				<td width="30%"><b><?=($rs['price']?dollar_sign.$rs['price']:'--')?></b></td>
					<td class="text-center">
						<span class="badge text-light bg-<?=( $rs['status']=='0' ? 'gy' : ( $rs['status']=='1' ? 'gr' : 'r'))?>">
							<?=( $rs['status']=='0' ? 'In proccess' : ( $rs['status']=='1' ? 'Completed' : 'Declined'))?>
						</span>
					</td>
					<td class="text-center"><?=( $rs['created_at'] ? fh_ago($rs['created_at']) : '--')?></td>
					<td class="text-center"><?=( $rs['accepted_at'] ? fh_ago($rs['accepted_at']) : '--')?></td>
				</tr>
				<?php
				endwhile;
				echo '<tr><td colspan="6">'.fh_pagination("withdraws where author = '".us_id."'",$limit, path."/dashboard.php?pg=withdraw&").'</td></tr>';
				else:
				?>
					<tr>
						<td colspan="7" class="text-center"><?=$lang['alerts']['no-data']?></td>
					</tr>
				<?php endif; ?>
				<?php $sql->close(); ?>
			</tbody>
		</table>
		</div>
	</div>
	<?php echo fh_pagination("menus WHERE author = '".us_id."'",$limit, path."/restaurant.php?pg=menu&") ?>
</div>

<?php include __DIR__ . '/newwithdraw.php'; ?>
