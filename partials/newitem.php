<?php


if( $id && !db_rows("items WHERE id = '{$id}' && author = '".us_id."'") && us_level != 6 ){
	echo alerts("You don't have permession for this page!", "danger");
	exit;
}

$rs = ($id ? db_rs("items WHERE id = '{$id}'") : '');
?>

<form id="senditem">
<div class="pt-resaurants pt-restaurantspage">
	<div class="pt-resaurant">

		<div class="form-group pt-imginp">
			<label><?=$lang['restaurant']['item_name']?></label>
			<input type="text" name="name" value="<?php echo ($rs ? $rs['name'] : '') ?>" placeholder="<?=$lang['restaurant']['item_name']?>">
			<input type="hidden" name="image" rel="#dropZone" value="">
			<input type="hidden" name="oimage" value="<?php echo ($rs ? $rs['image'] : '') ?>">
			<div class="file-upload">
			  <div class="file-select">
			    <div class="file-select-button" id="fileName"><i class="fas fa-images"></i></div>
			    <input type="file" name="chooseFile" id="chooseFile" rel="answerfile">
			  </div>
			</div>
			<div id="thumbnails" class="thumbnails"><img src="<?php echo ($rs ? path.'/'.$rs['image'] : '') ?>" onerror="this.src='<?=noimage?>'" /></div>
		</div>
		<div class="form-row">
			<div class="col">
				<div class="form-group">
					<label><?=$lang['restaurant']['selling_price']?> <b class="text-danger small">*</b></label>
        	<input type="text" name="price" value="<?php echo ($rs ? $rs['selling_price'] : '') ?>" placeholder="<?=$lang['restaurant']['selling_price']?>" class="money">
        </div>
			</div>
			<div class="col">
				<div class="form-group">
					<label><?=$lang['restaurant']['main_price']?></label>
        	<input type="text" name="reduce" value="<?php echo ($rs ? $rs['reduce_price'] : '') ?>" placeholder="<?=$lang['restaurant']['main_price']?>" class="money">
        </div>
			</div>
		</div>
		<div class="form-group">
			<label><?=$lang['restaurant']['item_restaurant']?> <b class="text-danger small">*</b></label>
			<select class="selectpicker" data-live-search="true" data-width="100%" name="resto" title="<?=$lang['restaurant']['item_restaurant']?>...">
				<?php
				$sql_r = $db->query("SELECT * FROM ".prefix."restaurants WHERE author = '".us_id."' ORDER BY name ASC");
				if($sql_r->num_rows):
				while($rs_r = $sql_r->fetch_assoc()):
				?>
				<option data-tokens="<?=$rs_r['name']?>" value="<?=$rs_r['id']?>"<?=($rs && $rs_r['id'] == $rs['restaurant'] ? 'selected' : '')?>><?=$rs_r['name']?></option>
				<?php endwhile; ?>
				<?php endif; ?>
				<?php $sql_r->close(); ?>
			</select>
    </div>
		<div class="form-row">
			<div class="col-6">
				<div class="form-group">
					<label><?=$lang['restaurant']['item_menu']?> <b class="text-danger small">*</b></label>
					<select class="selectpicker" data-live-search="true" data-width="100%" name="menu" title="<?=$lang['restaurant']['item_menu']?>...">
						<?php
						$sql_m = $db->query("SELECT * FROM ".prefix."menus WHERE author = '".us_id."' ORDER BY name ASC");
						if($sql_m->num_rows):
						while($rs_m = $sql_m->fetch_assoc()):
						?>
						<option data-tokens="<?=$rs_m['name']?>" value="<?=$rs_m['id']?>" data-subtext="<?=db_get("restaurants", "name", $rs_m['restaurant'])?>"<?=($rs && $rs_m['id'] == $rs['menu'] ? 'selected' : '')?>><?=$rs_m['name']?></option>
						<?php endwhile; ?>
						<?php endif; ?>
						<?php $sql_m->close(); ?>
					</select>
        </div>
			</div>
			<div class="col-6">
				<div class="form-group">
					<label><?=$lang['restaurant']['item_cuisine']?> <b class="text-danger small">*</b></label>
					<select class="selectpicker" data-live-search="true" data-width="100%" name="cuisine" title="<?=$lang['restaurant']['item_cuisine']?>...">
						<?php
						$sql_c = $db->query("SELECT * FROM ".prefix."cuisines ORDER BY name ASC");
						if($sql_c->num_rows):
						while($rs_c = $sql_c->fetch_assoc()):
						?>
						<option data-tokens="<?=$rs_c['name']?>" value="<?=$rs_c['id']?>"<?=($rs && in_array($rs_c['id'], explode(',',$rs['cuisine'])) ? ' selected' : '')?>><?=$rs_c['name']?></option>
						<?php endwhile; ?>
						<?php endif; ?>
						<?php $sql_c->close(); ?>
					</select>
        </div>
			</div>
		</div>


    <div class="form-group">
			<label><?=$lang['restaurant']['ingredients']?></label>
			<input type="text" name="ingredients" value="<?php echo ($rs ? $rs['ingredients'] : '') ?>" placeholder="<?=$lang['restaurant']['ingredients']?>">
    </div>

    <div class="form-group">
			<label><?=$lang['restaurant']['description']?></label>
			<textarea name="desc" rows="8" placeholder="<?=$lang['restaurant']['description']?>"><?php echo ($rs ? $rs['description'] : '') ?></textarea>
    </div>

		<div class="form-row">
			<div class="col-6">
				<div class="form-group"><label><?=$lang['restaurant']['delivery_price']?></label><input type="text" name="delivery_price" placeholder="<?=$lang['restaurant']['delivery_price']?>" value="<?php echo ($rs ? $rs['delivery_price'] : '') ?>" class="money"></div>
			</div>
			<div class="col-6">
				<div class="form-group"><label><?=$lang['restaurant']['delivery_time']?></label><input type="text" name="delivery_time" placeholder="10-15 min" value="<?php echo ($rs ? $rs['delivery_time'] : '') ?>"></div>
			</div>
		</div>

		<div class="mb-4">
			<h6 class="pt-addSize"><?=$lang['restaurant']['sizes']?> <i class="fas fa-plus-circle"></i></h6>
			<?php if ($rs && !empty($rs['sizes'])): ?>
				<?php foreach (unserialize($rs['sizes']) as $k => $v): ?>
					<div class="size_<?=$k?>">
						<div class="form-row">
							<div class="col-4">
								<div class="form-group">
									<input type="text" name="size[<?=$k?>][name]" placeholder="<?=$lang['restaurant']['sizes_name']?>" value="<?=$v['name']?>">
								</div>
							</div>
							<div class="col-4">
								<div class="form-group">
									<input type="text" name="size[<?=$k?>][price]" placeholder="<?=$lang['restaurant']['sizes_price']?>" class="money"value="<?=$v['price']?>">
								</div>
							</div>
							<div class="col-4">
								<div class="form-group">
									<input type="text" name="size[<?=$k?>][reduce]" placeholder="<?=$lang['restaurant']['sizes_reduce']?>" class="money" value="<?=(isset($v['reduce']) ? $v['reduce']: '')?>">
									<i class="fas fa-minus-circle pt-removeSize"></i>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<div class="mb-4">
			<h6 class="pt-addExtra"><?=$lang['restaurant']['extra']?> <i class="fas fa-plus-circle"></i></h6>
			<?php if ($rs && !empty($rs['extra'])): ?>
				<?php foreach (unserialize($rs['extra']) as $k => $v): ?>
					<div class="extra_<?=$k?>">
						<div class="form-row">
							<div class="col-8">
								<div class="form-group">
									<input type="text" name="extra[<?=$k?>][name]" placeholder="<?=$lang['restaurant']['sizes_name']?>" value="<?=$v['name']?>">
								</div>
							</div>
							<div class="col-4">
								<div class="form-group">
									<input type="text" name="extra[<?=$k?>][price]" placeholder="<?=$lang['restaurant']['sizes_price']?>" class="money" value="<?=$v['price']?>">
									<i class="fas fa-minus-circle pt-removeExtra"></i>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<div class="pt-msg"></div>

    <div class="modal-footer">
      <button type="submit" class="pt-btn"><?=$lang['restaurant']['btn']?></button>
			<input type="hidden" name="id" value="<?php echo ($rs ? $rs['id'] : '') ?>">
    </div>
	</div>
</div>
</form>
