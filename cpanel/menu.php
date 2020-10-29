<div class="pt-breadcrumb">
	<div class="pt-title">
		<i class="icon-layers icons ic"></i> Foods Menu
		<p>
			<a href="<?=path?>">Dashboard</a> <i class="fas fa-long-arrow-alt-right"></i> Foods Menu
		</p>
	</div>
	<div class="pt-options">
		<a data-toggle="modal" href="#myModal" class="pt-btn"><i class="fas fa-plus"></i> Create a Menu</a>
	</div>
</div>

<div class="pt-resaurants">
	<div class="pt-resaurant">
		<div class="table-responsive">
		<table class="table">
			<thead>
				<th colspan="2">Menu name</th>
				<th class="text-center">Items</th>
				<th class="text-center">Created at</th>
				<th class="text-center">Updated at</th>
				<th></th>
			</thead>
			<tbody>
				<?php
				$mi = $mi ? "WHERE m.restaurant = '{$mi}'" : '';
				$sql = $db->query("SELECT m.*, r.name AS rname, r.photo FROM ".prefix."menus AS m LEFT JOIN ".prefix."restaurants AS r ON(m.restaurant = r.id) {$mi} ORDER BY m.id DESC LIMIT {$startpoint} , {$limit}");
				if($sql->num_rows):
				while($rs = $sql->fetch_assoc()):
				?>
				<tr>
					<th width="1"><div class="pt-thumb"><img src="<?=path?>/<?=$rs['photo']?>" alt="<?=$rs['rname']?>" onerror="this.src='<?=noimage?>'"></div></th>
					<td width="40%">
						<h3><a href="<?=path?>/restaurants.php?id=<?=$rs['restaurant']?>&t=<?=fh_seoURL($rs['rname'])?>"><?=$rs['name']?></a></h3>
						<p><span><i class="fas fa-store"></i> <?=$rs['rname']?></span></p>
					</td>
					<td class="text-center"><?php echo db_rows("items WHERE menu = '{$rs["id"]}'") ?></td>
					<td class="text-center"><?=fh_ago($rs['created_at'])?></td>
					<td class="text-center"><?=($rs['updated_at']?fh_ago($rs['updated_at']):'--')?></td>
					<td class="pt-dot-options">
						<a class="pt-options-link"><i class="fas fa-ellipsis-h"></i></a>
						<ul class="pt-drop">
							<li><a href="<?=path?>/dashboard.php?pg=items&mi=<?=$rs['id']?>"><i class="fas fa-pizza-slice"></i> Items</a></li>
							<li><a data-toggle="modal" href="#myModal" class="pt-editmenulink" data-id="<?=$rs['id']?>"><i class="far fa-edit"></i> Edit</a></li>
							<li><a href="#" class="pt-delete" data-type="menu" data-id="<?=$rs['id']?>"><i class="fas fa-trash-alt"></i> Delete</a></li>
						</ul>
					</td>
				</tr>
				<?php endwhile; ?>
				<?php else: ?>
					<tr>
						<td colspan="7" class="text-center"><?=$lang['alerts']['no-data']?></td>
					</tr>
				<?php endif; ?>
				<?php $sql->close(); ?>
			</tbody>
		</table>
		</div>
	</div>
	<?php echo fh_pagination("menus",$limit, path."/dashboard.php?pg=menu&") ?>
</div>

<?php include __DIR__ . '/../partials/newmenu.php'; ?>
