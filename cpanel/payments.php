<?php

?>

<div class="pt-breadcrumb">
	<div class="pt-title">
		<i class="fas fa-money-bill-wave ic"></i> <?=$lang['dash']['payments']?>
		<p><a href="<?=path?>"><?=$lang['header']['dashboard']?></a> <i class="fas fa-long-arrow-alt-right"></i> <?=$lang['dash']['payments']?></p>
	</div>
</div>

<div class="pt-resaurants">
	<div class="pt-resaurant">
		<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th scope="col"><?=$lang['dash']['p_user']?></th>
				<th scope="col" class="text-center"><?=$lang['dash']['u_plan']?></th>
				<th scope="col" class="text-center"><?=$lang['dash']['p_amount']?></th>
				<th scope="col" class="text-center"><?=$lang['dash']['p_paymentid']?></th>
				<th scope="col" class="text-center"><?=$lang['dash']['p_payerid']?></th>
				<th scope="col" class="text-center"><?=$lang['created_at']?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$sql = $db->query("SELECT * FROM ".prefix."payments ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die ($db->error);
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
					<span class="badge bg-<?=( $rs['plan']=='1' ? 'gy' : ( $rs['plan']=='2' ? 'gr' : ( $rs['plan']=='3' ? 'v' :  ( $rs['plan']=='4' ? 'o' : ''))))?>">
						<?=($rs['plan']?db_get("plans", "plan", $rs['plan']):'--')?>
					</span>
				</td>
				<td class="text-center"><?=($rs['price']?dollar_sign.$rs['price']:'--')?></td>
				<td class="text-center"><?=($rs['payment_id']?$rs['payment_id']:'--')?></td>
				<td class="text-center"><?=($rs['payer_id']?$rs['payer_id']:'--')?></td>
				<td class="text-center"><?=fh_ago($rs['date'])?></td>
			</tr>
			<?php
			endwhile;
			echo '<tr><td colspan="6">'.fh_pagination("payments",$limit, path."/dashboard.php?pg=payments&").'</td></tr>';
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
