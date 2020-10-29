<?php

?>

<div class="pt-breadcrumb">
	<div class="pt-title">
		<i class="icon-notebook icons ic"></i> <?=$lang['header']['restaurants']?>
		<p><a href="<?=path?>"><?=$lang['header']['dashboard']?></a> <i class="fas fa-long-arrow-alt-right"></i> <?=$lang['header']['restaurants']?></p>
	</div>

	<div class="pt-options">
		<a href="<?=path?>/dashboard.php?pg=restaurants&request=new" class="pt-btn"><i class="fas fa-plus"></i> <?=$lang['restaurant']['de_new']?></a>
	</div>
</div>


<div class="pt-resaurants">
	<div class="pt-resaurant">
		<?php
		if( $request == "new" ):

			if($request == "new"){
				$rs = ($id ? db_rs("restaurants WHERE id = '".$id."' LIMIT 1") : '');

			} else {
				$rs = db_rs("restaurants WHERE author = '".us_id."' LIMIT 1");
				$rs["working_hours"] = json_decode($rs["working_hours"], true);
			}
		?>


		<form id="sendrestaurant">

			<div class="modal-body">
				<ul class="nav nav-tabs">
					<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home"><?=$lang['restaurant']['de_basic']?></a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu1"><?=$lang['restaurant']['de_location']?></a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu2"><?=$lang['restaurant']['de_album']?></a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu3"><?=$lang['restaurant']['de_social']?></a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu4"><?=$lang['restaurant']['de_hours']?></a></li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane active container" id="home">

						<div class="form-group">
							<label><?=$lang['restaurant']['de_name']?>: <small class="text-danger">*</small></label>
							<input type="text" name="name" value="<?php echo ($rs ? $rs['name'] : '') ?>" placeholder="Restaurant name<?=$lang['restaurant']['de_hours']?>">
						</div>
						<div class="form-group">
							<label><?=$lang['restaurant']['de_phone']?>: <small class="text-danger">*</small></label>
							<div class="pt-phone">
								<div class="pt-flags">
									<select class="selectpicker" data-live-search="true" data-width="100%" name="phone_code">
										<?php foreach($phones as $k => $c): ?>
											<option data-icon="flag-icon flag-icon-<?=strtolower($k)?>" data-tokens="<?=$k?> <?=$c['name']?> <?=$c['code']?>" value="<?=$c['code']?>"<?=($k=='US'?' selected':'')?>>(+<?=$c['code']?>)</option>
										<?php endforeach; ?>
									</select>
								</div>
								<input type="phone" name="phone" value="<?php echo ($rs ? $rs['phone'] : '') ?>" placeholder="<?=$lang['restaurant']['de_phone']?>" class="inp">
							</div>

						</div>
						<div class="form-group">
							<label><?=$lang['restaurant']['de_email']?>: <small class="text-danger">*</small></label>
							<input type="email" name="email" value="<?php echo ($rs ? $rs['email'] : '') ?>" placeholder="<?=$lang['restaurant']['de_email']?>">
						</div>
						<div class="form-group">
							<label><?=$lang['restaurant']['de_delivery']?>: <small class="text-danger">*</small></label>
							<input type="text" name="delivery_time" value="<?php echo ($rs ? $rs['delivery_time'] : '') ?>" placeholder="15-25 min">
						</div>
						<div class="form-row">
							<div class="col">
								<div class="form-group">
									<label><?=$lang['restaurant']['de_cuisine']?>: <small class="text-danger">*</small></label>
									<select class="selectpicker" data-live-search="true" data-width="100%" name="cuisine[]" title="<?=$lang['restaurant']['de_cuisine_l']?>" multiple>
										<?php
										$c_sql = $db->query("SELECT * FROM ".prefix."cuisines ORDER BY name ASC");
										if($c_sql->num_rows):
										while($c_rs = $c_sql->fetch_assoc()):
										?>
										<option data-tokens="<?=$c_rs['name']?>" value="<?=$c_rs['id']?>"<?=($rs && in_array($c_rs['id'], explode(',',$rs['cuisine'])) ? ' selected' : '')?>><?=$c_rs['name']?></option>
										<?php endwhile; ?>
										<?php endif; ?>
										<?php $c_sql->close(); ?>
									</select>
								</div>
							</div>
							<div class="col">
								<div class="form-group">
									<label><?=$lang['restaurant']['de_services']?>: <small class="text-danger">*</small></label>
									<select class="selectpicker" data-width="100%" name="services" title="<?=$lang['restaurant']['de_services_l']?>">
										<option value="1"<?=($rs && 1 == $rs['services'] ? ' selected' : '')?>><?=$lang['restaurant']['de_deliveryand']?></option>
										<option value="2"<?=($rs && 2 == $rs['services'] ? ' selected' : '')?>><?=$lang['restaurant']['de_deliveryonly']?></option>
										<option value="3"<?=($rs && 3 == $rs['services'] ? ' selected' : '')?>><?=$lang['restaurant']['de_pickuponly']?></option>
									</select>
								</div>
							</div>
						</div>

					</div>
					<div class="tab-pane container" id="menu1">

						<div class="row">
							<div class="col-4">
								<div class="form-group">
									<label><?=$lang['cart']['country']?>: <small class="text-danger">*</small></label>
									<select class="selectpicker" data-live-search="true" data-width="100%" name="country" title="<?=$lang['cart']['country_s']?>">
										<?php foreach($countries as $k => $c): ?>
											<option data-tokens="<?=$k?> <?=$c?>" value="<?=$k?>"<?=($rs && $k == $rs['country'] ? ' selected' : '')?>><?=$c?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-4">
								<div class="form-group">
									<label><?=$lang['cart']['city']?>: <small class="text-danger">*</small></label>
									<input type="text" name="city" value="<?php echo ($rs ? $rs['city'] : '') ?>" placeholder="<?=$lang['cart']['city']?>">
								</div>
							</div>
							<div class="col-4">
								<div class="form-group">
									<label><?=$lang['cart']['state']?>: <small class="text-danger">*</small></label>
									<input type="text" name="state" value="<?php echo ($rs ? $rs['state'] : '') ?>" placeholder="<?=$lang['cart']['state']?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-8">
								<div class="form-group">
									<label><?=$lang['cart']['address']?>: <small class="text-danger">*</small></label>
									<input type="text" name="address" value="<?php echo ($rs ? $rs['address'] : '') ?>" placeholder="<?=$lang['cart']['address']?>">
								</div>
							</div>
							<div class="col-4">
								<div class="form-group">
									<label><?=$lang['cart']['zip']?>: <small class="text-danger">*</small></label>
									<input type="text" name="zip" value="<?php echo ($rs ? $rs['zipcode'] : '') ?>" placeholder="<?=$lang['cart']['zip']?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label><?=$lang['restaurant']['de_maps']?>:</label>
							<input type="text" name="maps" value="<?php echo ($rs ? $rs['maps'] : '') ?>" placeholder="https://www.google.com/maps/place...">
						</div>

					</div>

					<div class="tab-pane container" id="menu2">
						<input id="images" name="images[]" type="file" multiple>
						<div class="pt-image-append">
							<?php
							if($rs):
							$sql_img = $db->query("SELECT * FROM ".prefix."images WHERE table_name = 'restaurants' && table_id = '{$rs['id']}'");
							if($sql_img->num_rows):
							while($rs_img = $sql_img->fetch_assoc()):
							?>
							<div>
								<span class="pt-select-profile bg-o pt-btn tips"><i class="fas fa-user"></i><b><?=$lang['restaurant']['de_profile']?></b></span>
								<span class="pt-select-cover bg-gr pt-btn tips"><i class="fas fa-image"></i><b><?=$lang['restaurant']['de_cover']?></b></span>
								<span class="pt-select-delete bg-gy pt-btn tips"><i class="fas fa-trash-alt"></i><b><?=$lang['restaurant']['de_delete']?></b></span>
								<img src="<?=$rs_img['url']?>" onerror="this.src='<?=noimage?>'">
							</div>
							<?php
							endwhile;
							endif;
							$sql_img->close();
							endif;
							?>
						</div>

						<input type="hidden" name="profile">
						<input type="hidden" name="cover">
						<input type="hidden" name="eprofile" value="<?php echo ($rs ? $rs['photo'] : '') ?>">
						<input type="hidden" name="ecover" value="<?php echo ($rs ? $rs['cover'] : '') ?>">
					</div>

					<div class="tab-pane container" id="menu3">
						<div class="form-group">
							<label><?=$lang['restaurant']['de_facebook']?>:</label>
							<input type="text" name="facebook" value="<?php echo ($rs ? $rs['facebook'] : '') ?>" placeholder="<?=$lang['restaurant']['de_facebook']?>">
						</div>
						<div class="form-group">
							<label><?=$lang['restaurant']['de_twitter']?>:</label>
							<input type="text" name="twitter" value="<?php echo ($rs ? $rs['twitter'] : '') ?>" placeholder="<?=$lang['restaurant']['de_twitter']?>">
						</div>
						<div class="form-group">
							<label><?=$lang['restaurant']['de_instagram']?>:</label>
							<input type="text" name="instagram" value="<?php echo ($rs ? $rs['instagram'] : '') ?>" placeholder="<?=$lang['restaurant']['de_instagram']?>">
						</div>
						<div class="form-group">
							<label><?=$lang['restaurant']['de_youtube']?>:</label>
							<input type="text" name="youtube" value="<?php echo ($rs ? $rs['youtube'] : '') ?>" placeholder="<?=$lang['restaurant']['de_youtube']?>">
						</div>
					</div>

					<div class="tab-pane container" id="menu4">
						<div class="form-group">
							<label><?=$lang['monday']?>:</label>
							<input type="text" name="working_hours[1]" value="<?php echo (isset($rs['working_hours'][1])) ? $rs['working_hours'][1] : '' ; ?>" placeholder="10:00 am - 7:00 pm">
						</div>
						<div class="form-group">
							<label><?=$lang['tuesday']?>:</label>
							<input type="text" name="working_hours[2]" value="<?php echo (isset($rs['working_hours'][2])) ? $rs['working_hours'][2] : '' ; ?>" placeholder="10:00 am - 7:00 pm">
						</div>
						<div class="form-group">
							<label><?=$lang['wednesday']?>:</label>
							<input type="text" name="working_hours[3]" value="<?php echo (isset($rs['working_hours'][3])) ? $rs['working_hours'][3] : '' ; ?>" placeholder="10:00 am - 7:00 pm">
						</div>
						<div class="form-group">
							<label><?=$lang['thursday']?>:</label>
							<input type="text" name="working_hours[4]" value="<?php echo (isset($rs['working_hours'][4])) ? $rs['working_hours'][4] : '' ; ?>" placeholder="10:00 am - 7:00 pm">
						</div>
						<div class="form-group">
							<label><?=$lang['friday']?>:</label>
							<input type="text" name="working_hours[5]" value="<?php echo (isset($rs['working_hours'][5])) ? $rs['working_hours'][5] : '' ; ?>" placeholder="10:00 am - 7:00 pm">
						</div>
						<div class="form-group">
							<label><?=$lang['saturday']?>:</label>
							<input type="text" name="working_hours[6]" value="<?php echo (isset($rs['working_hours'][6])) ? $rs['working_hours'][6] : '' ; ?>" placeholder="10:00 am - 7:00 pm">
						</div>
						<div class="form-group">
							<label><?=$lang['sunday']?>:</label>
							<input type="text" name="working_hours[7]" value="<?php echo (isset($rs['working_hours'][7])) ? $rs['working_hours'][7] : '' ; ?>" placeholder="10:00 am - 7:00 pm">
						</div>
					</div>
				</div>


			</div>

			<div class="modal-footer">
				<button type="submit" class="pt-btn"><?=$lang['send']?></button>
				<input type="hidden" name="id" value="<?php echo ($rs ? $rs['id'] : '') ?>">
			</div>

		</form>
		<?php else: ?>
		<div class="table-responsive">
		<table class="table">
			<thead>
				<th colspan="2"><?=$lang['restaurant']['menu_name']?></th>
				<th class="text-center"><?=$lang['restaurant']['author']?></th>
				<th class="text-center"><?=$lang['restaurant']['menu']?></th>
				<th class="text-center"><?=$lang['restaurant']['items']?></th>
				<th class="text-center"><?=$lang['created_at']?></th>
				<th class="text-center"><?=$lang['updated_at']?></th>
				<th></th>
			</thead>
			<tbody>
				<?php
				$sql = $db->query("SELECT * FROM ".prefix."restaurants");
				if($sql->num_rows):
				while($rs = $sql->fetch_assoc()):
				?>
				<tr>
					<th width="1"><div class="pt-thumb"><img src="<?=path?>/<?=$rs['photo']?>" alt="<?=$rs['name']?>" onerror="this.src='<?=noimage?>'"></div></th>
					<td>
						<h3><a href="<?=path?>/restaurants.php?id=<?=$rs['id']?>&t=<?=fh_seoURL($rs['name'])?>"><?=$rs['name']?></a></h3>
						<p><span><i class="icons icon-location-pin"></i> <?=$rs['address']?> <?=$rs['city']?> <?=$rs['country']?></span></p>
					</td>
					<td class="text-center"><?=fh_user($rs['author'])?></td>
					<td class="text-center"><?php echo db_rows("menus WHERE restaurant = '{$rs["id"]}'") ?></td>
					<td class="text-center"><?php echo db_rows("items WHERE restaurant = '{$rs["id"]}'") ?></td>
					<td class="text-center"><?=fh_ago($rs['created_at'])?></td>
					<td class="text-center"><?=($rs['updated_at']?fh_ago($rs['updated_at']):'--')?></td>
					<td class="pt-dot-options">
						<a class="pt-options-link"><i class="fas fa-ellipsis-h"></i></a>
						<ul class="pt-drop">
							<li><a href="<?=path?>/dashboard.php?pg=menu&mi=<?=$rs['id']?>"><i class="fas fa-poll"></i> <?=$lang['restaurant']['menu']?></a></li>
							<li><a href="<?=path?>/dashboard.php?pg=restaurants&request=new&id=<?=$rs['id']?>"><i class="far fa-edit"></i> <?=$lang['dash']['edit']?></a></li>
							<li><a href="#" class="pt-delete" data-id="<?=$rs['id']?>" data-type="restaurant"><i class="fas fa-trash-alt"></i> <?=$lang['dash']['delete']?></a></li>
						</ul>
					</td>
				</tr>
				<?php endwhile; ?>
				<?php else: ?>
					<tr>
						<td colspan="7" class="text-center"><?=$lang['alerts']['no-data']?></td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
		</div>
		<?php endif; ?>
	</div>
</div>
