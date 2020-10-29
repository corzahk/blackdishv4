<div class="pt-breadcrumb">
	<div class="pt-title">
		<i class="icon-notebook icons ic"></i> Items
		<p>
			<a href="<?=path?>">Dashboard</a> <i class="fas fa-long-arrow-alt-right"></i> Items
		</p>
	</div>

	<div class="pt-options">
		<a href="<?=path?>/dashboard.php?pg=items&request=new" class="pt-btn"><i class="fas fa-plus"></i> Create an Item</a>
	</div>
</div>

<?php if ($request == "new"): ?>
	<div class="pt-box p-5">
<?php include __DIR__ . '/../partials/newitem.php'; ?>
</div>
<?php else: ?>
<div class="pt-resaurants">
	<div class="pt-resaurant">
		<div class="table-responsive">
		<table class="table">
			<thead>
				<th colspan="2">Item name</th>
				<th class="text-center">Orders</th>
				<th class="text-center">Author</th>
				<th class="text-center">Created at</th>
				<th class="text-center">Updated at</th>
				<th></th>
			</thead>
			<tbody>
				<?php
				$sql_where = ($mi ? "WHERE i.menu = '{$mi}'" : '');
				$sql = $db->query("SELECT i.*, r.name AS rname FROM ".prefix."items AS i LEFT JOIN ".prefix."restaurants AS r ON(i.restaurant = r.id) {$sql_where} ORDER BY i.id DESC");
				if($sql->num_rows):
				while($rs = $sql->fetch_assoc()):
				?>
				<tr>
					<th width="1"><div class="pt-thumb m-0"><img src="<?=path?>/<?=$rs['image']?>" onerror="this.src='<?=noimage?>'"></div></th>
					<td width="40%">
						<h3><a href="<?=path?>/restaurants.php?id=<?=$rs['restaurant']?>&t=<?=fh_seoURL($rs['rname'])?>"><?=$rs['name']?></a></h3>
						<p><span><i class="fas fa-store"></i> <?=$rs['rname']?></span></p>
					</td>
					<td class="text-center"><?php echo db_rows("orders WHERE item = '{$rs['id']}'") ?></td>
					<td class="text-center"><?=fh_user($rs['author'])?></td>
					<td class="text-center"><?=fh_ago($rs['created_at'])?></td>
					<td class="text-center"><?=($rs['updated_at']?fh_ago($rs['updated_at']):'--')?></td>
					<td class="pt-dot-options">
						<a class="pt-options-link"><i class="fas fa-ellipsis-h"></i></a>
						<ul class="pt-drop">
							<li><a href="#" class="pt-itemhome" data-id="<?=$rs['id']?>"><i class="fas fa-home"></i> <?=$lang['dash']['athome']?></a></li>
							<li><a href="<?=path?>/dashboard.php?pg=items&request=new&id=<?=$rs['id']?>"><i class="far fa-edit"></i> Edit</a></li>
							<li><a href="#" class="pt-delete" data-type="item" data-id="<?=$rs['id']?>"><i class="fas fa-trash-alt"></i> Delete</a></li>
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
	<?php echo fh_pagination("items",$limit, path."/dashboard.php?pg=items&".($mi ? "mi={$mi}&" : '')) ?>
</div>


<?php endif; ?>
