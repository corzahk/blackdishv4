<?php

$item_sql = $db->query("SELECT * FROM ".prefix."items WHERE id = '{$id}'");
if($item_sql->num_rows):
$item_rs = $item_sql->fetch_assoc();
?>

<div class="media">
	<div class="media-left">
		<div class="pt-thumb"><img src="<?=path.'/'.$item_rs['image']?>" alt="<?=$item_rs['name']?>" onerror="this.src='<?=noimage?>'"></div>
	</div>
		<div class="media-body">
			<h3><?=$item_rs['name']?></h3>
			<div class="pt-quantity">
				<i class="fas fa-minus pt-minus"></i>
				<input type="text" name="item_quantity" value="1" disabled>
				<i class="fas fa-plus pt-plus"></i>
			</div>
			<?php if($item_rs['sizes']): ?>
			<div class="pt-sizes form-inline">
				<?php
				$x = 0;
				foreach(unserialize($item_rs['sizes']) as $k => $v):
					$x++;
				?>
					<div class="form-group">
						<input type="radio" name="item_size" value="<?=$k?>" data-price="<?=$v['price']?>" class="choice custom<?=($x==1?' checked':'')?>" id="c<?=$k?>" <?=($x==1?' checked':'')?>>
						<label for="c<?=$k?>"><b><?=$v['name']?></b></label>
					</div>
				<?php endforeach; ?>
			</div>
			<?php else: ?>
				<input type="hidden" name="item_hideen_size" data-price="<?=$item_rs['selling_price']?>" class="checked">
			<?php endif; ?>

			<span class="pt-ingredient"><i class="fas fa-utensils"></i> <b>Ingredientes:</b> <?=$item_rs['ingredients']?></span>
			<span class="pt-ingredient"><i class="fas fa-utensils"></i> <b>Ver AR:</b> </span>
			<textarea name="item_note" placeholder="Agregar extra"></textarea>
		</div>
</div>
<div class="pt-price-det">
	<div class="pt-price pt-totalprice"><?=dollar_sign.$item_rs['selling_price']?></div>
	<?php if($item_rs['reduce_price'] && $item_rs['reduce_price'] != $item_rs['selling_price']): ?>
	<div class="pt-reduce"><?=dollar_sign.$item_rs['reduce_price']?></div>
	<?php endif; ?>
	<button type="button" class="pt-btn pt-buytocart" data-buy="false">Agregar carrito</button>
	<button type="submit" class="pt-buy" data-buy="true">Comprar</button>
</div>

<ul class="nav nav-tabs">
	<?php if($item_rs['extra']): ?>
	<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#homes">Extra</a></li>
	<?php endif; ?>
	<?php if($item_rs['description']): ?>
	<li class="nav-item"><a class="nav-link<?=(!$item_rs['extra']?' active':'')?>" data-toggle="tab" href="#menus1">Description</a></li>
	<?php endif; ?>
	<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menus2">Reviews</a></li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
	<?php if($item_rs['extra']): ?>
	<div class="tab-pane active container" id="homes">
		<table class="table">
			<?php foreach(unserialize($item_rs['extra']) as $k => $v): ?>
				<tr>
					<td><?=$v['name']?></td>
					<td>
						<?=dollar_sign.$v['price']?>
						<a href="#" class="pt-addexratoitem" data-price="<?=$v['price']?>" data-id="<?=$k?>"><i class="fas fa-plus-circle"></i></a>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<?php endif; ?>
	<?php if($item_rs['description']): ?>
	<div class="tab-pane<?=(!$item_rs['extra']?' active':'')?> container" id="menus1">
		<div class="pt-desc"><?=nl2br($item_rs['description'])?></div>
	</div>
	<?php endif; ?>
	<div class="tab-pane container" id="menus2">
		<?php
		$sql_review = $db->query("SELECT * FROM ".prefix."reviews WHERE item = '{$id}' ORDER BY id DESC");
		if($sql_review->num_rows):
		while($rs_review = $sql_review->fetch_assoc()):
		?>
		<div class="pt-resaurant pt-reviews">
				<div class="modal-header">
					<div class="float-left">
						<?=fh_stars_alt($rs_review['stars'], 5-$rs_review['stars'])?>
						<b><?=$rs_review['title']?></b>
					</div>

					<div class="float-right">
						by <?php echo fh_user($rs_review['author']) ?> - <?php echo fh_ago($rs_review['created_at']) ?>
					</div>
				</div>
				<p><?=$rs_review['content']?></p>
		</div>
		<?php
		endwhile;
		else:
		?>
		<div class="text-center"><?=$lang['alerts']['no-data']?></div>
		<?php
		endif;
		$sql_review->close();
		?>
	</div>
</div>
<input type="hidden" name="item_id" value="<?=$item_rs['id']?>">
<input type="hidden" name="item_price" value="<?=$item_rs['selling_price']?>">
<input type="hidden" name="item_quantities" value="1">
<input type="hidden" name="item_delivery_price" value="<?=$item_rs['delivery_price']?>">
<?php
endif;
?>
