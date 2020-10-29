<div class="pt-breadcrumb">
	<div class="pt-title">
		<i class="fas fa-pizza-slice ic"></i>
		<?php if ($request == "new"): ?>
			<?php if( db_rows("items WHERE id = '{$id}' && author = '".us_id."'") ): ?>
				<?=$lang['restaurant']['it_edit']?>
				<?php else: ?>
					<?php
					if(!fh_access("items")){
						fh_go(path);
						exit;
					}
					?>
				<?=$lang['restaurant']['it_new']?>
			<?php endif; ?>
		<?php else: ?>
				<?=$lang['restaurant']['it_all']?>
		<?php endif; ?>
	</div>
	<?php if ($request != "new"): ?>
	<?php if (fh_access('items')): ?>
	<div class="pt-options">
		<a href="<?php echo path ?>/restaurant.php?pg=items&request=new" class="pt-btn"><i class="fas fa-plus"></i> <?=$lang['restaurant']['it_new']?></a>
	</div>
	<?php endif; ?>
	<?php endif; ?>
</div>

<?php if ($request == "new"): ?>
<?php include __DIR__ . '/newitem.php'; ?>
<?php else: ?>
<div class="pt-resaurants">
	<div class="pt-resaurant">
		<div class="table-responsive">
		<table class="table">
			<thead>
				<th colspan="2"><?=$lang['restaurant']['it_name']?></th>
				<th class="text-center"><?=$lang['restaurant']['it_orders']?></th>
				<th class="text-center"><?=$lang['created_at']?></th>
				<th class="text-center"><?=$lang['updated_at']?></th>
				<th></th>
			</thead>
			<tbody>
				<?php
				$sql_where = ($mi ? "&& i.menu = '{$mi}'" : '');
				$sql = $db->query("SELECT i.*, r.name AS rname FROM ".prefix."items AS i LEFT JOIN ".prefix."restaurants AS r ON(i.restaurant = r.id) WHERE i.author = '".us_id."' {$sql_where} ORDER BY i.id DESC");
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
					<td class="text-center"><?=fh_ago($rs['created_at'])?></td>
					<td class="text-center"><?=($rs['updated_at']?fh_ago($rs['updated_at']):'--')?></td>
					<td class="pt-dot-options">
						<a class="pt-options-link"><i class="fas fa-ellipsis-h"></i></a>
						<ul class="pt-drop">
							<li><a href="<?=path?>/restaurant.php?pg=items&request=new&id=<?=$rs['id']?>"><i class="far fa-edit"></i> <?=$lang['restaurant']['de_edit']?></a></li>
							<li><a href="#" class="pt-delete" data-type="item" data-id="<?=$rs['id']?>"><i class="fas fa-trash-alt"></i> <?=$lang['restaurant']['de_delete']?></a></li>
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
	<?php echo fh_pagination("items WHERE author = '".us_id."'",$limit, path."/restaurant.php?pg=items&".($mi ? "mi={$mi}&" : '')) ?>
</div>


<?php endif; ?>
