<?php

?>

<div class="pt-breadcrumb">
	<div class="pt-title">
		<i class="fas fa-hand-holding-usd ic"></i> <?=$lang['dash']['withdraw']?>
		<p><a href="<?=path?>"><?=$lang['header']['dashboard']?></a> <i class="fas fa-long-arrow-alt-right"></i> <?=$lang['dash']['withdraw']?></p>
	</div>
</div>

<div class="pt-resaurants">
	<div class="pt-resaurant">
		<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th scope="col"><?=$lang['dash']['p_user']?></th>
				<th scope="col" class="text-center"></th>
				<th scope="col" class="text-center"><?=$lang['dash']['p_amount']?></th>
				<th scope="col" class="text-center"><?=$lang['dash']['p_paymentid']?></th>
				<th scope="col" class="text-center"><?=$lang['created_at']?></th>
				<th scope="col" class="text-center"><?=$lang['accepted_at']?></th>
				<th scope="col" class="text-center"></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$sql = $db->query("SELECT * FROM ".prefix."withdraws ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die ($db->error);
			if($sql->num_rows):
			while($rs = $sql->fetch_assoc()):
			?>
			<tr>
				<td width="40%">
					<div class="pt-thumb">
						<img src="<?=db_get("users", "photo", $rs['author'])?>" onerror="this.src='<?=nophoto?>'" />
					</div>
					<a href="#" class="pt-name"><?=fh_user($rs['author'])?></a>
				</td>
				<td class="text-center">
					<span class="badge bg-<?=( $rs['status']=='0' ? 'gy' : ( $rs['status']=='1' ? 'gr' : 'r'))?>">
						<?=( $rs['status']=='0' ? 'In proccess' : ( $rs['status']=='1' ? 'Completed' : 'Declined'))?>
					</span>
				</td>
				<td class="text-center"><b><?=($rs['price']?dollar_sign.$rs['price']:'--')?></b></td>
				<td class="text-center"><?=($rs['email']?$rs['email']:'--')?></td>
				<td class="text-center"><?=fh_ago($rs['created_at'])?></td>
				<td class="text-center"><?=( $rs['accepted_at'] ? fh_ago($rs['accepted_at']) : '--')?></td>
				<td class="pt-dot-options">
					<a class="pt-options-link"><i class="fas fa-ellipsis-h"></i></a>
					<ul class="pt-drop">
						<li><a href="#" class="pt-accept" data-id="<?=$rs['id']?>"><i class="fas fa-check"></i> <?=$lang['dash']['accept']?></a></li>
						<li><a href="#" class="pt-refuse" data-id="<?=$rs['id']?>"><i class="fas fa-times"></i> <?=$lang['dash']['refuse']?></a></li>
					</ul>
				</td>
			</tr>
			<?php
			endwhile;
			echo '<tr><td colspan="6">'.fh_pagination("withdraws",$limit, path."/dashboard.php?pg=withdraw&").'</td></tr>';
			else:
				?>
				<tr>
					<td colspan="6">
						<?=fh_alerts($lang['alerts']["no-data"], "info")?>
					</td>
				</tr>
				<?php
			endif;
			$sql->close();
			?>
		</tbody>
	</table>
	</div>
	</div>
</div>
