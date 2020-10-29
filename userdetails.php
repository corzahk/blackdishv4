<?php


include __DIR__."/header.php";
if(!us_level){
	fh_go(path);
	exit;
}

if($id && db_rows("users WHERE id = '{$id}'") && us_level == 6) {
	$sql = $db->query("SELECT * FROM ".prefix."users WHERE id = '{$id}'");
	$rs = $sql->fetch_assoc();

	$u_firstname = $rs['firstname'];
	$u_lastname = $rs['lastname'];
	$u_username = $rs['username'];
	$u_email = $rs['email'];
	$u_gender = $rs['gender'];
	$u_photo = $rs['photo'];
	$u_address = $rs['address'];
	$u_city = $rs['city'];
	$u_country = $rs['country'];
	$u_state = $rs['state'];
	$u_phone = $rs['phone'];
	$u_plan = $rs['plan'];
	$tttt = " (".$rs['username'].")";
} else {
	$u_firstname = us_firstname;
	$u_lastname = us_lastname;
	$u_username = us_username;
	$u_email = us_email;
	$u_gender = us_gender;
	$u_photo = us_photo;
	$u_address = us_address;
	$u_city = us_city;
	$u_country = us_country;
	$u_state = us_state;
	$u_phone = us_phone;
	$u_plan = us_plan;
	$tttt = '';
}

?>

<div class="pt-breadcrumb-p">
	<div class="container">
		<h3><?=$lang['details']['title']?></h3>
		<p><?=$lang['details']['desc']?></p>
	</div>
</div>

<div class="container">



<div class="pt-userdetails">
	<form class="pt-senduserdetails">
		<div class="file-upload">
		  <div class="file-select">
		    <div class="file-select-button" id="fileName"><?=$lang['details']['image_c']?></div>
		    <div class="file-select-name" id="noFile"><?=$lang['details']['image_n']?></div>
		    <input type="file" name="chooseFile" id="chooseFile">
		  </div>
		</div>
		<div id="thumbnails"><img src="<?=($u_photo ? $u_photo : nophoto)?>" onerror="this.src='<?=nophoto?>'" class="nophoto" /></div>
		<div class="form-row">
			<div class="col">
				<div class="form-group">
					<label><?=$lang['details']['firstname_l']?></label>
					<input type="text" name="reg_firstname" value="<?=$u_firstname?>" placeholder="<?=$lang['details']['firstname']?>" />
				</div>
			</div>
			<div class="col">
				<div class="form-group">
					<label><?=$lang['details']['lastname_l']?></label>
					<input type="text" name="reg_lastname" value="<?=$u_lastname?>" placeholder="<?=$lang['details']['lastname']?>" />
				</div>
			</div>
		</div>
		<div class="form-group">
			<label><?=$lang['details']['username_l']?>:</label>
			<input type="text" name="reg_username" value="<?=$u_username?>" placeholder="<?=$lang['details']['username']?>" />
		</div>
		<div class="form-group">
			<label><?=$lang['details']['email_l']?>:</label>
			<input type="text" name="reg_email" value="<?=$u_email?>" placeholder="<?=$lang['details']['email']?>" />
		</div>
		<div class="form-group">
			<label><?=$lang['details']['password_l']?>:</label>
			<input type="password" name="reg_pass" placeholder="<?=$lang['details']['password']?>" />
		</div>
		<div class="form-group">
			<label><?=$lang['details']['phone']?></label>
			<div class="pt-phone">
				<div class="pt-flags">
					<select class="selectpicker" data-live-search="true" data-width="100%" name="reg_phone_code">
						<?php foreach($phones as $k => $c): ?>
							<option data-icon="flag-icon flag-icon-<?=strtolower($k)?>" data-tokens="<?=$k?> <?=$c['name']?> <?=$c['code']?>" value="<?=$c['code']?>"<?=($u_phone ? (preg_match("/\+{$c['code']}/i", $u_phone)?' selected':''):'')?>>(+<?=$c['code']?>)</option>
						<?php endforeach; ?>
					</select>
				</div>
				<input type="phone" name="reg_phone" value="<?=preg_replace("/\(.*\)/i","",$u_phone)?>" placeholder="000-000-0000" class="inp">
			</div>
		</div>
		<div class="form-inline mb-3">
			<label><?=$lang['details']['gender']?></label>
			<div class="form-group">
				<input type="radio" name="reg_gender" id="sradio1" value="1" class="choice" <?=($u_gender == 1 ? 'checked' : '')?>>
				<label for="sradio1"><?=$lang['details']['male']?></label>
			</div>
			<div class="form-group">
				<input type="radio" name="reg_gender" id="sradio2" value="2" class="choice" <?=($u_gender == 2 ? 'checked' : '')?>>
				<label for="sradio2"><?=$lang['details']['female']?></label>
			</div>
		</div>
		<div class="form-row">
			<div class="col">
				<div class="form-group">
					<label><?=$lang['details']['country_l']?></label>
					<div class="pt-country">
						<select class="selectpicker" name="reg_country" plaveholder="<?=$lang['details']['country']?>" data-live-search="true" data-width="100%">
							<?php foreach ($countries as $key => $value): ?>
								<option data-icon="flag-icon flag-icon-<?=strtolower($key)?>" value="<?=$key?>" data-tokens="<?=$key?> <?=$value?>"<?=($key==$u_country?' selected':'')?>><?=$value?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="form-group">
					<label><?=$lang['details']['state_l']?></label>
					<input type="text" name="reg_state" value="<?=$u_state?>" placeholder="<?=$lang['details']['state']?>">
				</div>
			</div>
			<div class="col">
				<div class="form-group">
					<label><?=$lang['details']['city_l']?></label>
					<input type="text" name="reg_city" value="<?=$u_city?>" placeholder="<?=$lang['details']['city']?>">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label><?=$lang['details']['address_l']?></label>
			<input type="text" name="reg_address" value="<?=$u_address?>" placeholder="<?=$lang['details']['address']?>" />
		</div>
		<?php if ( us_level == 6 ): ?>
		<div class="form-inline">
			<label class="mr-4"><b><?=$lang['details']['plan']?></b></label>
			<?php
			$sql = $db->query("SELECT * FROM ".prefix."plans");
			while($v = $sql->fetch_assoc()):
			?>
			<div class="form-group">
				<input class="choice" id="cb<?=$v['id']?>" value="<?=$v['id']?>" name="reg_plan" type="radio"<?=($u_plan == $v['id'] ? ' checked' : '')?>/>
				<label class="tgl-btn" for="cb<?=$v['id']?>"><?=$v['plan']?></label>
			</div>
			<?php
			endwhile;
			$sql->close();
			?>
		</div>

		<?php endif; ?>
		<div class="modal-footer mt-5">
			<button type="submit" class="pt-btn">
				<?=$lang['details']['button']?> <i class="fas fa-arrow-circle-right"></i>
			</button>
			<input type="hidden" name="reg_id" value="<?=($id ? $id : '')?>" />
			<input type="hidden" name="reg_photo" rel="#dropZone" value="<?=$u_photo?>" />
		</div>
	</form>
</div>


</div>

<?php
include __DIR__."/footer.php";
?>
